<?php

return [
    'headline' => 'Benutzer',
    'fields' => [
        'firstName' => 'Vorname',
        'lastName' => 'Nachname',
        'grade' => 'Klasse',
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
        'button' => 'Importieren',
        'save' => 'Speichern',
        'headline' => 'Benutzer importieren',
        'desc' => "Hier können Sie die Benutzer aus einer .csv Datei importieren. Unten können Sie die Namen der korrespondierenden Felder in der CSV Datei (die erste Reihe) angeben, welche für den Import verwendet werden sollen",
        'errors' => [
            'gradeNotFound' => "Die ausgewählte Klasse wurde nicht gefunden!",
            'userExists' => "Der Benutzer existiert bereits!",
            'noImport' => 'Es wurden keine Benutzer importiert.'
        ],
        'success' => [
            'saved' => 'Die Benutzer wurden erfolgreich importiert!'
        ]
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
