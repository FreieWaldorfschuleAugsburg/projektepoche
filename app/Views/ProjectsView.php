<?php 
foreach ($data as $item) {

    echo '<div class="row gx-4 mt-3 justify-content-center"><div class="col-lg-10">
    <div class="card"><div class="card-header"><b>Zeitschiene ' . $item['slot']->id . ':</b> ' . convert($item['slot']->start_time) . ' - ' . convert($item['slot']->end_time) . ' Uhr</div>
    <div class="card-body"><div class="accordion accordion-flush" id="SLOT'. $item['slot']->id .'">';

    foreach ($item['projects'] as $project) {
        echo '<div class="accordion-item">
        <h2 class="accordion-header" id="heading'. $project['handle']->id . '">
            <button class="accordion-button collapsed; rounded" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse'. $project['handle']->id . '" aria-expanded="false" aria-controls="collapse'. $project['handle']->id . '"
                style="' . ($project['handle']->color === 'BLUE' ? 'background-color:#506AD4; color:white' : 'background-color:#FAEB8D; color:#102A42') . '" ;>
                <b>'. $project['handle']->name . '</b>
            </button>
        </h2>
        <div id="collapse'. $project['handle']->id . '" class="accordion-collapse collapse" aria-labelledby="heading'. $project['handle']->id . '"
            data-bs-parent="#SLOT'. $item['slot']->id .'">
            <div class="accordion-body">
                <i class="fas fa-user"></i>
                &nbsp;<b>Kursleitung: <i>' . join(', ', $project['teachers']) . '</i></b>
                <hr><br>'. $project['handle']->description . '
            </div>
        </div>
    </div>';
    }

    echo '</div></div></div></div></div>';
}

function convert($input) {
    return substr($input, 0, strlen($input) - 3);
}
?>