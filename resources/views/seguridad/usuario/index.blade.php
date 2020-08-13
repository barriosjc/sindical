@extends('layouts.admin')

@section('main-content')
<div class="flex-center position-ref full-height">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Usuarios {{isset($titulo)?$titulo:''}}</div>
          <div class="card-body">
            @if($esabm === false)
              @if($padre === 'roles') 
                <a href="{{ url('/roles') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
              @else            
                <a href="{{ url('/permisos') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
              @endif
            @else
              <a href="{{ url('/usuario/create') }}" class="btn btn-success btn-sm" title="Agregar nuevo Usuario">
                <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo
              </a>

              <form method="GET" action="{{ url('/usuario') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                <div class="input-group">
                  <input type="text" class="form-control" name="search" placeholder="Buscar..." value="{{ request('search') }}">
                  <span class="input-group-append">
                    <button class="btn btn-info" type="submit">
                      <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </form>
            @endif
            <br />
            <br />
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Nombre Completo</th>
                    <th>Avatar</th>
                    <th>Usu Verificado</th>
                    <th>Mail</th>
                    <th>
                      <div class="float-right">
                        Opciones
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($user as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->last_name }}</td>
                    <td><img src="{{Storage::url($item->foto)}}" class="rounded-circle" width="45px" alt=""> </td>
                    <td>{{ $item->email_verified_at }}</td>
                    <td>{{ $item->email }}</td>
                    @if($esabm)
                      <td>
                        <div class="float-right">
                          <a href="{{ url('/usuario/' . $item->id . '/roles') }}" ><button class="btn btn-success btn-sm" data-toggle="tooltip" title="Roles asignados al usuario" ><i class="fa fa-users" aria-hidden="true"></i></button></a>
                          <a href="{{ url('/usuario/' . $item->id . '/permisos') }}" title="Permisos asignados al usuario "><button class="btn btn-success btn-sm"><i class="fa fa-key" aria-hidden="true"></i></button></a>
                          <a href="{{ url('/usuario/' . $item->id) }}" title="View Usuario"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i></button></a>
                          <a href="{{ url('/usuario/' . $item->id . '/edit') }}" title="Edit Usuario"><button class="btn btn-primary btn-sm"><i class="far fa-edit"></i></button></a>

                          <form method="POST" action="{{ url('/usuario' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Usuario" onclick="return confirm('Confirma eliminar?')"><i class="far fa-trash-alt text-white"></i></button>
                          </form>
                        </div>
                      </td>
                    @else
                      <td>
                        <div class="float-right">
                          @if($padre === 'roles') 
                            <a href="{{ url( '/roles/' . $rolid . '/usuarios/' . $item->id . '/desasignar') }}" title="Quitar Rol asignados al usuario"><button class="btn btn-danger btn-sm"><i class="fa fa-minus text-white" aria-hidden="true"></i></button></a>
                          @else
                            <a href="{{ url( '/permisos/' . $perid . '/usuarios/' . $item->id . '/desasignar') }}" title="Quitar permiso asignados al rol"><button class="btn btn-danger btn-sm"><i class="fa fa-minus text-white" aria-hidden="true"></i></button></a>
                          @endif
                        </div>
                      </td>
                    @endif
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="pagination-wrapper"> {!! $user->appends(['search' => Request::get('search')])->render() !!} </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if($esabm === false)
      @include('seguridad.usuario.asignar')
    @endif
  </div>
</div>
@endsection