<?php

namespace App\Controllers;

class UsersController extends BaseController {
    
    public function index() {
        $result = [];

        foreach (getUsers() as $user) {
            $group = getGroupById($user->group_id);


            $vote = $db->query('SELECT * FROM projektepoche_votes WHERE voter_id = ?', [$user->id])->getNumRows() == 0;

            $result[] = ['user' => $user, 'group' => $group, 'vote' => $vote];
        }

        return $this->render('UsersView', ['users' => $result]);
    }

    public function print() {
        $id = $this->request->getGet('id');
        $user = getUserById($id);

        $this->render('UserPrintView', ['user' => $user], false);
    }
}