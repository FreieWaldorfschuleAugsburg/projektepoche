<?php

return [
    'headline' => 'Projekte',
    'buttons' => [
        'create' => 'Projekt erstellen',
        'print' => 'Gesamtübersicht drucken',
        'printOverview' => 'Projektliste drucken',
        'back' => 'Zurück'
    ],
    'leader' => 'Kursleitung:',
    'fields' => [
        'name' => 'Name',
        'slot' => 'ZS',
        'maxMembers' => 'Max. TN',
        'room' => 'Raum',
        'leaders' => 'Leitung',
        'members' => 'TN',
        'conflict' => [
            'title' => 'Konflikt?',
            'yes' => 'Ja',
            'no' => 'Nein'
        ],
        'description' => 'Beschreibung',
        'selectable' => [
            'title' => 'Wählbar?',
            'yes' => 'Ja',
            'no' => 'Nein'
        ],
        'actions' => [
            'title' => 'Aktionen'
        ]
    ],
    'create' => [
        'headline' => 'Projekt erstellen',
        'button' => 'Erstellen'
    ],
    'error' => [
        'parameterMissing' => 'Ein notwendiger Parameter fehlt!',
        'invalidProject' => 'Ein ungültiges Projekt wurde angegeben!',
        'invalidUser' => 'Ein ungültiger Benutzer wurde angegeben!',
        'invalidSlot' => 'Ein ungültiger Slot wurde angegeben!',
        'voteStillOpen' => 'Die Gesamtübersicht kann erst erstellt werden, wenn die Wahl beendet wurde!'
    ],
    'success' => [
        'projectCreated' => 'Projekt erfolgreich erstellt.',
        'projectUpdated' => 'Projekt erfolgreich editiert.',
        'projectDeleted' => 'Projekt erfolgreich gelöscht.'
    ],
    'redistribute' => [
        'headline' => 'Projekteilnehmer umverteilen',
        'fields' => [
            'name' => 'Name',
            'actions' => [
                'title' => 'Aktionen',
                'auto' => 'Automatische Zuweisung<br/>',
                'manual' => 'Manuelle Zuweisung'
            ]
        ],
        'buttons' => [
            'submit' => 'Zuweisen'
        ]
    ],
    'edit' => [
        'headline' => 'Projekt editieren',
        'button' => 'Editieren'
    ],
    'view' => [
        'leader' => 'Projektleitung',
        'maxMembers' => 'Maximale Teilnehmerzahl',
        'room' => 'Raum',
        'clock' => 'Uhr'
    ],
    'print' => [
        'info' => 'Informationen',
        'members' => [
            'title' => 'Teilnehmer*innen',
            'description' => 'Sie sind als Kursleiter*in dazu <u>verpflichtet</u> Schülerabsenzen zu dokumentieren! <br>Öffnen Sie hierfür über untenstehenden QR-Code das <b><i>Schulportal</i></b>.'
        ],
        'overview' => [
            'title' => 'Projektliste'
        ],
        'total' => [
            'title' => 'Gesamtübersicht',
            'blocked' => '-/-'
        ],
        'fields' => [
            'leaders' => 'Projektleitung',
            'maxMembers' => 'Maximale Teilnehmerzahl',
            'room' => 'Raum'
        ]
    ],
    'leading' => [
        'title' => 'Ihre Projekte',
        'notPublic' => 'Die Teilnehmerliste steht noch nicht fest, da die Ergebnisse der Projektwahl noch nicht veröffentlicht sind!'
    ]
];
