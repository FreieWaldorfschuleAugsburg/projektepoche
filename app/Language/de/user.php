<?php

return [
    'headline' => 'Benutzer',
    'fields' => [
        'name' => 'Name',
        'password' => 'Passwort',
        'group' => 'Gruppe',
        'vote' => [
            'title' => 'Hat gewählt?',
            'value' => [
                'yes' => 'Ja',
                'no' => 'Nein'
            ]
        ],
        'actions' => [
            'title' => 'Aktionen',
            'print' => 'Drucken',
            'edit' => 'Editieren',
            'delete' => 'Löschen'
        ]
    ],
    'buttons' => [
        'create' => 'Benutzer erstellen',
        'import' => 'Benutzer importieren',
        'back' => 'Zurück'
    ],
    'edit' => [
        'headline' => 'Benutzer editieren',
        'button' => 'Editieren'
    ],
    'create' => [
        'headline' => 'Benutzer erstellen',
        'button' => 'Erstellen'
    ],
    'import' => [
        'headline' => 'Benutzer importieren',
        'desc' => "Hier können Sie die Benutzer aus einer .csv Datei importieren."
    ],
    'print' => [
        'guide' => [
            'headline' => 'Anleitung'
        ],
        'credentials' => [
            'headline' => 'Zugangsdaten'
        ]
    ]
];
