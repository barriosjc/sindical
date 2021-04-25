<!DOCTYPE html>
<html lang="en">
<style>
    .avatar {
        /* cambia estos dos valores para definir el tamaño de tu círculo */
        height: 100px;
        width: 100px;
        /* los siguientes valores son independientes del tamaño del círculo */
        background-repeat: no-repeat;
        background-position: 70%;
        border-radius: 50%;
        background-size: 100% auto;
        padding-right: 10px;
    }
</style>

<head>
    <title>Carnet de afiliado</title>
</head>

<body>
    <h5>UNION OBRERA METALÚRGICA SECCIONAL AVALLANEDA</h5>
    <table>
        <tr>
            <td style="width:17%">
                <!-- <img alt="foto" src="{{ public_path() . '/' . $afiliado->path }}" class="avatar" alt=""> -->
                <img alt="foto" src="{{ asset($afiliado->path) }}" class="avatar" alt="">
            </td>
            <td>
                <h4>Nro Afiliado:</h4>
                <p>Nombre : </p>
                <p>DNI : </p>
                <p>Seccional : </p>
            </td>
            <td>
                <h4>{{$afiliado->nro_afil_sindical}}</h4>
                <p>{{$afiliado->apellido_nombres}}</p>
                <p>{{$afiliado->nro_doc}}</p>
                <p>{{$afiliado->descripcion}}</p>
            </td>
        </tr>
    </table>
</body>

</html>