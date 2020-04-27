<?php include './components/header.php';

$note = $argo->noteDisciplinari();

?>
<main>

    <div class="container">
        <h3 class="header">Note Disciplinari</h3>
        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($note); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle red">new_releases</i>
                            <span class="title">Nota del <?= dataLeggibile($note[$x]['datNota']) ?> (<?= substr($note[$x]['oraNota'], -5) ?>)</span>
                            <?php if ($note[$x]['flgVisualizzata'] != 'S') {
                                echo ('<a class="secondary-content tooltipped" data-position="top" data-tooltip="Non è stata presa visione!"><i class="material-icons">error_outline</i></a>');
                            } ?>
                            <p><?= $note[$x]['desNota'] ?> <br> <?= $note[$x]['docente'] ?></p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>

<?php include './components/footer.php'; ?>
