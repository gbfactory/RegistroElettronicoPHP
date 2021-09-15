<?php
$cod = "prf";
$titolo = "Docenti Classe";

include './components/header.php';

$docenti = $argo->docenti();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <ul class="collection card">
                        <?php for ($x = 0; $x < count($docenti); $x++) { ?>
                            <li class="collection-item avatar">
                                <i class="material-icons circle <?php if (strpos($docenti[$x]['docente']['nome'], 'Coordinatore') !== false) {
                                                                    echo 'red';
                                                                } ?>">face</i>
                                <span class="title"><b><?= $docenti[$x]['docente']['nome'] ?> <?= $docenti[$x]['docente']['cognome'] ?></b></span>
                                <?php
                                $materie = explode(',', rimuovi_parentesi($docenti[$x]['materie']));
                                for ($i = 0; $i < count($materie); $i++) {
                                    echo "<p>$materie[$i]</p>";
                                }
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>