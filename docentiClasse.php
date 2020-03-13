<?php include './components/header.php'; 

$prof = $argo->docenti();

?>
<main>

    <div class="container">
        <h3 class="header">Docenti Classe</h3>
        
        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">

                <?php for ($x = 0; $x < count($prof); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle">face</i>
                            <span class="title"><?= $prof[$x]['docente']['nome'] . ' ' . $prof[$x]['docente']['cognome'] ?> </b></span>
                            <p><?= str_replace(array('(', ')'), '', $prof[$x]['materie']) ?></p>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
