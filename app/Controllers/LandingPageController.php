<?php

namespace App\Controllers;

class LandingPageController extends BaseController {
    
    public function index() {
        if (session('USER_ID')) {
            return redirect('dashboard');
        }

        $db = db_connect('default');
        $data = [];
        $slotResults = $db->table('projektepoche_slots')->select('*')->get()->getResult();
        foreach ($slotResults as $slot) {
            $projects = [];
            $projectResults = $db->table('projektepoche_projects')->select('*')->where('slot_id', $slot->id)->get()->getResult();

            foreach ($projectResults as $project) {
                $teachers = [];
                
                $userIdResults = $db->table('projektepoche_projects_teachers_mapping')->select('user_id')->where('project_id', $project->id)->get()->getResult();
                foreach ($userIdResults as $userId) {
                    $user = $db->table('projektepoche_users')->select('name')->where('id', $userId->user_id)->get()->getRow();
                    $first = substr($user->name, 0, 1);
                    array_push($teachers, $first . '. ' . explode(' ', $user->name)[1]);
                }

                array_push($projects, ['handle' => $project, 'teachers' => $teachers]);
            }
            array_push($data, ['slot' => $slot, 'projects' => $projects]);
        }
        return $this->view('LandingPageView', ['data' => $data]);
    }
}