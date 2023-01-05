<?php

namespace App\Controllers;

use function App\Helpers\getSlots;

class LandingPageController extends BaseController
{

    public function index()
    {
        // Redirect to dashboard if user is logged in
        if (session('USER') && session('GROUP')) {
            return redirect('dashboard');
        }

        $db = db_connect('default');
        $data = [];
        $slots = getSlots();
        foreach ($slots as $slot) {
            $projects = [];
            $projectResults = getProjectsBySlotId($slot->id);
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