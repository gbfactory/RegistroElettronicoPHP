<?php include './components/header.php';

$docenti = $argo->docenti();

?>
<main>

    <div class="container">
        <h3 class="header">Ricevimento docenti</h3>

        <hr>

        <div class="row">
            <div class="col s12">

                <?php 
                
                $prenotazioni = $argo->prenotazioniricevimento();
                print('<pre>');
                print_r($prenotazioni);
                print('</pre>');

                ?>

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

                                <?php for ($i=0; $i < count($disponibilita); $i++) { ?>
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

    </div>
</main>

<?php include './components/footer.php'; ?>
