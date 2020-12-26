<?php include './components/header.php';

$argomenti = $argo->argomenti();

?>
<main>
    <div class="container">

        <h3 class="header">Argomenti Lezioni</h3>

        <hr>
        
        <div class="row">
            <div class="col s12">

                <?php if (empty($argomenti)) { ?>
                    <div class="center">
                        <h5>Non ci sono argomenti!</h5>
                    </div>
                <?php } else { ?>
                    <div class="card">
                        <div class="card-content">
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="argCerca">
                                <label for="argCerca">Cerca argomento...</label>
                            </div>
                        </div>
                    </div>

                    <ul class="collection">
                        <?php for ($x = 0; $x < count($argomenti); $x++) { ?>
                            <li class="collection-item avatar">
                                <i class="material-icons circle blue darken-2">reorder</i>

                                <span class="title"><b><?= $argomenti[$x]['desMateria'] ?> - <?= dataLeggibile($argomenti[$x]['datGiorno']) ?></b></span>

                                <p><?= linkCliccabili($argomenti[$x]['desArgomento']) ?></p>

                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>

            </div>
        </div>

        <script>
            // https://stackoverflow.com/questions/52592173/search-for-an-item-in-a-list-using-jquery-filter/52592294
            $("#argCerca").on("keyup", function() {
                var value = this.value.toLowerCase().trim();
                $(".collection li").show().filter(function() {
                    return $(this).text().toLowerCase().trim().indexOf(value) == -1;
                }).hide();
            });
        </script>

    </div>
</main>


<?php include './components/footer.php'; ?>
