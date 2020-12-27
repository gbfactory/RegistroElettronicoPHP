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

        <style>
            .chip {
                padding: 5px 12px;
                overflow: hidden;
            }
        </style>

        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <ul class="collection">
                        <?php
                        for ($x = 0; $x < count($compiti); $x++) {
                            $datCompiti = $compiti[$x]['datCompiti'];
                            $datGiorno = $compiti[$x]['datGiorno'];
                            ?>
                            <li class="collection-item avatar" data-id="<?= str_replace(' ', '', $compiti[$x]['desMateria']) ?>">
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
                            <h5 style="margin: 0">Filtro Materie</h5>
                            <div class="section">
                                <?php for ($x = 0; $x < count($materie); $x++) { ?>
                                    <div class="chip">
                                        <label>
                                            <input type="checkbox" class="filled-in" checked="checked" value="<?= str_replace(' ', '', $materie[$x]) ?>" />
                                            <span><?= $materie[$x] ?></span>
                                        </label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                $('input[type="checkbox"]').click(function(){
                    var inputValue = $(this).attr("value");
                    $("[data-id='" + inputValue + "']").toggle();
                });
            });
        </script>

    </div>
</main>

<?php include './components/footer.php'; ?>
