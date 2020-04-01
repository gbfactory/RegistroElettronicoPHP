$('#circolari').toggle();

$(document).ready(function () {

    // =====================================
    // Caricamento circolari da Google Drive
    // =====================================

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
                                <div class="collapsible-header" data-id="${folderId}"><i class="material-icons">folder_open</i>${apir.files[i].name}</div>
                                <div class="collapsible-body">
                                    <ul class="collection" id="${folderId}"> </ul>
                                </div>
                            </li>
                        `);
    }

    $('.collapsible-header').click(function() {
        if ($(this).parents('.active').length == 0) {

            var dataFolderId = $(this).attr('data-id');

            if ($(`#${dataFolderId} > li`)[0]) {
                return;  
            }

            //$(this).find('i').html('folder_open');

            var dataApi = 'https://www.googleapis.com/drive/v3/files?q="' + dataFolderId + '"+in+parents&key=AIzaSyBpkmqMuIL9hUfs1p252dC0YvhyoG4Esyw';


            $.ajax({
                async: false,
                url: dataApi,
                success: function (rf) {
                    for (var i = 0; i < Object.keys(rf.files).length; i++) {
                        var modalUrl = 'https://drive.google.com/file/d/' + rf.files[i].id + '/preview';
                        $(`#${dataFolderId}`).append(`<li class="collection-item"><a class="modal-trigger" href="${modalUrl}" target="_blank">${rf.files[i].name}</a></li>`)
                    }
                }
            })

        } /*else {
            $(this).find('i').html('folder');
        }*/
 
    })


    $('#loader').toggle();
    $('#circolari').toggle();

    //$('.modal').modal();
    $('.collapsible').collapsible({
        // onOpenStart() {
        //     console.log(this);
        //     console.log($(this));
        // }
    });


});
