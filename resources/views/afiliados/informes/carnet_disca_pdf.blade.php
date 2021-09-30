<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carnet de afiliado</title>
    <link rel="stylesheet" href="\css\informes.css">
</head>

<body>
    <h5>UNION OBRERA METALÚRGICA SECCIONAL AVALLANEDA</h5>
    <h6>de la República Argentina       Adherida a la C.G.T.</h6>
    <hr/>
    <table>
        <tr>
            <td style="width:30%">
                <h3 class="text-center"><b>Afil. : {{$afiliado->nro_afil_sindical}}</b></h3>
              <!-- <img alt="foto" src="{{ Storage::disk('fotos')->path($afiliado->path) }}" class="avatar" alt=""> -->
                <img alt="foto" src="{{ Storage::disk('fotos')->url($afiliado->path) }}" class="avatar" alt="">
            </td>
            <td class="text-right">
                <p  class="margin-0">Nombre : </p>
                <p  class="margin-0">Domicilio : </p>
                <p  class="margin-0">Localidad : </p>
                <p  class="margin-0">DNI : </p>
                <p  class="margin-0">Empresa : </p>
                <p  class="margin-0">Seccional : </p>
                <p  class="margin-0">Fecha nac. : </p>
                <p  class="margin-0"><?php if ( !empty($afiliado->delegado_hasta) ) {
                    if(date_diff(now(), new DateTime($afiliado->delegado_hasta))->format('%a') > 1) { 
                       echo("(DELEGADO)"); 
                    }
                } ?></p>
            </td>
            <td>
                <p  class="margin-0">{{$afiliado->apellido_nombres}}</p>
                <p  class="margin-0">{{$afiliado->direccion}}</p>
                <p  class="margin-0">{{$afiliado->loc_nombre}}</p>
                <p  class="margin-0">{{$afiliado->nro_doc}}  -     Fec. Ingreso: {{date('d/m/Y', strtoTime($afiliado->fecha_ing_empr))}}</p>
                <p  class="margin-0">{{$afiliado->razon_social}}</p>
                <p  class="margin-0">{{$afiliado->sec_descripcion}}</p>
                <p  class="margin-0">{{date('d/m/Y', strtoTime($afiliado->fecha_nac))}}</p>
                <p  class="margin-0">
                cambiar este texto
                </p>
            </td>
        </tr>
    </table>
</body>

</html>