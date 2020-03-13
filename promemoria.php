<?php include './components/header.php'; 

$memo = $argo->promemoria();

?>
<main>

    <div class="container">
        <h3 class="header">Promemoria</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">

                <?php for ($x = 0; $x < count($memo); $x++) { ?>
                        <li class="collection-item avatar">
                            <?php
                            
                            $dataMemo = $memo[$x]['datGiorno'];
                            $oggi = date('Y-m-d');

                            // Colore compiti
                            if ($dataMemo > $oggi) {
                                $color = 'yellow';
                            } else if ($dataMemo < $oggi) {
                                $color = 'green';
                            } else if ($dataMemo == $oggi) {
                                $color = 'red';
                            }

                            ?>

                            <i class="material-icons circle <?= $color ?>">book</i>
                            <span class="title">Promemoria per il <b> <?= $memo[$x]['datGiorno'] ?> </b></span>
                            <p><?= $memo[$x]['desAnnotazioni'] ?></p>
                            <p><i><?= $memo[$x]['desMittente'] ?></i></p>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
