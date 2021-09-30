<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carnet de familiar</title>
    <link rel="stylesheet" href="\css\informes.css">
</head>

<body>
    <h5>UNION OBRERA METALÚRGICA SECCIONAL AVALLANEDA</h5>
    <h6>de la República Argentina Adherida a la C.G.T.</h6>
    <hr />
    <table>
        <tr>
            <td style="width:30%" rowspan="9">
                <h3 class="text-center"><b>Afil. : {{$familiar->nro_grupo_fam}}</b></h3>
                <img  alt="foto" src="{{ Storage::disk('fotos')->url($familiar->path) }}" class="avatar center" alt="">
            </td>
            <td class="text-right">
                Nombre :
            </td>
            <td class="text-left">
                {{$familiar->apellido_nombres}}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                Domicilio :
            </td>
            <td class="text-left">
                {{$familiar->direccion}}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                Localidad :
            </td>
            <td class="text-left">
                {{$familiar->loc_nombre}}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                DNI :
            </td>
            <td class="text-left">
                {{$familiar->nro_doc}} - Fec. Ingreso: {{date('d/m/Y', strtoTime($familiar->fecha_ingreso_sind))}}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                Empresa :
            </td>
            <td class="text-left">
                {{$familiar->razon_social}}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                Seccional :
            </td>
            <td class="text-left">
                {{$familiar->sec_descripcion}}
            </td>
        </tr>
        <tr>
            <td class="text-right">
                Fecha nac. :
            </td>
            <td class="text-left">
                {{date('d/m/Y', strtoTime($familiar->fecha_nac))}} - <b>({{$familiar->par_descripcion}})</b>
            </td>
        </tr>
        <tr>
            <td class="text-right">
                Tipo:
            </td>
            <td class="text-left">
                <b>DISCAPACITADO</b>
            </td>
        </tr>
        <tr>
            <td class="text-right" colspan="2">
                Este carnet no tiene validez sin
                la presentación del carnet del titular
            </td>
        </tr>
    </table>
</body>

</html>