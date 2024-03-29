<?php

return [
    'headline' => 'Wahl',
    'buttons' => [
        'showProjects' => 'Projekte anzeigen',
        'export' => 'Stimmergebnisse exportieren',
        'state' => [
            'close' => 'Wahl beenden',
            'open' => 'Wahl öffnen',
            'public' => 'Ergebnis veröffentlichen',
        ],
        'assign' => 'Automatische Zuweisung starten',
        'reset' => 'Daten zurücksetzen'
    ],
    'fields' => [
        'name' => 'Name'
    ],
    'votes' => [
        'noData' => 'k. A.',
    ],
    'voting' => [
        'headline' => 'Abstimmen',
        'blocked' => 'Blockiert! Diese Zeitschiene ist für dich blockiert.',
        'select' => 'Bitte wählen...',
        'slot' => [
            'details' => '<b>Wähle pro Zeitschiene drei Projekte in absteigender Priorität!</b> <br/> (d. h. das Projekt, das dir am meisten zusagt, ist das Erste, dass das dir am wenigsten zusagt das Letzte) <br> <div class="alert alert-danger"><b>Öffne vor der Wahl bitte oben das Menü <i>Projekte anzeigen</i> und lese dir die Beschreibungen der Projekte aufmerksam durch. <br/> Eventuell stehen dort Voraussetzungen, die du nicht erfüllen kannst.</b></div>'
        ],
        'global' => [
            'headline' => 'Priorisierung',
            'details' => '<b>Wähle zwei priorisierte Projekte!</b> <br/> Wähle zwei Projekte aus den neun Projekten, die du oben gewählt hast, aus die dir besonders wichtig sind. <br/> (ev. kannst du dann z. B. in einer anderen Zeitschiene daran teilnehmen)'
        ],
        'error' => [
            'voteClosed' => 'Die Wahl wurde bereits beendet.',
            'notVoted' => 'Es wurde nicht gewählt.',
            'voteMissing' => 'Es wurden keine Angaben für <b>%s / %s</b> gemacht.',
            'duplicateProject' => 'Projekt in <b>%s</b> doppelt angegeben.',
        ],
        'success' => 'Wahl erfolgreich!',
        'stateChangeSuccess' => 'Der Wahlzustand wurde erfolgreich geändert!',
        'assignSuccess' => 'Die automatische Zuweisung wurde erfolgreich durchgeführt!',
        'resetSuccess' => 'Alle Daten erfolgreich gelöscht!',
        'submit' => 'Wahl absenden',
        'reportError' => 'Fehler melden'
    ],
    'result' => [
        'headline' => 'Deine Projekte',
        'details' => '<b>Du wirst folgende Projekte während der Projektepoche besuchen dürfen:</b>',
        'members' => 'Teilnehmer*innen:'
    ],
    'closed' => [
        'headline' => 'Wahl geschlossen!',
        'details' => 'Die Wahl hat noch nicht begonnen, oder wurde bereits beendet.'
    ]
];
