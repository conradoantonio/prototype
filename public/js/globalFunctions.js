$(function() {
    //Set up the ajax to include csrf token on header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Fade in the containers
    setTimeout(function() {
        $('div.row-fluid, div.form-container').fadeIn('low');
    }, 500);

    //Verify if the button for delete multiple can be actionable
    $('body').delegate('.checkDelete','click', function() {
        var ids_lenght = [];
        $("input.checkDelete").each(function() {
            if($(this).is(':checked')) {
                ids_lenght.push($(this).parent().parent().siblings("td:nth-child(2)").text());
            }
        });

        $('.delete-rows').attr('disabled', ids_lenght.length > 0 ? false : true);
    });

    //Set up the select 2 inputs
    $(".select2").select2();

    //Clear modal inputs
    $('div.modal').on('hidden.bs.modal', function (e) {
        $(this).find('div.form-group').removeClass('has-error');
        $(this).find("input.form-control").val('');
        $(this).find("select.form-control").val(0);
    });

    //Send a request for multiple delete
    $('body').delegate('.delete-row','click', function() {
        var route = $('div.general-info').data('url');
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).parent().siblings("td:nth-child(2)").text();
        ids_array.push(row_id);

        swal({
            title: 'Se dará de baja el registro con el ID '+row_id+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                config = {
                    'route'     : route,
                    'ids'       : ids_array,
                    'refresh'   : refresh,
                }
                loadingMessage();
                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });

    //Send a request for a single delete
    $('body').delegate('.delete-rows','click', function() {
        var route = $('div.general-info').data('url');
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        $("input.checkDelete").each(function() {
            if($(this).is(':checked')) {
                ids_array.push($(this).parent().parent().siblings("td:nth-child(2)").text());
            }
        });
        if (ids_array.length > 0) {
            
            swal({
                title: 'Se dará de baja '+ids_array.length+' registro(s), ¿Está seguro de continuar?',
                icon: 'warning',
                buttons:["Cancelar", "Aceptar"],
                dangerMode: true,
            }).then((accept) => {
                if (accept) {
                    config = {
                        'route'     : route,
                        'ids'       : ids_array,
                        'refresh'   : refresh,
                    }
                    loadingMessage();
                    ajaxSimple(config);
                }
            }).catch(swal.noop);
        }
    });

    //Shows the loading swal
    function loadingMessage() {
        swal({
            title: 'Espere un momento porfavor',
            buttons: false,
            closeOnEsc: false,
            closeOnClickOutside: false,
            content: {
                element: "div",
                attributes: {
                    innerHTML:"<i class='fa fa-circle-o-notch fa-spin fa-3x fa-fw'></i>"
                },
            }
        }).catch(swal.noop);
    }

    //Code made by god (Your majesty, the only one, the choosen one and the divine one (bitch!)). The piecekeeper! KappaPride :B
    Pusher.logToConsole = false;

    var pusher = new Pusher('aa2627d74b476e17c6d1', {
      cluster: 'us2',
      encrypted: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(e) {
        if ( e.data.url == window.location.href ) {
            refreshTable(e.data.url);
        } else {
            console.log('no debería mostrarse kappa');
        }
    });
});
