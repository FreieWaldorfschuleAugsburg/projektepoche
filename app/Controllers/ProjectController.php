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
        $leaderIds = $this->request->getPost('leaders');
        $memberIds = $this->request->getPost('members');
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
        $project->setDescription($description);
        insertProject($project, $leaderIds, $memberIds);

        return redirect('projects')->with('success', 'project.success.projectCreated');
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
        $leaderIds = $this->request->getPost('leaders');
        $memberIds = $this->request->getPost('members');
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
            return redirect('projects')->with('error', 'project.error.invalidUser');
        }

        deleteProjectById($id);
        return redirect('projects')->with('success', 'project.success.projectDeleted');
    }
}