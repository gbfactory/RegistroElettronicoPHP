// =====================================
// Caricamento circolari da Google Drive
// =====================================

$('#circolari').toggle();

$(document).ready(function () {

    var api = 'https://www.googleapis.com/drive/v3/files?q="1t9aUapTaW69GwG2ug65odDKd3bd6LSG3"+in+parents&key=AIzaSyBpkmqMuIL9hUfs1p252dC0YvhyoG4Esyw';

    $.ajax({
        async: false,
        url: api,
        success: function (r) {
            apir = r;
        }
    })

    var len = Object.keys(apir.files).length;

    for (var i = 0; i < len; i++) {

        var folderId = apir.files[i].id;

        $('#circolari').append(`
                            <li>
                                <div class="collapsible-header"><i class="material-icons">folder_open</i>${apir.files[i].name}</div>
                                <div class="collapsible-body">
                                    <ul class="collection" id="${folderId}"> </ul>
                                </div>
                            </li>
                        `);

        var api2 = 'https://www.googleapis.com/drive/v3/files?q="' + folderId + '"+in+parents&key=AIzaSyBpkmqMuIL9hUfs1p252dC0YvhyoG4Esyw';

        $.ajax({
            async: false,
            url: api2,
            success: function (rf) {
                for (var i = 0; i < Object.keys(rf.files).length; i++) {
                    $(`#${folderId}`).append(`<li class="collection-item"><a href="">${rf.files[i].name}</a></li>`)
                }
            }
        })

    }

    $('#loader').toggle();
    $('#circolari').toggle();

    $('.collapsible').collapsible();
});