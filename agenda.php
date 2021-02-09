<?php
$cod = "agd";
$titolo = "Agenda";

include './components/header.php';

$promemoria = $argo->promemoria();
$compiti = $argo->compiti();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="col s12">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css" integrity="sha512-IBfPhioJ2AoH2nST7c0jwU0A3RJ7hwIb3t+nYR4EJ5n9P6Nb/wclzcQNbTd4QFX1lgRAtTT+axLyK7VUCDtjWA==" crossorigin="anonymous" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js" integrity="sha512-bg9ZLPorHGcaLHI2lZEusTDKo0vHdaPOjVOONi4XLJ2N/c1Jn2RVI9qli4sNAziZImX42ecwywzIZiZEzZhokQ==" crossorigin="anonymous"></script>
                
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css" integrity="sha512-CN6oL2X5VC0thwTbojxZ02e8CVs7rii0yhTLsgsdId8JDlcLENaqISvkSLFUuZk6NcPeB+FbaTfZorhbSqcRYg==" crossorigin="anonymous" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js" integrity="sha512-kebSy5Iu+ouq4/swjgEKwa217P2jf/hNYtFEHw7dT+8iLhOKB5PG5xaAMaVyxRK7OT/ddoGCFrg8tslo8SIMmg==" crossorigin="anonymous"></script>

                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.css" integrity="sha512-tNMyUN1gVBvqtboKfcOFOiiDrDR2yNVwRDOD/O+N37mIvlJY5d5bZ0JeUydjqD8evWgE2cF48Gm4KvQzglN0fg==" crossorigin="anonymous" />
                <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.js" integrity="sha512-Iw4G4+WD3E3F0M+wVZ95nlnifX1xk2JToaD4+AB537HmOImFi79BTtWma57mJeEnK2qNTOgZrYLtAHVsNazzqg==" crossorigin="anonymous"></script>
                
                <div class="row valign-wrapper">
                    <div class="col s4">
                        <h5 class="left-align" id="cal-date">DATA</h5>
                    </div>
                    <div class="col s4 center-align">
                        <a class="waves-effect waves-light btn" id="cal-week">SETTIMANA</a>
                        <a class="waves-effect waves-light btn" id="cal-day">GIORNO</a>
                    </div>
                    <div class="col s4 right-align">
                        <a class="waves-effect waves-light btn" id="cal-left"><i class="material-icons">chevron_left</i></a>
                        <a class="waves-effect waves-light btn" id="cal-now"><i class="material-icons">event</i></a>
                        <a class="waves-effect waves-light btn" id="cal-right"><i class="material-icons">chevron_right</i></a>
                    </div>
                </div>

                <div id="calendar"></div>

                <script>
                    $(document).ready(function() {

                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            plugins: ['dayGrid'],
                            defaultView: 'dayGridWeek',
                            header: false,
                            contentHeight: 'auto',
                            locale: 'it',
                            firstDay: 1,
                            hiddenDays: [0],
                            events: [
                                <?php
                                for ($x = 0; $x < count($promemoria); $x++) {
                                    echo ("{");
                                    echo ("title: '" . $promemoria[$x]['desMittente'] . ": " . str_replace(['"', "'"], '', json_encode($promemoria[$x]['desAnnotazioni'])) . "',");
                                    echo ("start: '" . $promemoria[$x]['datGiorno'] . "'");
                                    echo ("},");
                                };
                                for ($x = 0; $x < count($compiti); $x++) {
                                    echo ("{");
                                    echo ("title: '" . $compiti[$x]['desMateria'] . ": " . str_replace(['"', "'"], '', json_encode($compiti[$x]['desCompiti'])) . "',");
                                    echo ("start: '" . $compiti[$x]['datCompiti'] . "'");
                                    echo ("},");
                                }
                                ?>
                            ]

                        });

                        calendar.render();

                        $('#cal-date').html(calendar.view.title);

                        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                            calendar.changeView('dayGridDay');
                            $('#cal-date').html(calendar.view.title);
                        }

                        $('#cal-week').click(function() {
                            calendar.changeView('dayGridWeek');
                            $('#cal-date').html(calendar.view.title);
                        });

                        $('#cal-day').click(function() {
                            calendar.changeView('dayGridDay');
                            $('#cal-date').html(calendar.view.title);
                        });

                        $('#cal-left').click(function() {
                            calendar.prev();
                            $('#cal-date').html(calendar.view.title);
                        });

                        $('#cal-right').click(function() {
                            calendar.next();
                            $('#cal-date').html(calendar.view.title);
                        });

                        $('#cal-now').click(function() {
                            calendar.today();
                            $('#cal-date').html(calendar.view.title);
                        });

                    });
                </script>
            </div>
        </div>
    </div>
</main>

<?php include './components/footer.php'; ?>