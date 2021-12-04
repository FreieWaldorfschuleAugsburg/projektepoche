<div class="row gx-4 mt-3 justify-content-center">
    <div class="col-lg-10">
        <div class="card">
        <div class="card-header">
                <b>Nutzerverwaltung</b>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Passwort</th>
                            <th scope="col">Gruppe</th>
                            <th scope="col">Gewählt?</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                foreach ($users as $item) {
                                  echo '<tr>';
                                  echo '<th>' . $item['user']->name . '</th>';
                                  echo '<td>' . $item['user']->password . '</td>';
                                  echo '<td>' . $item['group']->name . '</td>';
                                  echo '<td>' . ($item['vote'] ? 'Nein' : 'Ja') . '</td>';

                                  echo '<td><a class="btn btn-primary btn-sm" href="' . base_url('user/print') . '?id='. $item['user']->id . '"><i class="fas fa-print"></i> Drucken</button>';
                                  echo '</tr>';
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>