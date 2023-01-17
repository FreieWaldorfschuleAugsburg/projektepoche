<?php

namespace App\Controllers;

use App\Entities\Project;
use CodeIgniter\HTTP\RedirectResponse;
use function App\Helpers\getSlotById;
use function App\Helpers\getSlots;

class ProjectController extends BaseController
{
    public function index(): string
    {
        return $this->render('project/ProjectsAdminView', ['projects' => getProjects()]);
    }

    public function create(): string
    {
        return $this->render('project/ProjectCreateView', ['slots' => getSlots(), 'users' => getUsers()]);
    }

    public function handleCreate(): RedirectResponse
    {
        $name = $this->request->getPost('name');
        $slotId = $this->request->getPost('slot');
        $maxMembers = $this->request->getPost('maxMembers');
        $room = $this->request->getPost('room');
        if (!isset($room)) {
            $room = "";
        }
        $leaderIds = $this->request->getPost('leaders');
        $memberIds = $this->request->getPost('members');
        if (!isset($memberIds)) {
            $memberIds = [];
        }
        $description = $this->request->getPost('description');

        if (!isset($name) || !isset($slotId) || !isset($leaderIds) || !isset($description)) {
            return redirect('users')->with('error', 'project.error.parameterMissing');
        }

        $slot = getSlotById($slotId);
        if (is_null($slot)) {
            return redirect('projects')->with('error', 'project.error.invalidSlot');
        }

        foreach ($leaderIds as $id) {
            if (is_null(getUserById($id))) {
                return redirect('projects')->with('error', 'project.error.invalidUser');
            }
        }

        foreach ($memberIds as $memberId) {
            if (is_null(getUserById($memberId))) {
                return redirect('projects')->with('error', 'project.error.invalidUser');
            }
        }

        $project = new Project();
        $project->setName($name);
        $project->setSlotId($slotId);
        $project->setMaxMembers($maxMembers);
        $project->setRoom($room);
        $project->setDescription($description);
        insertProject($project, $leaderIds, $memberIds);

        return redirect('projects')->with('success', 'project.success.projectCreated');
    }

    public function redistribute(): string|RedirectResponse
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            return redirect('projects')->with('error', 'project.error.parameterMissing');
        }

        $project = getProjectById($id);
        if (is_null($project)) {
            return redirect('projects')->with('error', 'project.error.invalidProject');
        }

        return $this->render('project/ProjectRedistributeView', ['project' => $project]);
    }

    public function handleMove(): RedirectResponse
    {
        $userId = $this->request->getGet('user');
        $slotId = $this->request->getGet('slot');
        $projectId = $this->request->getGet('project');
        $newProjectId = $this->request->getGet('newProject');

        if (!isset($userId) || !isset($slotId) || !isset($projectId)) {
            return redirect('projects')->with('error', 'project.error.parameterMissing');
        }

        $user = getUserById($userId);
        if (is_null($user)) {
            return redirect('projects')->with('error', 'project.error.invalidUser');
        }

        $slot = getSlotById($slotId);
        if (is_null($slot)) {
            return redirect('projects')->with('error', 'project.error.invalidSlot');
        }

        $project = getProjectById($projectId);
        if (is_null($project)) {
            return redirect('projects')->with('error', 'project.error.invalidProject');
        }

        $newProject = getProjectById($newProjectId);
        if (is_null($newProject)) {
            return redirect('projects')->with('error', 'project.error.invalidProject');
        }

        removeProjectMember($projectId, $userId);
        addProjectMember($newProjectId, $userId);

        return redirect()->to(previous_url());
    }

    public function edit(): string|RedirectResponse
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            return redirect('projects')->with('error', 'project.error.parameterMissing');
        }

        $project = getProjectById($id);
        if (is_null($project)) {
            return redirect('projects')->with('error', 'project.error.invalidProject');
        }

        return $this->render('project/ProjectEditView', ['project' => $project, 'slots' => getSlots(), 'users' => getUsers()]);
    }

    public function handleEdit(): RedirectResponse
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $slotId = $this->request->getPost('slot');
        $maxMembers = $this->request->getPost('maxMembers');
        $room = $this->request->getPost('room');
        if (!isset($room)) {
            $room = "";
        }
        $leaderIds = $this->request->getPost('leaders');
        $memberIds = $this->request->getPost('members');
        if (!isset($memberIds)) {
            $memberIds = [];
        }
        $description = $this->request->getPost('description');

        if (!isset($id) || !isset($name) || !isset($slotId) || !isset($leaderIds) || !isset($description)) {
            return redirect('users')->with('error', 'project.error.parameterMissing');
        }

        $slot = getSlotById($slotId);
        if (is_null($slot)) {
            return redirect('projects')->with('error', 'project.error.invalidSlot');
        }

        foreach ($leaderIds as $leaderId) {
            if (is_null(getUserById($leaderId))) {
                return redirect('projects')->with('error', 'project.error.invalidUser');
            }
        }

        foreach ($memberIds as $memberId) {
            if (is_null(getUserById($memberId))) {
                return redirect('projects')->with('error', 'project.error.invalidUser');
            }
        }

        $project = getProjectById($id);
        if (is_null($project)) {
            return redirect('projects')->with('error', 'project.error.invalidProject');
        }

        $project->setName($name);
        $project->setSlotId($slotId);
        $project->setMaxMembers($maxMembers);
        $project->setRoom($room);
        $project->setDescription($description);
        updateProject($project, $leaderIds, $memberIds);

        return redirect('projects')->with('success', 'project.success.projectUpdated');
    }

    public function delete(): RedirectResponse
    {
        $id = $this->request->getGet('id');
        if (!isset($id)) {
            return redirect('projects')->with('error', 'project.error.parameterMissing');
        }

        $project = getProjectById($id);
        if (is_null($project)) {
            return redirect('projects')->with('error', 'project.error.invalidProject');
        }

        deleteProjectById($id);
        return redirect('projects')->with('success', 'project.success.projectDeleted');
    }
}