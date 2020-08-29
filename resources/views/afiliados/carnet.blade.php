<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carnet de afiliado</title>
    <meta charset="utf-8">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h5>UNION OBRERA METALÚRGICA SECCIONAL AVALLANEDA</h5>
        <table>
            <tr>
                <td style="width:100px">
                    <!-- <img alt="foto" src="{{ asset('storage') . str_replace('public', '', Auth::user()->foto) }} " class="rounded-circle" width="120px" alt=""> -->
                </td>
                <td style="width:100px">
                    <p>Nombre: {{$afiliado->apellido_nombres}}</p>
                    <p>DNI : {{$afiliado->nro_doc}}</p>
                    <h4>Nro Afiliado: {{$afiliado->nro_afil_sindical}}</h4>
                </td>
            </tr> <!-- <label>Seccional   : {{$afiliado->seccionales->descripcion}}</label> -->
        </table>
</body>

</html>