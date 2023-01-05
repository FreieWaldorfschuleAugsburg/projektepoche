<?php

namespace App\Controllers;

class VoteController extends BaseController {
    
    public function index() {
        $db = db_connect('default');
        
        $inputData = [];
        $slotRow = $db->query('SELECT * FROM projektepoche_slots');
        $slotCount = $slotRow->getNumRows();
        $voteCount = 3;

        for ($slotId = 1; $slotId <= $slotCount; $slotId++) { 
            for ($voteId = 1; $voteId <= $voteCount; $voteId++) {
                $field = 'S' . $slotId . 'V' . $voteId;
                $inputData[$slotId][$voteId] = $this->request->getPost($field) != null ? $this->request->getPost($field) : 0;
            }
        }

        $dummySlotCount = $slotCount+1;
        $inputData[$dummySlotCount][1] = $this->request->getPost('TOP1');
        $inputData[$dummySlotCount][2] = $this->request->getPost('TOP2');

        for ($slotId = 1; $slotId <= count($inputData); $slotId++) {
            $data = $inputData[$slotId];
            for ($voteId = 1; $voteId <= count($data); $voteId++) {
                $value = $data[$voteId];

                if ($value == 0) {
                    if ($slotId > $slotCount) {
                        return $this->errorRedirect($inputData, 'Priorisierung fehlerhaft! Priorisiere zwei der oben bereits gewählten Kurse!');
                    } else if($slotId != 1 || session('USER')->group_id != 4) {
                        return $this->errorRedirect($inputData, 'Kurs bei <b>' . $slotId . '. Zeitschiene/' . $voteId . '. Wahl</b> nicht gesetzt!');
                    }
                } else {
                    if ($slotId > $slotCount) {
                        if ($this->countOccurance($slotCount, $inputData, $value) == 0) {
                            return $this->errorRedirect($inputData, '<b>Priorisierung fehlerhaft!</b> Priorisiere zwei der oben bereits gewählten Kurse!');
                        }
    
                        if ($this->countOccurance($dummySlotCount, $inputData, $value) > 2) {
                            return $this->errorRedirect($inputData, '<b>Priorisierung fehlerhaft!</b> Priorisiere zwei unterschiedliche Kurse!');
                        }
                    } else {
                        if ($this->countOccurance($slotCount, $inputData, $value) > 1) {
                            return $this->errorRedirect($inputData, 'Kurs bei <b>' . $slotId . '. Zeitschiene/' . $voteId . '. Wahl</b> bereits gewählt!');
                        }
                    }
                }
            }
        }

        if (!$this->checkColor($inputData)) {
            return $this->errorRedirect($inputData, '<b>Auswahl unzulässig!</b> Bitte wähle <b>min. drei blaue (theoretische)</b> und <b>min. drei gelbe (praktische)</b> Kurse!');
        }

        for ($slotId = 1; $slotId <= count($inputData); $slotId++) { 
            for ($voteId = 1; $voteId <= count($inputData[$slotId]); $voteId++) {
                $db->table('projektepoche_votes')->insert(['user_id' => session('USER')->id, 'slot_id' => $slotId <= $slotRow->getNumRows() ? $slotId : null, 'vote_id' => $voteId, 
                'project_id' => $inputData[$slotId][$voteId] != 0 ? $inputData[$slotId][$voteId] : null]);
            }
        }

        $db->table('projektepoche_users')->set('vote', true)->where('id', session('USER')->id)->update();
        $user = session('USER');
        $user->vote = true;
        session()->set('USER', $user);

        return redirect('dashboard');
    }

    public function countOccurance($slots, $data, $id) {
        $count = 0;
        for ($slotId=1; $slotId <= $slots; $slotId++) { 
            $item = $data[$slotId];
            $count += isset(array_count_values($item)[$id]) ? array_count_values($item)[$id] : 0;
        }
        return $count;
    }

    public function checkColor($data) {
        $blue = 0;
        $yellow = 0;

        $db = db_connect('default');
        for ($slotId=1; $slotId <= count($data)-1; $slotId++) {
            $slotData = $data[$slotId];
            for ($voteId = 1; $voteId <= count($slotData); $voteId++) {
                $id = $data[$slotId][$voteId];
                if ($id != 0) {
                    $row = $db->query('SELECT * FROM projektepoche_projects WHERE id = ?', [$id])->getRow();
                    if ($row->color == 'YELLOW') {
                        $yellow++;
                    } else {
                        $blue++;
                    }
                }
            }
        }
        return $yellow >= 3 && $blue >= 3;
    }

    public function errorRedirect($inputData, $error) {
        return redirect('dashboard')->with('inputData', $inputData)->with('error', $error);
    }
}