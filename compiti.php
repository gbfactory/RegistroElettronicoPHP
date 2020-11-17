<?php include './components/header.php'; 

$compiti = $argo->compiti();

?>
<main>
    <div class="container">

        <h3 class="header">Compiti Assegnati</h3>

        <hr>

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
            }
        </style>

        <div class="row">
            <div class="col s12">
                <?php for ($x = 0; $x < count($materie); $x++) { ?>
                    <div class="chip">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" value="<?= str_replace(' ', '', $materie[$x]) ?>" />
                            <span><?= $materie[$x] ?></span>
                        </label>
                    </div>
                <?php } ?>
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
