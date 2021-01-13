<?php
$cod = "arg";
$titolo = "Argomenti Lezione";

include './components/header.php';

$argomenti = $argo->argomenti();
?>

<main>
    <div class="container">        
        <?php if (empty($argomenti)) { ?>
            <div class="center">
                <h5>Non ci sono argomenti!</h5>
            </div>
        <?php } ?>

        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <ul class="collection with-header">
                        <?php for ($x = 0; $x < count($argomenti); $x++) { ?>
                            <?php if ($x == 0) { ?>
                                <li class="collection-header"><h5><?= data_bella($argomenti[$x]['datGiorno']); ?></h5></li>
                            <?php } else if ($argomenti[$x]['datGiorno'] != $argomenti[$x - 1]['datGiorno'] && $x != 0) { ?>
                                <li class="collection-header"><h5><?= data_bella($argomenti[$x]['datGiorno']); ?></h5></li>
                            <?php } ?>
                            <li class="collection-item avatar">
                                <i class="material-icons circle blue darken-2">reorder</i>

                                <span class="title"><?= $argomenti[$x]['desMateria'] ?></span>

                                <p><?= linkCliccabili($argomenti[$x]['desArgomento']) ?></p>

                                <p><i><?= rimuovi_parentesi($argomenti[$x]['docente']); ?></i></p>

                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="section">
                    <div class="card">
                        <div class="card-content">
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="ricerca_argomenti">
                                <label for="ricerca_argomenti">Cerca argomento...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // https://stackoverflow.com/questions/52592173/search-for-an-item-in-a-list-using-jquery-filter/52592294
            $("#ricerca_argomenti").on("keyup", function() {
                var value = this.value.toLowerCase().trim();
                $(".collection li").show().filter(function() {
                    return $(this).text().toLowerCase().trim().indexOf(value) == -1;
                }).hide();
            });
        </script>
    </div>
</main>

<?php include './components/footer.php'; ?>