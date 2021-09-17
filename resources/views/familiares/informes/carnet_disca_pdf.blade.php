<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carnet de familiar</title>
    <link rel="stylesheet" href="\css\informes.css">
</head>

<body>
    <h5>UNION OBRERA METALÚRGICA SECCIONAL AVALLANEDA</h5>
    <h6>de la República Argentina       Adherida a la C.G.T.</h6>
    <hr/>
    <table>
        <tr>
            <td style="width:30%">
                <h3 class="text-center"><b>Nro Afil. : {{$familiar->nro_grupo_fam}}</b></h3>
              <!-- <img alt="foto" src="{{ Storage::disk('fotos')->path($familiar->path) }}" class="avatar" alt=""> -->
                <img alt="foto" src="{{ Storage::disk('fotos')->url($familiar->path) }}" class="avatar" alt="">
            </td>
            <td class="text-right">
                <p  class="margin-0">Nombre : </p>
                <p  class="margin-0">Domicilio : </p>
                <p  class="margin-0">Localidad : </p>
                <p  class="margin-0">DNI : </p>
                <p  class="margin-0">Empresa : </p>
                <p  class="margin-0">Seccional : </p>
                <p  class="margin-0">Fecha nac. : </p>
                <p  class="margin-0">Tipo:  </p>
            </td>
            <td>
                <p  class="margin-0">{{$familiar->apellido_nombres}}</p>
                <p  class="margin-0">{{$familiar->direccion}}</p>
                <p  class="margin-0">{{$familiar->loc_nombre}}</p>
                <p  class="margin-0">{{$familiar->nro_doc}}  -     Fec. Ingreso: {{date('d/m/Y', strtoTime($familiar->fecha_ingreso_sind))}}</p>
                <p  class="margin-0">{{$familiar->razon_social}}</p>
                <p  class="margin-0">{{$familiar->sec_descripcion}}</p>
                <p  class="margin-0">{{date('d/m/Y', strtoTime($familiar->fecha_nac))  -  $familiar->par_descripcion}} </p>
                <p  class="margin-0"><b>DISCAPACITADO</b></p>
            </td>
        </tr>
    </table>
</body>

</html>