<?php
$cod = "ang";
$titolo = "Dati Anagrafici";

include './components/header.php';

$anagrafica = $argo->schede()[$scheda];
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="section">
                    <table>
                        <tr>
                            <td>Alunno</td>
                            <td><?= $anagrafica["alunno"]["desCognome"] ?> <?= $anagrafica["alunno"]["desNome"] ?></td>
                        </tr>
                        <tr>
                            <td>Data di Nascita</td>
                            <td><?= dataLeggibile($anagrafica["alunno"]["datNascita"]) ?></td>
                        </tr>
                        <tr>
                            <td>Sesso</td>
                            <td><?= $anagrafica["alunno"]["flgSesso"] ?></td>
                        </tr>
                        <tr>
                            <td>Codice Fiscale</td>
                            <td><?= $anagrafica["alunno"]["desCf"] ?></td>
                        </tr>
                        <tr>
                            <td>Comune di Nascita</td>
                            <td><?= $anagrafica["alunno"]["desComuneNascita"] ?></td>
                        </tr>
                        <tr>
                            <td>Cittadinanza</td>
                            <td><?= $anagrafica["alunno"]["desCittadinanza"] ?></td>
                        </tr>
                        <tr>
                            <td>Comune di Residenza</td>
                            <td><?= $anagrafica["alunno"]["desComuneResidenza"] ?> (<?= $anagrafica["alunno"]["desCap"] ?>)</td>
                        </tr>
                        <tr>
                            <td>Via</td>
                            <td><?= $anagrafica["alunno"]["desVia"] ?></td>
                        </tr>
                        <tr>
                            <td>Comune di Recapito</td>
                            <td><?= $anagrafica["alunno"]["desComuneRecapito"] ?> (<?= $anagrafica["alunno"]["desCapResidenza"] ?>)</td>
                        </tr>
                        <tr>
                            <td>Via di Recapito</td>
                            <td><?= $anagrafica["alunno"]["desIndirizzoRecapito"] ?></td>
                        </tr>
                        <tr>
                            <td>Telefono</td>
                            <td><?= $anagrafica["alunno"]["desTelefono"] ?></td>
                        </tr>
                        <tr>
                            <td>Cellulare</td>
                            <td><?= $anagrafica["alunno"]["desCellulare"] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>