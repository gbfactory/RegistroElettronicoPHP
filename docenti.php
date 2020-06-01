<?php include './components/header.php';

$docenti = $argo->docenti();

?>
<main>

    <div class="container">
        <h3 class="header">Docenti Classe</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">

                    <?php for ($x = 0; $x < count($docenti); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle <?php if (strpos($docenti[$x]['docente']['nome'], 'Coordinatore') !== false) { echo 'red'; } ?>">face</i>
                            <span class="title"><?= $docenti[$x]['docente']['nome'] . ' ' . $docenti[$x]['docente']['cognome'] ?> </b></span>
                            <p><?= str_replace(array('(', ')'), '', $docenti[$x]['materie']) ?></p>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
