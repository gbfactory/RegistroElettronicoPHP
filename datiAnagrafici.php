<?php include './components/header.php';

$request = $argo->schede();

?>
<main>

   <div class="container">
      <h3 class="header">Dati Anagrafici</h3>
      <hr>
      <div class="row">
         <div class="col s12">
            <table>
               <tr>
                  <td>Alunno</td>
                  <td><?= $request[0]["alunno"]["desCognome"] ?> <?= $request[0]["alunno"]["desNome"] ?></td>
               </tr>
               <tr>
                  <td>Data di Nascita</td>
                  <td><?= dataLeggibile($request[0]["alunno"]["datNascita"]) ?></td>
               </tr>
               <tr>
                  <td>Sesso</td>
                  <td><?= $request[0]["alunno"]["flgSesso"] ?></td>
               </tr>
               <tr>
                  <td>Codice Fiscale</td>
                  <td><?= $request[0]["alunno"]["desCf"] ?></td>
               </tr>
               <tr>
                  <td>Comune di Nascita</td>
                  <td><?= $request[0]["alunno"]["desComuneNascita"] ?></td>
               </tr>
               <tr>
                  <td>Cittadinanza</td>
                  <td><?= $request[0]["alunno"]["desCittadinanza"] ?></td>
               </tr>
               <tr>
                  <td>Comune di Residenza</td>
                  <td><?= $request[0]["alunno"]["desComuneResidenza"] ?> (<?= $request[0]["alunno"]["desCap"] ?>)</td>
               </tr>
               <tr>
                  <td>Via</td>
                  <td><?= $request[0]["alunno"]["desVia"] ?></td>
               </tr>
               <tr>
                  <td>Comune di Recapito</td>
                  <td><?= $request[0]["alunno"]["desComuneRecapito"] ?> (<?= $request[0]["alunno"]["desCapResidenza"] ?>)</td>
               </tr>
               <tr>
                  <td>Via di Recapito</td>
                  <td><?= $request[0]["alunno"]["desIndirizzoRecapito"] ?></td>
               </tr>
               <tr>
                  <td>Telefono</td>
                  <td><?= $request[0]["alunno"]["desTelefono"] ?></td>
               </tr>
               <tr>
                  <td>Cellulare</td>
                  <td><?= $request[0]["alunno"]["desCellulare"] ?></td>
               </tr>
            </table>
         </div>
      </div>
   </div>
</main>

<?php include './components/footer.php'; ?>
