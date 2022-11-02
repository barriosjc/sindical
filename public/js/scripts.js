$(function() {

    $('#obtsiguiente').on('click', function(e) {
        e.preventDefault();

        if ($('.valorsiguiente').val() != '') {
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            // url: "{{ route('comunes.siguiente') }}",
            url: "/siguiente",
            method: 'get',
            data: {
                tipo: $('.valorsiguiente').data('tipo')
            },
            success: function(result) {
                // console.log(result.success);
                $('.valorsiguiente').val(result.success);
            }
        });
    });



    $('.provincia').on('change', function() {

        var prov_id = $(this).val();
        var html_select = '';
        var data = $(this).data('localidad');
        var combo = $('#' + data);
        if (!prov_id) {
            combo.html('<option value="">--Seleccione--</option>');
            return
        }
        $.get('/api/provincia/' + prov_id + '/localidades', function(data) {
            for (var i = 0; i < data.length; ++i) {
                html_select += '<option value="' + data[i].id + '">' + data[i].nombre + ' - ' + data[i].cod_postal + '</option>';
            }
            combo.html(html_select);
        })
    })


    $('[data-toggle="tooltip"]').tooltip()

    $(".aMayusculas").on("keyup", function() {
        this.value = this.value.toUpperCase();
    })

    if ($('#fecha_nac').val() != '') {
        calcularEdad($('#fecha_nac').val());
    }

    $('#fecha_nac').on('change', function() {
        calcularEdad($('#fecha_nac').val());
    });

    $('.busqueda').select2({
        language: "es"
    });

    $('.solonros').on('keyup', function(e) {
        this.value = this.value.replace(/\D/g, '');
    });

    function calcularEdad(e) {
        // fecha = $(this).val();
        fecha = e;
        var hoy = new Date();
        var cumpleanos = new Date(fecha);
        var edad = hoy.getFullYear() - cumpleanos.getFullYear();
        var m = hoy.getMonth() - cumpleanos.getMonth();

        if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
            edad--;
        }
        $('#edad').val(edad);
    }

    var elements = document.getElementsByClassName('colorear');
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].value != '') {
            elements[i].style.backgroundColor = "#f5b7b1";
        }
    }
})