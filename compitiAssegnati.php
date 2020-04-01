<?php include './components/header.php'; 

$compiti = $argo->compiti();

// https://stackoverflow.com/questions/5341168/best-way-to-make-links-clickable-in-block-of-text
function make_links_clickable($text){
    return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
}

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

                                    // Data
                                    $datCompitiSplit = explode('-', $compiti[$x]['datCompiti']);
                                    $datCompiti = $datCompitiSplit[2] . '/' . $datCompitiSplit[1] . '/' . $datCompitiSplit[0];

                                    $datGiornoSplit = explode('-', $compiti[$x]['datGiorno']);
                                    $datGiorno = $datGiornoSplit[2] . '/' . $datGiornoSplit[1] . '/' . $datCompitiSplit[0];

                                    if ($compiti[$x]['datGiorno'] == $compiti[$x]['datCompiti']) {
                                        echo('<p>Assegnati il <b>' . $datGiorno . '</b></p>');
                                    } else {
                                        echo('<p>Assegnati il <b>' . $datGiorno . '</b> per il <b>' . $datCompiti . '</b></p>');
                                    }
                                ?>
                            <p>
                                <?= make_links_clickable($compiti[$x]['desCompiti']) ?> <br> <?= $compiti[$x]['docente'] ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
