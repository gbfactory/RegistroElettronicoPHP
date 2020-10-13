// Script Registro Elettronico
//       Using jQuery

$(document).ready(function() {
    // Materialize CSS
    $('.sidenav').sidenav();
    // $('.tabs').tabs();
    $('.tooltipped').tooltip();
    $('.collapsible').collapsible();
    $('.modal').modal();

    // Theme toggle
    function enableDark() {
        document.getElementById("darkcss").disabled = false;
        localStorage.setItem("darkmode", true);
    }

    function disableDark() {
        document.getElementById("darkcss").disabled = true;
        localStorage.setItem("darkmode", false);
    }

    $('#themetoggle').click(function() {
        let cssDark = $('#darkcss');

        if (cssDark.is('[disabled=""]')) enableDark();
        else disableDark();
    });

    if (localStorage.getItem("darkmode")) {
        enableDark();
        $('#themetoggle').attr('checked', true);
    }
});
