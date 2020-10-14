<?php include './components/header.php';

$docenti = $argo->docenti();

?>
<main>

    <div class="container">
        <h3 class="header">Condivisione Documenti</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection with-header">

                    <?php for ($x = 0; $x < count($docenti); $x++) { ?>
                        <li class="collection-header">
                            <p><b><?= $docenti[$x]['docente']['nome'] . ' ' . $docenti[$x]['docente']['cognome'] ?></b> <?= $docenti[$x]['materie'] ?></p>
                        </li>
                        <?php
                            $file = $argo->condivisionefile($docenti[$x]['prgAnagrafe']);
                            if (empty($file)) echo '<li class="collection-item"><b>Nessun documento condiviso!</b></li>';
                            
                            for ($i = 0; $i < count($file); $i++) {
                            ?>
                                <li class="collection-item avatar">
                                    <i class="material-icons circle blue darken-1">description</i>
                                    <span class="title"><b><?= dataLeggibile($file[$i]['datDocumento']) ?> - <?= $file[$i]['desCartella'] ?></b></span>
                                    <?php if (isset($file[$i]['desMessaggio'])) echo '<p>' . $file[$i]['desMessaggio'] . '</p>'; ?>
                                    <?php if (isset($file[$i]['desFileFisico'])) {
                                        echo '<p class="valign-wrapper"><i class="material-icons" style="margin-right: .5rem">attachment</i>';
                                        echo "<a href='https://www.portaleargo.it/famiglia/api/rest/documentocondiviso?id=FFF" . $codice . "EEEDO" . str_pad($file[$i]['prgAnagrafe'], 5 ,"0", STR_PAD_LEFT) . str_pad($file[$i]['prgFile'], 10 ,"0", STR_PAD_LEFT) . str_replace('-', '', $token) . "ax6542sdru3217t4eesd9'>" . $file[$i]['desFile']  . "</a>";
                                        echo '</p>';
                                    } ?>
                                    <?php if (isset($file[$i]['desUrl'])) { ?>
                                        <p class="valign-wrapper"><i class="material-icons" style="margin-right: .5rem">link</i> <a target="_blank" href="<?= $file[$i]['desUrl'] ?>"><?= $file[$i]['desUrl'] ?></a></p>
                                    <?php } ?>
                                </li>
                            <?php  
                            }
                        ?>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
