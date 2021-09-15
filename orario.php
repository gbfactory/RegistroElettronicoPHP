<?php
$cod = "ora";
$titolo = "Orario Classe";

include './components/header.php';

$orario = $argo->orario();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <?php
                    for ($x = 0; $x < count($orario); $x++) {
                        if (($x > 0 && $orario[$x]['giorno'] != $orario[$x - 1]['giorno']) || ($x == 0)) {
                            if ($x != 0) echo '</ul>';
                            echo '<ul class="collection with-header card">';
                            echo '<li class="collection-header"><h5>' . $orario[$x]['giorno'] . '</h5></li>';
                        }

                        if (isset($orario[$x]['lezioni'])) {
                            echo '<li class="collection-item"><div>' . $orario[$x]['numOra'] . '° ora - ' . $orario[$x]['lezioni'][0]['materia'] . ' ' . $orario[$x]['lezioni'][0]['docente'] . '</div></li>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>