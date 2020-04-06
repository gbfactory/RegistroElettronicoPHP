<?php include './components/header.php';

$memo = $argo->promemoria();

?>
<main>

    <div class="container">
        <h3 class="header">Promemoria</h3>

        <hr>

        <?php //print('<pre> ' . print_r($memo, true) . '</pre>'); 
        ?>

        <link href="./assets/fullcalendar/core/main.css" rel="stylesheet">
        <link href="./assets/fullcalendar/daygrid/main.css" rel="stylesheet">

        <script src="./assets/fullcalendar/core/main.js"></script>
        <script src="./assets/fullcalendar/daygrid/main.js"></script>

        <style>
           .fc-day-grid-event .fc-content{
                white-space: normal !important;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['dayGrid'],
                    defaultView: 'dayGridWeek',
                    contentHeight: 'auto',
                    locale: 'it',
                    events: [
                        <?php
                            for ($x = 0; $x < count($memo); $x++) {
                                
                                echo ("{");
                                echo ("title: '" . str_replace("'", '"', json_encode($memo[$x]['desAnnotazioni'])) . "',");
                                echo ("start: '" . $memo[$x]['datGiorno'] . "'");
                                echo ("},");

                            };
                        ?>
                    ]

                });

                calendar.render();

            });
        </script>

        <div id="calendar"></div>

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
                            <span class="title">Promemoria per il <b> <?= dataLeggibile($memo[$x]['datGiorno']) ?> </b></span>
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
