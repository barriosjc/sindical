@extends('layouts.admin')

@section('main-content')


<div class="card">
    <div class="card-header">

    <a href="{{ route('afiliado.buscar.index', 0) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>

      Resultados de la busqueda ({{$afiliados->total()}}) afiliados
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
                                <th>Nro Afiliado</th>
                                <th>Empresa</th>
                                <th>Estado ficha</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($afiliados as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->apellido_nombres }}</td>
                                <td>{{ $item->nro_doc }}</td>
                                <td>{{ $item->nro_afil_sindical }}</td>
                                <td>{{ $item->empresa_nom }}</td>
                                <td>{{ $item->estado_desc }}</td>
                                <td>
                                    <div class="float-right">
                                        <form action="{{ route('afiliado.find', $item->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {{ $afiliados->appends(Request::all())->render() }} </div>
                </div>
            </div>
        </li>
    </ul>
</div>


@endsection