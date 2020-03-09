<?php include './components/header.php'; 

$argomenti = $argo->argomenti();

?>
<main>

    <div class="container">
        <h3>Argomenti Lezione</h3>

        <div class="row">
            <div class="col s12">

                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
                <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

                <table id="argomenti" class="display">
                    <thead>
                        <tr>
                            <th>MATERIA</th>
                            <th>DATA</th>
                            <th>ARGOMENTI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($x = 0; $x < count($argomenti); $x++) { ?>
                            <tr>
                                <td><?= $argomenti[$x]['desMateria'] ?></td>
                                <td><?= $argomenti[$x]['datGiorno'] ?></td>
                                <td><?= $argomenti[$x]['desArgomento'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('#argomenti').DataTable({
                            "paging": false,
                            "columnDefs": [
                                { width: '30%', targets: 0 },
                                { width: '10%', targets: 1 },
                                { width: '60%', targets: 2 }
                            ],
                            "language": {
                                "emptyTable":     "Non ci sono informazioni disponibili",
                                "info":           "Stai visualizzando da _START_ a _END_ di _TOTAL_ argomenti",
                                "infoEmpty":      "Stai visualizzando 0 argomenti",
                                "infoFiltered":   "(filtrato da _MAX_ argomenti totali)",
                                "loadingRecords": "Caricamento...",
                                "processing":     "Elaborazione...",
                                "search":         "Cerca:",
                                "zeroRecords":    "Non ci sono risultati"
                            }
                        });
                    } );
                </script>

            </div>
        </div>

    </div>
</main>



<?php include './components/footer.php'; ?>
