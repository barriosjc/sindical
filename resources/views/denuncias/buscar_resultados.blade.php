@extends('layouts.admin')

@section('main-content')


<div class="card">
    <div class="card-header">

    <a href="{{ route('denuncia.buscar.index', 0) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>

      Resultados de la busqueda ({{$denuncias->total()}}) denuncias
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo de denuncia</th>
                                <th>nombre</th>
                                <th>Empresa</th>
                                <th>Fecha denuncia</th>
                                <th>Tipo denuncia actual</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($denuncias as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tipo_denuncia_desc}}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->empresa }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->fecha)) }}</td>
                                <td>{{ $item->tipo_movimiento_desc }}</td>
                                <td>
                                    <div class="float-right">
                                        <form action="{{ route('denuncia.find', $item->id) }}" method="GET">
                                            <button type="submit" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {{ $denuncias->appends(Request::all())->render() }} </div>
                </div>
            </div>
        </li>
    </ul>
</div>


@endsection