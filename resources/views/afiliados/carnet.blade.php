@extends('layouts.admin')

@section('main-content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
    integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
    integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="card-header">
        <a href="{{ url('/afiliados/find/' . $afiliado->id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i
                    class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>

        Carnet del afiliado: {{$afiliado->apellido_nombres}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row ">
                <div class="col-md-4">
                    <form action="{{ url('/afiliado/carnet/fotoup') }}" method="post" style="display: none"
                        id="avatarForm">
                        {{ csrf_field() }}
                        <input type="file" id="avatarInput" name="photo">
                    </form>
                    <button id="subir_foto" name="subir_foto" class="btn btn-info ">
                        <i class="fas fa-upload"></i> Subir Archivo
                    </button>
                    <!-- <button id="tomar_foto" name="tomar_foto" class="btn btn-info sacarfoto float-right"> -->
                    <button id="tomar_foto" name="tomar_foto" class="btn btn-info float-right">
                        <i class="fas fa-camera-retro"></i> Tomar foto
                    </button>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-6">
                    <button id="editar" name="editar" class="btn btn-info">
                        <i class="fas fa-crop-alt"></i> Editar imagen
                    </button>
                </div>
            </div>
            <div class="row pad-20">
                <div class="col-md-8">
                    <img id="avatarImage" class="image-resu" name="image_resu" src="/img/usuario.png"
                        alt="foto del afiliado">
                </div>
                <div class="col-md-4">
                    <div class="pull-bott-right">
                        <a href="{{ route('afiliado.carnet.foto.guardar') }}" id="btnbuscarfam" class="btn btn-info"><i
                                class="fas fa-save"></i> Guardar datos</a>
                        <a href="{{ route('afiliado.imprimir') }}" id="btnbuscarfam" class="btn btn-info"><i
                                class="fas fa-id-card"></i> Generar Carnet</a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>

<!-- modal para sacar la foto -->
<div class="modal fade" id="modalfoto" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tomar una foto al afiliado </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- <form action="{{ route('afiliado.carnet.tomar_foto') }}" method="post" id="fotoForm">
                    {{ csrf_field() }} -->
                    <div class="img-container">
                        <div class="row">
                        <div class="col-md-1">
                        </div>                            
                            <div class="col-md-10">
                                <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                                <button id="boton" class="btn btn-primary float-right">Tomar foto</button>
                                <p id="estado"></p>
                                <video muted="muted" class="video" name="video" id="video"></video>
                                <canvas id="canvas" style="display: none;"></canvas>
                            </div>
                        </div>
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
</div>

<!-- editar la imagen -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Seleccione el sector de la imagen a guardar </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-8">
                            <img id="image_crop" src="https://fotos0.githubusercontent.com/u/3456749">
                        </div>
                        <div class="col-md-4">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_crop">Trabajar con Imagen editada</button>
            </div>
        </div>
    </div>
</div>


<script>
$(function() {
    //subir archivo
    var $btn_subir_foto, $avatarInput, $avatarForm, $img_foto;

    $btn_subir_foto = $('#subir_foto');
    $avatarInput = $('#avatarInput');
    $avatarForm = $('#avatarForm');
    $img_foto = $('#avatarImage')

    $btn_subir_foto.on('click', function() {
        $avatarInput.click();
    });

    $avatarInput.on('change', function() {
        var formData = new FormData();
        formData.append('photo', $avatarInput[0].files[0]);

        $.ajax({
            url: $avatarForm.attr('action') + '?' + $avatarForm.serialize(),
            method: $avatarForm.attr('method'),
            data: formData,
            processData: false,
            contentType: false
        }).done(function(data) {
            if (data.success)
                $img_foto.attr('src', data.path);
        }).fail(function() {
            alert('La imagen subida no tiene un formato correcto');
        });
    });

    //----------------------------------------------------------------------
    //                tomar fotografia desde el modal
    //-------------------------------------------------------------------------------------------------------
    var $modalfoto = $('#modalfoto');
    $("#tomar_foto").on("click", function() {
        document.querySelector("#video").play();
        $modalfoto.modal('show');
    });

    const tieneSoporteUserMedia = () =>
        !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) ||
            navigator
            .webkitGetUserMedia || navigator.msGetUserMedia)
    const _getUserMedia = (...arguments) =>
        (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) ||
            navigator
            .webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

    // Declaramos elementos del DOM
    const $video = document.querySelector("#video"),
        $canvas = document.querySelector("#canvas"),
        $estado = document.querySelector("#estado"),
        $boton = document.querySelector("#boton"),
        $listaDeDispositivos = document.querySelector("#listaDeDispositivos");

    const limpiarSelect = () => {
        for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
            $listaDeDispositivos.remove(x);
    };
    const obtenerDispositivos = () => navigator
        .mediaDevices
        .enumerateDevices();

    // La función que es llamada después de que ya se dieron los permisos
    // Lo que hace es llenar el select con los dispositivos obtenidos
    const llenarSelectConDispositivosDisponibles = () => {

        limpiarSelect();
        obtenerDispositivos()
            .then(dispositivos => {
                const dispositivosDeVideo = [];
                dispositivos.forEach(dispositivo => {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                if (dispositivosDeVideo.length > 0) {
                    // Llenar el select
                    dispositivosDeVideo.forEach(dispositivo => {
                        const option = document.createElement('option');
                        option.value = dispositivo.deviceId;
                        option.text = dispositivo.label;
                        $listaDeDispositivos.appendChild(option);
                    });
                }
            });
    }

    (function() {
        // Comenzamos viendo si tiene soporte, si no, nos detenemos
        if (!tieneSoporteUserMedia()) {
            alert("Lo siento. Tu navegador no soporta esta característica");
            $estado.innerHTML =
                "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
            return;
        }
        //Aquí guardaremos el stream globalmente
        let stream;   
 
        // Comenzamos pidiendo los dispositivos
        obtenerDispositivos()
            .then(dispositivos => {
                // Vamos a filtrarlos y guardar aquí los de vídeo
                const dispositivosDeVideo = [];

                // Recorrer y filtrar
                dispositivos.forEach(function(dispositivo) {
                    const tipo = dispositivo.kind;
                    if (tipo === "videoinput") {
                        dispositivosDeVideo.push(dispositivo);
                    }
                });

                // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                // y le pasamos el id de dispositivo
                if (dispositivosDeVideo.length > 0) {
                    // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                    mostrarStream(dispositivosDeVideo[0].deviceId);
                }
            });

        const mostrarStream = idDeDispositivo => {
            _getUserMedia({
                    video: {
                        // Justo aquí indicamos cuál dispositivo usar
                        deviceId: idDeDispositivo,
                    }
                },
                (streamObtenido) => {
                    // Aquí ya tenemos permisos, ahora sí llenamos el select,
                    // pues si no, no nos daría el nombre de los dispositivos
                    llenarSelectConDispositivosDisponibles();

                    // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                    $listaDeDispositivos.onchange = () => {
                        // Detener el stream
                        if (stream) {
                            stream.getTracks().forEach(function(track) {
                                track.stop();
                            });
                        }
                        // Mostrar el nuevo stream con el dispositivo seleccionado
                        mostrarStream($listaDeDispositivos.value);
                    }

                    // Simple asignación
                    stream = streamObtenido;

                    // Mandamos el stream de la cámara al elemento de vídeo
                    $video.srcObject = stream;
                    $video.play();

                    //Escuchar el click del botón para tomar la foto
                    $boton.addEventListener("click", function() {
                        // e.preventDefault();
                        //Pausar reproducción
                        $video.pause();

                        //Obtener contexto del canvas y dibujar sobre él
                        let contexto = $canvas.getContext("2d");
                        $canvas.width = $video.videoWidth;
                        $canvas.height = $video.videoHeight;
                        contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                        let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
                        $estado.innerHTML = "Enviando foto. Por favor, espera...";

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('afiliado.carnet.tomar_foto') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            data: {
                                image: encodeURIComponent(foto)
                            },
                            success: function(data) {
                                $modalfoto.modal('hide');  
                                console.log(data);                  
                                $img_foto.attr('src', data.path);
                            },
                            error: function(er) {
                                console.log(er.responseText);
                                //console.log(er.responseText);
                            }
                        });

                        //Reanudar reproducción
                        //$video.play();
                    });
                }, (error) => {
                    console.log("Permiso denegado o error: ", error);
                    $estado.innerHTML = "No se puede acceder a la cámara, o no diste permiso.";
                }
            );
        }
    })();

    //----------------------------------------------------------------------
    //                redimensionar imagen
    // ---------------------------------------------------------------------

    var $modal = $('#modal');
    var image = document.getElementById('image_crop');
    var cropper;

    $('#editar').on("click", function(e) {
        image.src = $img_foto.attr('src');
        $modal.modal('show');


//         var files = e.target.files;
//         var done = function(url) {
// //            image.src = url;
//             image.src = $img_foto.src;
//             $modal.modal('show');
//         };
        // var reader;
        // var file;
        // var url;

        // if (files && files.length > 0) {
        //     file = files[0];

        //     if (URL) {
        //         done(URL.createObjectURL(file));
        //     } else if (FileReader) {
        //         reader = new FileReader();
        //         reader.onload = function(e) {
        //             done(reader.result);
        //         };
        //         reader.readAsDataURL(file);
        //     }
        // }
    });

    $modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });

    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#btn_crop").click(function() {
        contenedor = cropper.getCroppedCanvas({
            width: 260,
            height: 260,
        });

        contenedor.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('afiliado.carnet.crop.foto') }}",
                    data: {
                        image: base64data,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        //console.log('archivo esta en: ' + data['path']);
                        $modal.modal('hide');
                        // path = "";
                        // path = path + "/storage/afiliados/carnet/";
                        // path = path + data['name'];
                        $img_foto.removeAttr('src');
                        $img_foto.attr('src', data.path);
                        //  alert("success upload image");
                    },
                    error: function(er) {
                        console.log("se produjo un error");
                        //console.log(er.responseText);
                    }
                });
            }
        });
    });
});
</script>

@endsection