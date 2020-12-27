<?php
$cod = "ric";
$titolo = "Ricevimento Docenti";

include './components/header.php';

$docenti = $argo->docenti();
$prenotazioni = $argo->prenotazioniricevimento();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m8">
                <div class="section">
                    <?php for ($x = 0; $x < count($prenotazioni); $x++) { ?>
                        <?php $item = $prenotazioni[$x]; ?>
                        <div class="card">
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12 m6">
                                        <p><b>Docente: </b> <?= $item['docente']['nome'] ?> <?= $item['docente']['cognome'] ?></p>
                                        <p><b>Data: </b> <?= dataLeggibile($item['datDisponibilita']); ?></p>
                                        <p><b>Ora: </b> dalle ore <?= $item['dalleOre']; ?> alle <?= $item['alleOre']; ?></p>
                                        <p>Prenotazione numero <?= $item['prenotazioneNum']; ?> eseguita il <?= dataLeggibile($item['datPrenotazione']) ?> alle ore <?= $item['oraPrenotazione'] ?> </p>
                                    </div>
                                    <div class="col s12 m6">
                                        <p><b>Genitore: </b> <?= $item['genitore']['nome'] ?> <?= $item['genitore']['cognome'] ?></p>
                                        <p><b>Email genitore: </b> <?= $item['emailGenitore'] ?></p>
                                        <p><b>Telefono genitore: </b> <?= $item['telefonoGenitore'] ?></p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card-action">
                            <a class="waves-effect waves-light btn modal-trigger">Annulla</a>
                        </div> -->
                        </div>
                    <?php } ?>

                    <ul class="collapsible">

                        <?php for ($x = 0; $x < count($docenti); $x++) { ?>
                            <li>
                                <div class="collapsible-header">
                                    <p><b><?= $docenti[$x]['docente']['nome'] . ' ' . $docenti[$x]['docente']['cognome'] ?></b> <?= $docenti[$x]['materie'] ?></p>
                                </div>
                                <div class="collapsible-body">
                                    <?php
                                    $disponibilita = $argo->disponibilitadocente($docenti[$x]['prgAnagrafe']);
                                    if (empty($disponibilita)) echo '<b>Nessun ricevimento disponibile!</b>';
                                    ?>

                                    <?php for ($i = 0; $i < count($disponibilita); $i++) { ?>
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <div class="card">
                                                    <div class="card-content">
                                                        <p><b>Giorno:</b> <?= dataLeggibile($disponibilita[$i]['datDisponibilita']); ?> dalle <?= $disponibilita[$i]['dalleOre']; ?> alle <?= $disponibilita[$i]['alleOre']; ?></p>
                                                        <p><b>Prenotazioni:</b> <?= $disponibilita[$i]['prenotazioneNum']; ?> occupati su <?= $disponibilita[$i]['maxPrenotazioni']; ?> disponibili</p>
                                                        <p><b>Luogo:</b> <?= $disponibilita[$i]['luogoRicevimento']; ?></p>
                                                        <p><b>Note:</b> <?= $disponibilita[$i]['nota']; ?></p>
                                                        <p><b>Prenotare entro il <?= dataLeggibile($disponibilita[$i]['datScadenza']); ?></b></p>
                                                    </div>
                                                    <div class="card-action">
                                                        <a class="waves-effect waves-light btn modal-trigger" href="#modal<?= $disponibilita[$i]['prgAnagrafe']; ?><?= $i; ?>">Prenota</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="#modal<?= $disponibilita[$i]['prgAnagrafe']; ?><?= $i; ?>" class="modal">
                                            <div class="modal-content">
                                                <h4>Modal Header</h4>
                                                <p>A bunch of text</p>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    print('<pre>');
                                    print_r($disponibilita);
                                    print('</pre>');
                                    ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="section">
                    <div class="card">
                        <div class="card-content">
                            <h5>Hai prenotato <?= count($prenotazioni) ?> ricevimenti</h5>
                            <a class="waves-effect waves-light btn" style="width: 100%" href="prenota.php">prenota nuovo</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>