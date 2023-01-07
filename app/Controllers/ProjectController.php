<?php

namespace App\Controllers;

use App\Entities\Project;
use App\Entities\ProjectLeaderMapping;
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
        return $this->render('project/ProjectCreateView', ['slots' => getSlots(), 'leaders' => getUsers()]);
    }

    public function handleCreate(): RedirectResponse
    {
        $name = $this->request->getPost('name');
        $slotId = $this->request->getPost('slot');
        $leaderIds = $this->request->getPost('leaders');
        $description = $this->request->getPost('description');

        $slot = getSlotById($slotId);
        if (is_null($slot)) {
            return redirect('users')->with('error', 'project.error.invalidSlot');
        }

        foreach ($leaderIds as $id) {
            if (is_null(getUserById($id))) {
                return redirect('users')->with('error', 'project.error.invalidUser');
            }
        }

        $project = new Project();
        $project->setName($name);
        $project->setSlotId($slotId);
        $project->setDescription($description);
        $projectId = insertProject($project);

        foreach ($leaderIds as $id) {
            $mapping = new ProjectLeaderMapping();
            $mapping->setUserId($id);
            $mapping->setProjectId($projectId);
            insertProjectLeaderMapping($mapping);
        }

        return redirect('projects')->with('success', 'project.success.projectCreated');
    }

    public function edit(): string|RedirectResponse
    {
    }

    public function handleEdit(): string|RedirectResponse
    {
    }

    public function delete(): string|RedirectResponse
    {
    }
}