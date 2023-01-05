<?php

namespace App\Controllers;

use function App\Helpers\getSlotsWithProjectAndUser;

class DashboardController extends BaseController {
    
    public function index() {
        $data = [];
        $db = db_connect('default');
        $data = [...getSlotsWithProjectAndUser()];
        $votes = [];
        $voteRow = $db->query('SELECT * FROM projektepoche_votes WHERE user_id = ?', [session('USER')->id]);
        $voteCount = $voteRow->getNumRows();
        foreach ($voteRow->getResult() as $vote) {
            $slot = $db->table('projektepoche_slots')->select('*')->where('id', $vote->slot_id)->get()->getRow();
            $project = $db->table('projektepoche_projects')->select('*')->where('id', $vote->project_id)->get()->getRow();
            $votes[$vote->slot_id != null ? $vote->slot_id : 4][$vote->vote_id] = ['id' => $vote->project_id, 'slot' => $slot, 'project' => $project];
        }

        $voteOpen = $db->table('projektepoche_settings')->select('*')->get()->getRow()->vote;
        return $this->render('DashboardView', ['data' => $data, 'votes' => $votes, 'mayVote' => $voteCount == 0, 'voteOpen' => $voteOpen]);
    }
}