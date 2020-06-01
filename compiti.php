<?php include './components/header.php'; 

$compiti = $argo->compiti();

?>
<main>
    <div class="container">

        <h3 class="header">Compiti Assegnati</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($compiti); $x++) { ?>
                        <li class="collection-item avatar">

                            <?php
                            
                            $dataCompiti = $compiti[$x]['datGiorno'];
                            $oggi = date('Y-m-d');

                            // Colore compiti
                            if ($dataCompiti > $oggi) {
                                $color = 'yellow';
                            } else if ($dataCompiti < $oggi) {
                                $color = 'green';
                            } else if ($dataCompiti == $oggi) {
                                $color = 'red';
                            }

                            ?>

                            <i class="material-icons circle <?= $color ?>">book</i>
                            <span class="title"><?= $compiti[$x]['desMateria'] ?></span>
                                <?php

                                    $datCompiti = dataLeggibile($compiti[$x]['datCompiti']);
                                    $datGiorno = dataLeggibile($compiti[$x]['datGiorno']);

                                    if ($compiti[$x]['datGiorno'] == $compiti[$x]['datCompiti']) {
                                        echo('<p>Assegnati il <b>' . $datGiorno . '</b></p>');
                                    } else {
                                        echo('<p>Assegnati il <b>' . $datGiorno . '</b> per il <b>' . $datCompiti . '</b></p>');
                                    }
                                ?>
                            <p>
                                <?= linkCliccabili($compiti[$x]['desCompiti']) ?> <br> <?= $compiti[$x]['docente'] ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>

<?php include './components/footer.php'; ?>
