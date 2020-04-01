<?php include './components/header.php';

$bacheca = $argo->bacheca();

?>
<main>

    <div class="container">
        <h3 class="header">Bacheca</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($bacheca); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle">date_range</i>

                            <span class="title"><b><?= $bacheca[$x]['datGiorno'] ?> - <?= $bacheca[$x]['desOggetto'] ?></b></span>

                            <p><b>Messaggio:</b> <?= $bacheca[$x]['desMessaggio'] ?></p>

                            <?php if ($bacheca[$x]['desUrl']) { ?>
                                <p><b>Url:</b> <a href="<?= $bacheca[$x]['desUrl'] ?>"><?= $bacheca[$x]['desUrl'] ?></a></p>
                            <?php } ?>

                            <?php if (isset($bacheca[$x]['allegati'][0])) { ?>
                                <p><b>Allegati:</b> <a href=""><?= $bacheca[$x]['allegati'][0]['desFile'] ?></a></p>
                            <?php } ?>

                            <?php if ($bacheca[$x]['dataConfermaPresaVisione']) { ?>
                                <p><b>Presa visione:</b> Conferma in data <?= $bacheca[$x]['dataConfermaPresaVisione'] ?> </p>
                            <?php } else { ?>
                                <p><b>Presa visione:</b> <a href="<?= $argoLink ?>">Non confermata</a></p>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <?php //print('<pre> ' . print_r($bacheca, true) . '</pre>'); ?>

    </div>
</main>



<?php include './components/footer.php'; ?>