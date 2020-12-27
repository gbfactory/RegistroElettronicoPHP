<?php
$cod = "dal";
$titolo = "Bacheca Alunno";

include './components/header.php';

$bacheca = $argo->bachecaalunno();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="section">
                    <?php if (empty($assenze)) { ?>
                        <div class="center">
                            <h5>Non sono presenti documenti!</h5>
                        </div>
                    <?php } ?>

                    <ul class="collection">
                        <?php for ($x = 0; $x < count($bacheca); $x++) { ?>
                            <li class="collection-item avatar">
                                <i class="material-icons circle">date_range</i>

                                <span class="title"><b><?= $bacheca[$x]['datDocumento'] ?></b></span>

                                <p><b>Messaggio:</b> <?= $bacheca[$x]['desMessaggio'] ?></p>

                                <p><b>File:</b> <a href=""><?= $bacheca[$x]['desFile'] ?></a></p>

                                <?php if ($bacheca[$x]['flgDownloadGenitore'] == "P") { ?>
                                    <p><b>Presa visione:</b> Confermata </p>
                                <?php } else { ?>
                                    <p><b>Presa visione:</b> <a href="<?= $argoLink ?>">Non confermata</a></p>
                                <?php } ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>