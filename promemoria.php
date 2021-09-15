<?php
$cod = "pro";
$titolo = "Promemoria Classe";

include './components/header.php';

$memo = $argo->promemoria();
?>

<main>
    <div class="container">
        <div class="row">
            <div class="section">
                <div class="col s12">
                    <div class="card">
                        <div class="card-content">
                            <div class="row">
                                <div class="col s12 m6">
                                    <h5 class="left-align" id="cal-date">DATA</h5>
                                </div>
                                <!-- <div class="col s4 center-align">
                                    <a class="waves-effect waves-light btn" id="cal-week">SETTIMANA</a>
                                    <a class="waves-effect waves-light btn" id="cal-day">GIORNO</a>
                                </div> -->
                                <div class="col s12 m6 right-align">
                                    <a class="waves-effect waves-light btn" id="cal-left"><i class="material-icons">chevron_left</i></a>
                                    <a class="waves-effect waves-light btn" id="cal-now"><i class="material-icons">event</i></a>
                                    <a class="waves-effect waves-light btn" id="cal-right"><i class="material-icons">chevron_right</i></a>
                                </div>
                            </div>

                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>

                <div class="col s12 m8">
                    <ul class="collection card">
                        <?php for ($x = 0; $x < count($memo); $x++) { ?>
                            <li class="collection-item avatar" data-color="<?= colore_data($memo[$x]['datGiorno']) ?>">
                                <i class="material-icons circle <?= colore_data($memo[$x]['datGiorno']) ?>">announcement</i>
                                <span class="title">Promemoria per il <b> <?= dataLeggibile($memo[$x]['datGiorno']) ?> </b></span>
                                <p><?= linkCliccabili($memo[$x]['desAnnotazioni']) ?></p>
                                <p><i><?= $memo[$x]['desMittente'] ?></i></p>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="col s12 m4">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title">Filtro Data</span>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" checked="checked" value="yellow" />
                                    <span>PER DOMANI</span>
                                </label>
                            </p>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" checked="checked" value="red" />
                                    <span>PER OGGI</span>
                                </label>
                            </p>
                            <p class="filter-item">
                                <label>
                                    <input type="checkbox" checked="checked" value="green" />
                                    <span>PASSATI</span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js"></script>

<script>
    $(document).ready(function() {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            plugins: ['dayGrid'],
            defaultView: 'dayGridWeek',
            header: false,
            contentHeight: 'auto',
            locale: 'it',
            firstDay: 1,
            events: [
                <?php
                for ($x = 0; $x < count($memo); $x++) {
                    echo ("{");
                    echo ("title: '" . str_replace(['"', "'"], '', json_encode($memo[$x]['desAnnotazioni'])) . "',");
                    echo ("start: '" . $memo[$x]['datGiorno'] . "'");
                    echo ("},");
                };
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

        // Filtro data
        $('input[type="checkbox"]').click(function() {
            var inputValue = $(this).attr("value");
            $("[data-color='" + inputValue + "']").toggle();
        });
    });
</script>

<?php include './components/footer.php'; ?>