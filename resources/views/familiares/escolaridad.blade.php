@extends('layouts.admin')
@section('main-content')
@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ route('familiares.index', [$afiliado_id, $grupo_familiar_id]) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Entrega de útilies escolares
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{ route('familiares.escolaridad.guardar') }}" method="POST"  accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='grupo_familiar_id' value="{{ $grupo_familiar_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ciclo lectivo</label>
                            <input typpe="text" id="" name="ciclo" class="form-control form-control-sm" value="{{ old('cliclo') }}" readonly />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Nivel</label>
                            <select name="tipo_documento_id" id="tipo_documento_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                <option value="jardin">Jardin</option>
                                <option value="preescolar">Preescolar</option>
                                <option value="primario">Primario</option>
                                <option value="secundario">Secundario</option>
                                <option value="postsecundario">Post secundario</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tipo educación</label>
                            <select name="tipo_educacion" id="tipo_educacion" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                <option value="publica">Pública</option>
                                <option value="privada">Privada</option>
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
                                    <input type="radio" class="form-check-input" value="S" name="mochila" {{(empty($registro->mochila) ? old('mochila') : $registro->mochila) =='S' ? 'checked' : ''}}>SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="mochila" {{(empty($registro->mochila) ? old('mochila')  : $registro->mochila) =='N' ? 'checked' : ''}}>NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Kit escolar</label><span class='s-red'>*</span>
                        <div class="container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="S" name="kitescolar" {{(empty($registro->kitescolar) ? old('kitescolar') : $registro->kitescolar) =='S' ? 'checked' : ''}}>SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="kitescolar" {{(empty($registro->kitescolar) ? old('kitescolar')  : $registro->kitescolar) =='N' ? 'checked' : ''}}>NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Delantal</label><span class='s-red'>*</span>
                        <div class="container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="S" name="delantal" {{(empty($registro->delantal) ? old('delantal') : $registro->delantal) =='S' ? 'checked' : ''}}>SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="delantal" {{(empty($registro->delantal) ? old('delantal')  : $registro->delantal) =='N' ? 'checked' : ''}}>NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Talle</label>
                            <select name="talle" id="talle" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                <option value="t6">T 6</option>
                                <option value="t8">T 8</option>
                                <option value="t10">T 10</option>
                                <option value="t12">T 12</option>
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



@endsection