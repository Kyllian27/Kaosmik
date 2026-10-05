<div class="row mb-3 align-items-center">
    <div class="col">
        <div>
            <h1 class="shadow text-white">Historiques de mes missions</h1>
            <span class="text-white">Quels ont été mes anciennes récompenses ?</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-sm" data-toggle="table"
                       data-pagination="true"
                       data-page-size="25">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Credits</th>
                            <th>Energies</th>
                            <th>Experience</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($logged_user->getPlayer()->getMissionResolutions() as $mr) : ?>
                        <tr>
                            <td><?= format_date_fr($mr->created_at);?></td>
                            <td><?= $mr->getMission()->title;?></td>
                            <td><?= $mr->credits_gained;?></td>
                            <td><?= $mr->energy_gained;?></td>
                            <td><?= $mr->experience_gained;?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>