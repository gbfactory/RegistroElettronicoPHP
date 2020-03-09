<?php include './components/header.php'; 

$compiti = $argo->compiti();

?>
<main>

    <div class="container">
        <h3>Compiti Assegnati</h3>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                <?php for ($x = 0; $x < count($compiti); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle amber lighten-2">book</i>
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

                                    if ($compiti[$x]['datGiorno'] == $compiti[$x]['datCompiti']) {
                                        echo('<p>Assegnati il ' . $compiti[$x]['datGiorno'] . '</p>');
                                    } else {
                                        echo('<p>Assegnati il ' . $compiti[$x]['datGiorno'] . ' per il ' . $compiti[$x]['datCompiti'] . '</p>');
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
