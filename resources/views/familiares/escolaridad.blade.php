@extends('layouts.admin')
@section('main-content')
@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ route('familiares.index', [$afiliado_id, $gf_escolaridad->grupo_familiar_id]) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Entrega de útilies escolares 
    </div>
    {{-- ({{$gf_escolaridad->grupo_familiar->apellido_nombres}}) --}}
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ciclo Lec.</th>
                                <th>Nivel</th>
                                <th>Tipo Educ.</th>  
                                <th>Obs.</th>                            
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gf_escolaridad_hist as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->ciclo_lectivo }}</td>
                                <td>{{ $item->nivel }}</td>
                                <td>{{ $item->tipo_educacion }}</td>
                                <td>{{ $item->obs }}</td>                          
                                <td>
                                    @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo escolaridad'))
                                    <div class="float-right">
                                        <form action="{{ route('familiares.escolaridad.borrar', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confima la eliminación?')"> <i class="far fa-trash-alt text-white"></i></button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- @if(!empty($gf_escolaridad_hist)) -->
                    <div class="pagination-wrapper"> {!! $gf_escolaridad_hist->appends(['search' => Request::get('search')])->render() !!} </div>
                    <!-- @endif -->
                </div>
            </div>
        </li>

        <li class="list-group-item">
            <form id='formEmp' action="{{ route('familiares.escolaridad.guardar') }}" method="POST"  accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='grupo_familiar_id' value="{{ $gf_escolaridad->grupo_familiar_id }}">                
                <input type='hidden' name='id' value="{{ $gf_escolaridad->id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ciclo lectivo</label>
                            <input typpe="text" id="" name="ciclo_lectivo" class="form-control form-control-sm" value="{{ old('ciclo_lectivo', $gf_escolaridad->ciclo_lectivo) }}" readonly />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Nivel</label>
                            <select name="nivel" id="nivel" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                <option value="jardin"  {{ old('nivel', $gf_escolaridad->nivel) == 'jardin' ? 'selected' : ''}} >Jardin</option>
                                <option value="preescolar"  {{ old('nivel', $gf_escolaridad->nivel) == 'preescolar' ? 'selected' : ''}} >Preescolar</option>
                                <option value="primario"  {{ old('nivel', $gf_escolaridad->nivel) == 'primario' ? 'selected' : ''}} >Primario</option>
                                <option value="secundario"  {{ old('nivel', $gf_escolaridad->nivel) == 'secundario' ? 'selected' : ''}} >Secundario</option>
                                <option value="postsecundario"  {{ old('nivel', $gf_escolaridad->nivel) == 'postsecundario' ? 'selected' : ''}} >Post secundario</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tipo educación</label>
                            <select name="tipo_educacion" id="tipo_educacion" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                <option value="publica"  {{ old('tipo_educacion', $gf_escolaridad->tipo_educacion) == 'publica' ? 'selected' : ''}} >Pública</option>
                                <option value="privada"  {{ old('tipo_educacion', $gf_escolaridad->tipo_educacion) == 'privada' ? 'selected' : ''}} >Privada</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <label>Mochila</label><span class='s-red'>*</span>
                        <div class="container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="S" name="mochila" {{ old('mochila', $gf_escolaridad->mochila) =='S' ? 'checked' : ''}}>SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="mochila" {{ old('mochila', $gf_escolaridad->mochila) =='N' ? 'checked' : ''}}>NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Kit escolar</label><span class='s-red'>*</span>
                        <div class="container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="S" name="kit_escolar" {{old('kit_escolar', $gf_escolaridad->kit_escolar) =='S' ? 'checked' : ''}}>SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="kit_escolar" {{old('kit_escolar', $gf_escolaridad->kit_escolar) =='N' ? 'checked' : ''}}>NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Delantal</label><span class='s-red'>*</span>
                        <div class="container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input " id="delantalsi" value="S" name="delantal" {{old('delantal', $gf_escolaridad->delantal) =='S' ? 'checked' : ''}}>SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input " id="delantalno" value="N" name="delantal" {{old('delantal', $gf_escolaridad->delantal) =='N' ? 'checked' : ''}}>NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Talle</label>
                            <select name="talle" id="talle" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                <option value="t6"  {{ old('talle', $gf_escolaridad->nivel) == 't6' ? 'selected' : ''}} >T 6</option>
                                <option value="t8"  {{ old('talle', $gf_escolaridad->nivel) == 't8' ? 'selected' : ''}} >T 8</option>
                                <option value="t10"  {{ old('talle', $gf_escolaridad->nivel) == 't10' ? 'selected' : ''}} >T 10</option>
                                <option value="t12"  {{ old('talle', $gf_escolaridad->nivel) == 't12' ? 'selected' : ''}} >T 12</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <input typpe="text" id="" name="obs" class="form-control form-control-sm" value="{{ old('obs') }}" maxlength="100" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group pad-20">
                            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo escolaridad'))
                            <button type="submit" id="agregarpregunta" class="btn btn-success btn-sm float-right">Agregar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </li>

    </ul>
</div>

<script>
    $(function() {
        $("#delantalno").on("click", function() { 
            $("#talle").prop("selectedIndex", 0).val();
            $("#talle").prop('disabled', 'disabled');
        }); 
        $("#delantalsi").on("click", function() { 
            $("#talle").prop('disabled', '');
        });                       
    }); 
</script>

@endsection