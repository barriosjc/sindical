<!DOCTYPE html>
<html lang="en">
<style>
    .avatar {
        /* cambia estos dos valores para definir el tamaño de tu círculo */
        height: 100px;
        width: 100px;
        border-top-left-radius: 250% 250%;
        border-top-right-radius: 250% 250%;
        border-bottom-right-radius: 250% 250%;
        border-bottom-left-radius: 250% 250%;
        /* los siguientes valores son independientes del tamaño del círculo */
        /*background-repeat: no-repeat;
        background-position: 70%;
        border-radius:100px;
        background-size: 100% auto;
        padding-right: 50px;
        */
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
                <img alt="foto" src="{{ Storage::disk('fotos')->path($afiliado->path) }}" class="avatar" alt="">
            </td>
            <td>
                <h4>Nro Afiliado:</h4>
                <p>Nombre : </p>
                <p>DNI : </p>
                <p>Seccional : </p>
                <p>Fecha nac. : </p>
                <p></p>
            </td>
            <td>
                <h4>{{$afiliado->nro_afil_sindical}}</h4>
                <p>{{$afiliado->apellido_nombres}}</p>
                <p>{{$afiliado->nro_doc}}</p>
                <p>{{$afiliado->descripcion}}</p>
                <p>{{$afiliado->fecha_nac}}</p>
                <p>{{$afiliado->es_delegado}}</p>
            </td>
        </tr>
    </table>
</body>

</html>