<?php
$cod = "bac";
$titolo = "Bacheca";

include './components/header.php';

$bacheca = $argo->bacheca();
?>

<main>

    <div class="container">
        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <ul class="collection card">
                        <?php for ($x = 0; $x < count($bacheca); $x++) { ?>
                            <li class="collection-item avatar" data-pv="<?php
                                                                        if ($bacheca[$x]['richiediPv'] == 1) {
                                                                            if ($bacheca[$x]['dataConfermaPresaVisione']) {
                                                                                echo 'true';
                                                                            } else {
                                                                                echo 'false';
                                                                            }
                                                                        } else {
                                                                            echo 'false';
                                                                        }
                                                                        ?>">
                                <i class="material-icons circle">date_range</i>

                                <span class="title"><b><?= dataLeggibile($bacheca[$x]['datGiorno']) ?> - <?= $bacheca[$x]['desOggetto'] ?></b></span>

                                <p><?= $bacheca[$x]['desMessaggio'] ?></p>

                                <?php if ($bacheca[$x]['desUrl']) { ?>
                                    <p><b>Url:</b> <a href="<?= $bacheca[$x]['desUrl'] ?>"><?= $bacheca[$x]['desUrl'] ?></a></p>
                                <?php } ?>

                                <?php if (isset($bacheca[$x]['allegati'][0])) {
                                    for ($i = 0; $i < count($bacheca[$x]['allegati']); $i++) { ?>
                                        <p><b>Allegato:</b> <a target="_blank" href="viewer.php?prgAllegato=<?= $bacheca[$x]['allegati'][$i]['prgAllegato'] ?>&prgMessaggio=<?= $bacheca[$x]['allegati'][$i]['prgMessaggio'] ?>">
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

            <div class="col s12 m4">
                <div class="section">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Ricerca</span>
                            <div class="input-field">
                                <i class="material-icons prefix">search</i>
                                <input type="text" id="ricercaBacheca">
                                <label for="ricercaBacheca">Cerca argomento...</label>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Filtro</span>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" id="filtro-materie" checked="checked" value="true" />
                                    <span>Presa visione confermata</span>
                                </label>
                            </p>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" id="filtro-materie" checked="checked" value="false" />
                                    <span>Preva visione <b>non</b> confermata</span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        // Ricerca (https://stackoverflow.com/questions/52592173/)
        $("#ricercaBacheca").on("keyup", function() {
            var value = this.value.toLowerCase().trim();
            $(".collection li").show().filter(function() {
                return $(this).children('p').text().toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });

        // Filtro checkbox
        $('input[type="checkbox"]').click(function() {
            var inputValue = $(this).attr("value");
            $("[data-pv='" + inputValue + "']").toggle();
        });
    });

    // Funzione conferma presa visione
    function presaVisione(id) {
        $.ajax({
            type: "POST",
            url: "https://www.portaleargo.it/famiglia/api/rest/presavisionebachecanuova",
            headers: {
                "x-version": "2.4.3",
                "x-key-app": "ax6542sdru3217t4eesd9",
                "x-app-code": "APF",
                "x-prg-scheda": 1,
                "x-prg-alunno": <?= intval($codAlunno); ?>,
                "x-auth-token": "<?= $token; ?>",
                "x-produttore-software": "ARGO Software s.r.l. - Ragusa",
                "x-cod-min": "<?= $codice; ?>",
                "x-prg-scuola": 1,
            },
            data: JSON.stringify({
                "presaVisione": true,
                "prgMessaggio": id
            }),
            contentType: 'application/json',
            success: function(data) {
                M.toast({
                    html: data['message']
                })

                if (data['message'] != "Per confermare la presa visione, è necessario scaricare almeno un allegato.") {
                    $(`#pv${id}`).replaceWith(` Confermata in data ${new Date().toLocaleDateString()}`);
                }
            },
            error: function(errMsg) {
                M.toast({
                    html: 'Errore!'
                })
            }
        });
    }
</script>

<?php include './components/footer.php'; ?>