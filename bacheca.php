<?php include './components/header.php';

$bacheca = $argo->bacheca();

?>
<main>

    <div class="container">
        <h3 class="header">Bacheca</h3>

        <hr>

        <div class="row">
            <div class="col s12">
                <ul class="collection">
                    <?php for ($x = 0; $x < count($bacheca); $x++) { ?>
                        <li class="collection-item avatar">
                            <i class="material-icons circle">date_range</i>

                            <span class="title"><b><?= dataLeggibile($bacheca[$x]['datGiorno']) ?> - <?= $bacheca[$x]['desOggetto'] ?></b></span>

                            <p><?= $bacheca[$x]['desMessaggio'] ?></p>

                            <?php if ($bacheca[$x]['desUrl']) { ?>
                                <p><b>Url:</b> <a href="<?= $bacheca[$x]['desUrl'] ?>"><?= $bacheca[$x]['desUrl'] ?></a></p>
                            <?php } ?>

                            <?php if (isset($bacheca[$x]['allegati'][0])) {
                                for($i = 0; $i < count($bacheca[$x]['allegati']); $i++) { ?>
                                    <p><b>Allegato:</b> <a href="<?= "http://www.portaleargo.it/famiglia/api/rest/messaggiobachecanuova?id=FFF" . $codice . "EEEII000010000000" . str_pad($bacheca[$x]['allegati'][$i]['prgMessaggio'], 3 ,"0", STR_PAD_LEFT) . str_replace('-', '', $token) . "ax6542sdru3217t4eesd9"; ?>">
                                    <?= $bacheca[$x]['allegati'][$i]['desFile'] ?></a></p>
                            <?php }
                            } ?>

                            <?php if ($bacheca[$x]['richiediPv'] == 1) {
                                if ($bacheca[$x]['dataConfermaPresaVisione']) { ?>
                                    <p><b>Presa visione:</b> Confermata in data <?= $bacheca[$x]['dataConfermaPresaVisione'] ?> </p>
                                <?php } else { ?>
                                    <p><b>Presa visione:</b> <a class="pv" id="pv<?= $bacheca[$x]['prgMessaggio'] ?>" onclick="presaVisione(<?= $bacheca[$x]['prgMessaggio'] ?>)">Non confermata</a></p>
                                <?php }
                            } ?>

                            <?php if ($bacheca[$x]['richiediAd'] == 1) {
                                if ($bacheca[$x]['adesione'] != 1) { ?>
                                    <p><b>Adesione:</b> Non confermata 
                                    
                                    <?php
                                    if ($bacheca[$x]['datScadenzaAdesione'] != "") {
                                        echo '(Confermabile entro il ' . dataLeggibile($bacheca[$x]['datScadenzaAdesione']) . ')';
                                    }
                                    ?>    
                                
                                    </p>

                                <?php } else { ?>
                                    <p><b>Adesione:</b> Confermata in data <?= $bacheca[$x]['dataConfermaAdesione'] ?>
                                    
                                    <?php
                                    if ($bacheca[$x]['adesioneModificabile'] == 1) {
                                        echo '(Adesione modificabile';
                                        if ($bacheca[$x]['datScadenzaAdesione'] != "") {
                                            echo ' entro il ' . dataLeggibile($bacheca[$x]['datScadenzaAdesione']);
                                        }
                                        echo ')';
                                    }
                                    ?>

                                     </p>

                                <?php }
                            }
                            
                            ?>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <?php //print('<pre> ' . print_r($bacheca, true) . '</pre>'); ?>

    </div>
</main>

<script>
    function presaVisione(id) {
        console.log(id);

        $.ajax({
            type: "POST",
            url: "https://www.portaleargo.it/famiglia/api/rest/presavisionebachecanuova",
            headers: {
                "x-version": "2.4.3",
                "x-key-app": "ax6542sdru3217t4eesd9",
                "x-app-code": "APF",
                "x-prg-scheda": 1,
                "x-prg-alunno": <?= intval($codAlunno) ?>,
                "x-auth-token": "<?= $token; ?>",
                "x-produttore-software": "ARGO Software s.r.l. - Ragusa",
                "x-cod-min": "Sg26685",
                "x-prg-scuola": 1,
            },
            data: JSON.stringify({
                "presaVisione": true,
                "prgMessaggio": id
            }),
            contentType: 'application/json',
            success: function(data) {
                // console.log(data);
                M.toast({html: data['message']})

                if (data['message'] != "Per confermare la presa visione, è necessario scaricare almeno un allegato.") {
                    $(`#pv${id}`).replaceWith(` Confermata in data ${new Date().toLocaleDateString()}`);
                }
            },
            error: function(errMsg) {
                // console.log(errMsg);
                M.toast({html: 'Errore!'})
            }
        });
    }
</script>

<?php include './components/footer.php'; ?>
