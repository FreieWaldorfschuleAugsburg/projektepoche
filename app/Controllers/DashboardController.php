<?php

namespace App\Controllers;

class DashboardController extends BaseController {
    
    public function index() {
        $data = [];
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

        $votes = [];
        $voteRow = $db->query('SELECT * FROM projektepoche_votes WHERE voter_id = ?', [session('USER')->id]);
        $voteCount = $voteRow->getNumRows();
        foreach ($voteRow->getResult() as $vote) {
            $slot = $db->table('projektepoche_slots')->select('*')->where('id', $vote->slot_id)->get()->getRow();
            $project = $db->table('projektepoche_projects')->select('*')->where('id', $vote->project_id)->get()->getRow();
            $votes[$vote->slot_id != null ? $vote->slot_id : 4][$vote->vote_id] = ['id' => $vote->project_id, 'slot' => $slot, 'project' => $project];
        }

        $voteOpen = $db->table('projektepoche_settings')->select('*')->get()->getRow()->vote;
        return $this->view('DashboardView', ['data' => $data, 'votes' => $votes, 'mayVote' => $voteCount == 0, 'voteOpen' => $voteOpen]);
    }
}