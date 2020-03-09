<?php include './components/header.php'; 

$argomenti = $argo->argomenti();

?>
<main>

    <div class="container">
        <h3>News</h3>

        <div class="row">
            
            <?php
                $json = file_get_contents('http://www.iiseuganeo.cloud/wp-json/wp/v2/posts');
                $posts = json_decode($json);

                //echo($json);
                //print_r($posts);

                for ($x = 0; $x < count($posts); $x++) { ?>
                    <div class="col s12">
                        <div class="card horizontal">
                            <!--<div class="card-image">
                                <img src="https://lorempixel.com/100/190/nature/6">
                            </div>-->
                            <div class="card-stacked">
                                <div class="card-content">
                                    <span class="card-title grey-text text-darken-4"><?= $posts[$x]->title->rendered ?></span>
                                    <?= $posts[$x]->content->rendered ?>
                                    </div>
                                    <div class="card-action">
                                    <a class="waves-effect waves-light btn" href="<?= $posts[$x]->link ?>">LEGGI ORIGINALE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <script>
                    var x = document.getElementsByTagName("img").length;

                    for (i = 0; i < x; i++) {
                        document.getElementsByTagName("img")[i].removeAttribute("srcset"); 
                    }

                </script>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
