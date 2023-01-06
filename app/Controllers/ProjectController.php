<?php

namespace App\Controllers;

class ProjectController extends BaseController {
    
    public function index(): string
    {
        return $this->render('project/ProjectsAdminView', ['projects' => getProjects()]);
    }
}