<?php
$cod = "com";
$titolo = "Compiti Assegnati";

include './components/header.php';

$compiti = $argo->compiti();
?>

<main>
    <div class="container">
        <?php
        $materie = [];
        for ($x = 0; $x < count($compiti); $x++) {
            if (!in_array($compiti[$x]['desMateria'], $materie)) {
                array_push($materie, $compiti[$x]['desMateria']);
            }
        }
        ?>

        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <ul class="collection card">
                        <?php
                        for ($x = 0; $x < count($compiti); $x++) {
                            $datCompiti = $compiti[$x]['datCompiti'];
                            $datGiorno = $compiti[$x]['datGiorno'];
                        ?>
                            <li class="collection-item avatar" data-id="<?= str_replace(' ', '', $compiti[$x]['desMateria']) ?>" data-color="<?= colore_data($datCompiti) ?>">
                                <i class="material-icons circle <?= colore_data($datCompiti) ?>">book</i>
                                <span class="title"><?= $compiti[$x]['desMateria'] ?></span>
                                <p>Assegnati il <b><?= dataLeggibile($datGiorno) ?></b> per il <b><?= dataLeggibile($datCompiti) ?></b></p>
                                <p><?= linkCliccabili($compiti[$x]['desCompiti']) ?></p>
                                <p><i><?= rimuovi_parentesi($compiti[$x]['docente']) ?></i></p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="section">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Filtro Data</span>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" checked="checked" value="yellow" />
                                    <span>PER DOMANI</span>
                                </label>
                            </p>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" checked="checked" value="red" />
                                    <span>PER OGGI</span>
                                </label>
                            </p>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" checked="checked" value="green" />
                                    <span>PASSATI</span>
                                </label>
                            </p>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Filtro Materie</span>
                            <?php for ($x = 0; $x < count($materie); $x++) { ?>
                                <p class="filter-item">
                                    <label>
                                        <input type="checkbox" id="filtro-materie" checked="checked" value="<?= str_replace(' ', '', $materie[$x]) ?>" />
                                        <span><?= $materie[$x] ?></span>
                                    </label>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('input[type="checkbox"]').click(function() {
                    var inputValue = $(this).attr("value");
                    $("[data-id='" + inputValue + "']").toggle();
                    $("[data-color='" + inputValue + "']").toggle();
                });
            });
        </script>

    </div>
</main>

<?php include './components/footer.php'; ?>