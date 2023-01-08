<?php

return [
    'headline' => 'Stimmen',
    'buttons' => [
        'showProjects' => 'Projekte anzeigen'
    ],
    'voting' => [
        'headline' => 'Abstimmen',
        'blocked' => 'Blockiert! Diese Zeitschiene ist für dich blockiert.',
        'select' => 'Bitte wählen...',
        'slot' => [
            'details' => '<b>Wähle pro Zeitschiene drei Projekte in absteigender Priorität!</b> <br/> (d. h. das Projekt, das dir am meisten zusagt, ist das Erste, dass das dir am wenigsten zusagt das Letzte)'
        ],
        'global' => [
            'headline' => 'Priorisierung',
            'details' => '<b>Wähle zwei priorisierte Projekte!</b> <br/> Wähle zwei Projekte aus den neun Projekten, die du oben gewählt hast, aus die dir besonders wichtig sind. <br/> (ev. kannst du dann z. B. in einer anderen Zeitschiene daran teilnehmen)'
        ],
        'error' => [
            'notVoted' => 'Es wurde nicht gewählt.',
            'slotMissing' => 'Es wurden keine Angaben für <b>%s</b> gemacht.',
            'voteMissing' => 'Es wurden keine Angaben für <b>%s / %s</b> gemacht.',
            'duplicateProject' => 'Projekt in <b>%s</b> doppelt angegeben.',
            'notGlobalVoted' => 'Es wurde keine Priorisierung angegeben.',
            'globalDuplicateProject' => 'Projekt in Priorisierung doppelt angegeben.',
            'notSlotVoted' => 'Projekt <b>%s: %s</b> in Priorisierung angegeben, aber nicht gewählt.'
        ],
        'success' => 'Wahl erfolgreich!',
        'submit' => 'Wahl absenden',
        'reportError' => 'Fehler melden'
    ],
    'closed' => [
        'headline' => 'Wahl geschlossen!',
        'details' => 'Die Wahl hat noch nicht begonnen, oder wurde bereits beendet.'
    ]
];
