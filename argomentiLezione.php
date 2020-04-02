<?php include './components/header.php';

$argomenti = $argo->argomenti();

?>
<main>

<div class="container">
    <h3 class="header">Argomenti Lezioni</h3>

    <hr>

    <div class="row">
        <div class="col s12">

            <input type="text" id="argCerca" placeholder="Cerca argomento...">

            <ul class="collection">
                <?php for ($x = 0; $x < count($argomenti); $x++) { ?>
                    <li class="collection-item avatar">
                        <i class="material-icons circle blue darken-2">reorder</i>

                        <span class="title"><b><?= $argomenti[$x]['desMateria'] ?> - <?= dataLeggibile($argomenti[$x]['datGiorno']) ?></b></span>

                        <p><?= linkCliccabili($argomenti[$x]['desArgomento']) ?></p>

                    </li>
                <?php } ?>
            </ul>
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

    <?php //print('<pre> ' . print_r($argomenti, true) . '</pre>'); ?>

</div>
</main>


<?php include './components/footer.php'; ?>
