<?php
$cod = "ora";
$titolo = "Orario Classe";

include './components/header.php';

$orario = $argo->orario();
?>

<main>
    <div class="container">
        <div class="col s12">
            <div class="section">
                <ul class="collection with-header">
                    <?php
                    for ($x = 0; $x < count($orario); $x++) {

                        if ($x > 0 && $orario[$x]['giorno'] != $orario[$x - 1]['giorno']) {
                            echo '<li class="collection-header"><h5>' . $orario[$x]['giorno'] . '</h5></li>';
                        } else if ($x == 0) {
                            echo '<li class="collection-header"><h5>' . $orario[$x]['giorno'] . '</h5></li>';
                        }

                        if (isset($orario[$x]['lezioni'])) {
                            echo '<li class="collection-item"><div>' . $orario[$x]['numOra'] . '° ora - ' . $orario[$x]['lezioni'][0]['materia'] . ' ' . $orario[$x]['lezioni'][0]['docente'] . '</div></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>