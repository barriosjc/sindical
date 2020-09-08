@extends('layouts.admin')

@section('main-content')


<div class="card">
    <div class="card-header">

    <a href="{{ route('familiares.buscar.index', 0) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>

      Resultados de la busqueda ({{$grupo_familiar->total()}}) de familiares
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Apellido y nombres</th>
                                <th>Nro Doc.</th>
                                <th>Parentesco</th>
                                <th>Fec. nac.</th>
                                <th>Fec. baja sind</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grupo_familiar as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->apellido_nombres }}</td>
                                <td>{{ $item->nro_doc }}</td>
                                <td>{{ $item->tipos_parentescos->descripcion }}</td>
                                <td>{{ $item->fecha_nac }}</td>
                                <td>{{ $item->fecha_egreso_sind }}</td>
                                <td>
                                    <div class="float-right">
                                        <form action="{{ route('afiliado.find', $item->afiliado_id) }}" method="GET">
                                            <button type="submit" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {{ $grupo_familiar->appends(Request::all())->render() }} </div>
                </div>
            </div>
        </li>
    </ul>
</div>


@endsection