<?php

namespace App\Controllers;

class UsersController extends BaseController {
    
    public function index() {
        if (!session('USER') || !session('GROUP')){
            return redirect('login')->with('error', 'Sitzung abgelaufen. Erneut anmelden!');
        }

        $users = [];

        $db = db_connect('default');
        $query = $db->table('projektepoche_users')->select('*')->get();
        foreach ($query->getResult() as $item) {
            $group = $db->table('projektepoche_groups')->where('id', $item->group_id)->get()->getRow();
            $vote = $db->query('SELECT * FROM projektepoche_votes WHERE user_id = ?', [$item->id])->getNumRows() == 0;

            array_push($users, ['user' => $item, 'group' => $group, 'vote' => $vote]);
        }

        return $this->view('UsersView', ['users' => $users]);
    }

    public function toggleLocked() {
        if (!session('USER') || !session('GROUP')){
            return redirect('login')->with('error', 'Sitzung abgelaufen. Erneut anmelden!');
        }
    }

    public function print() {
        if (!session('USER') || !session('GROUP')){
            return redirect('login')->with('error', 'Sitzung abgelaufen. Erneut anmelden!');
        }

        $id = $this->request->getGet('id');

        $db = db_connect('default');
        $row = $db->table('projektepoche_users')->where('id', $id)->get()->getRow();

        $this->view('UserPrintView', ['row' => $row, 'noNav' => true]);
    }
}