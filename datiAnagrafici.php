<?php include './components/header.php'; 

$request = $argo->schede();

?>
<main>

    <style>
    .validate {
        color: black !important;
    }
    </style>

   <div class="container">
     <h3>Dati Anagrafici</h3>
      <div class="row">
         <form class="col s12">
            <div class="row">
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desCognome"] ?> <?= $request[0]["alunno"]["desNome"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Alunno</label>
               </div>
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["datNascita"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Data di Nascita</label>
               </div>
            </div>
            <div class="row">
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["flgSesso"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Sesso</label>
               </div>
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desCf"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Codice Fiscale</label>
               </div>
            </div>
            <div class="row">
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desComuneNascita"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Comune di Nascita</label>
               </div>
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desCittadinanza"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Cittadinanza</label>
               </div>
            </div>
            <div class="row">
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desComuneResidenza"] ?> (<?= $request[0]["alunno"]["desCap"] ?>)" id="disabled" type="text" class="validate">
                  <label for="disabled">Comune di Residenza</label>
               </div>
               <div class="input-field col s6">
                <input disabled value="<?= $request[0]["alunno"]["desVia"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Via</label>
               </div>
            </div>
            <div class="row">
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desComuneRecapito"] ?> (<?= $request[0]["alunno"]["desCapResidenza"] ?>)" id="disabled" type="text" class="validate">
                  <label for="disabled">Comune di Recapito</label>
               </div>
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desIndirizzoRecapito"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Via di Recapitop</label>
               </div>
            </div>
            <div class="row">
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desTelefono"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Telefono</label>
               </div>
               <div class="input-field col s6">
                  <input disabled value="<?= $request[0]["alunno"]["desCellulare"] ?>" id="disabled" type="text" class="validate">
                  <label for="disabled">Cellulare</label>
               </div>
            </div>
         </form>
      </div>
   </div>
</main>

<?php include './components/footer.php'; ?>
