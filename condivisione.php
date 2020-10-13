<?php include './components/header.php';

$docenti = $argo->docenti();

?>
<main>

    <div class="container">
        <h3 class="header">Documenti Docenti</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection with-header">

                    <?php for ($x = 0; $x < count($docenti); $x++) { ?>
                        <li class="collection-header">
                            <span class="title"><?= $docenti[$x]['docente']['nome'] . ' ' . $docenti[$x]['docente']['cognome'] ?> </b></span>
                            <p><?= str_replace(array('(', ')'), '', $docenti[$x]['materie']) ?></p>
                        </li>
                        <li class="collection-item">

                            <ul class="collection">
                                <?php
                                    $file = $argo->condivisionefile($docenti[$x]['prgAnagrafe']);
                                    if (empty($file)) echo '<b>Nessun file condiviso!</b>';

                                    for ($i = 0; $i < count($file); $i++) {
                                    ?>
                                        <li class="collection-item avatar">
                                            <i class="material-icons circle">date_range</i>
                                            <span class="title"><b><?= $file[$i]['datDocumento'] ?> - <?= $file[$i]['desCartella'] ?></b></span>
                                            <p><?= $file[$i]['desMessaggio'] ?></p>
                                            <p>📎 <a href="<?= "https://www.portaleargo.it/famiglia/api/rest/documentocondiviso?id=FFF" . $codice . "EEEDO" . str_pad($file[$i]['prgAnagrafe'], 5 ,"0", STR_PAD_LEFT) . str_pad($file[$i]['prgFile'], 10 ,"0", STR_PAD_LEFT) . str_replace('-', '', $token) . "ax6542sdru3217t4eesd9" ?>"><?= $file[$i]['desFile'] ?></a></p>
                                            <p>🔗 <a href="<?= $file[$i]['desUrl'] ?>"><?= $file[$i]['desUrl'] ?></a></p>
                                        </li>
                                    <?php  
                                    }
                                ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
