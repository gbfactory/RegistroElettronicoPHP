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
                                    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
                                    $desCompiti = $compiti[$x]['desCompiti'];

                                    if (preg_match($reg_exUrl, $desCompiti, $url)) {
                                        echo('<a href="' . $url[0] . '" class="secondary-content tooltipped" data-tooltip="Vai al Link"><i class="material-icons">link</i></a>');
                                    }

                                    if (strpos(strtolower($desCompiti), 'moodle')) {
                                        echo('<a href="http://www.euganeolearning.cloud/moodle/" class="secondary-content tooltipped" data-tooltip="Vai a Moodle"><i class="material-icons">web</i></a>');
                                    }

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
                            <p><?= preg_replace($reg_exUrl, '<a href="' . $url[0] . '">' . $url[0] . '</a> ', $desCompiti) ?> <br> <?= $compiti[$x]['docente'] ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
