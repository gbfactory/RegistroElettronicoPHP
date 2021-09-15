<?php
$cod = "arg";
$titolo = "Argomenti Lezione";

include './components/header.php';

$argomenti = $argo->argomenti();
?>

<main>
    <div class="container">
        <?php
        $materie = [];
        for ($x = 0; $x < count($argomenti); $x++) {
            if (!in_array($argomenti[$x]['desMateria'], $materie)) {
                array_push($materie, $argomenti[$x]['desMateria']);
            }
        }
        ?>

        <div class="row">
            <div class="section">
                <div class="col s12 m8">
                    <ul class="collection card with-header">
                        <?php for ($x = 0; $x < count($argomenti); $x++) { ?>
                            <?php if ($x == 0) { ?>
                                <li class="collection-header">
                                    <h5><?= data_bella($argomenti[$x]['datGiorno']); ?></h5>
                                </li>
                            <?php } else if ($argomenti[$x]['datGiorno'] != $argomenti[$x - 1]['datGiorno'] && $x != 0) { ?>
                                <li class="collection-header">
                                    <h5><?= data_bella($argomenti[$x]['datGiorno']); ?></h5>
                                </li>
                            <?php } ?>
                            <li class="collection-item avatar" data-id="<?= str_replace(' ', '', $argomenti[$x]['desMateria']) ?>">
                                <i class="material-icons circle blue darken-2">reorder</i>

                                <span class="title"><?= $argomenti[$x]['desMateria'] ?></span>

                                <p><?= linkCliccabili($argomenti[$x]['desArgomento']) ?></p>

                                <p><i><?= rimuovi_parentesi($argomenti[$x]['docente']); ?></i></p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Ricerca</span>
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="ricercaArgomenti">
                                <label for="ricercaArgomenti">Cerca argomento...</label>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Filtro Materie</span>
                            <?php for ($x = 0; $x < count($materie); $x++) { ?>
                                <p class="filter-item">
                                    <label>
                                        <input type="checkbox" id="filtro-materie" checked="checked" value="<?= str_replace(' ', '', $materie[$x]) ?>" />
                                        <span><?= $materie[$x] ?></span>
                                    </label>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Ricerca (https://stackoverflow.com/questions/52592173/)
                $("#ricercaArgomenti").on("keyup", function() {
                    var value = this.value.toLowerCase().trim();
                    $(".collection li").show().filter(function() {
                        return $(this).children('p').text().toLowerCase().trim().indexOf(value) == -1;
                    }).hide();
                });

                // Filtro checkbox
                $('input[type="checkbox"]').click(function() {
                    var inputValue = $(this).attr("value");
                    $("[data-id='" + inputValue + "']").toggle();
                });
            });
        </script>
    </div>
</main>

<?php include './components/footer.php'; ?>