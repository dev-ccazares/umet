@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row ">
                        <div class="col-md-6 text-left align-middle">Registros</div>
                    </div>
                     
                </div>
                <div class="card-body">
                    <div class="row border-bottom border-dark pb-2">
                        <div class="col-4">
                            <label for="period"><h5>Periodo</h5></label>
                            <select id="period" name="period" class="form-control">
                                <option value=""> Escoja una opción</option>
                                <option value="1"> 1 una opción</option>
                                <option value="2"> Esc3 opción</option>
                                <option value="3"> Esc2n</option>
                                @foreach ($period as $item)
                                    <option value="{{$item->id}}">{{$item->detail}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 mt-auto text-center">
                                <label><h5>Acciones</h5></label> 
                            </br>
                            <button id="button" type="button" class="btn btn-success btnModal btn-sm" data-url="{{route('newRegistry')}}" ><i class="mdi mdi-plus-circle"></i>&nbsp;Nuevo </button>
                            <button type="button" class="btn btn-warning btnModal btn-sm" data-url="{{route('newRegistry')}}" ><i class="mdi mdi-pencil"></i>&nbsp;Editar </button>
                            <button type="button" class="btn btn-danger btnModal btn-sm" data-url="{{route('newRegistry')}}" ><i class="mdi mdi-delete"></i>&nbsp;Eliminar </button>
                        </div>
                        <div class="col-md-5 text-right">
                            <button type="button" class="btn btn-dark text-white btnModal btn-sm" data-url="{{route('newRegistry')}}" ><i class="mdi mdi-plus-circle"></i>&nbsp;Agregar </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 pt-2">
                            <table class="table table-responsive ">
                                <thead class="bg-principal text-white">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Código IES</th>
                                        <th scope="col">Código Carrera</th>
                                        <th scope="col">Identificación Estudiante</th>
                                        <th scope="col">Nombre Estudiante</th>
                                        <th scope="col">Nombre Institución</th>
                                        <th scope="col">Tipo Institución</th>
                                        <th scope="col">Fecha Inicio</th>
                                        <th scope="col">Fecha Fin</th>
                                        <th scope="col">Num Horas</th>
                                        <th scope="col">Campo Específico</th>
                                        <th scope="col">Docente Tutor</th>
                                        <th scope="col">Fecha de Modificación</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registry as $item)
                                    @if ($item->convalidacion && $item->fecha_fin == '')
                                        <tr class="bg-convalidacion" >   
                                    @elseif($item->fecha_fin != '' || isset($item->fecha_fin))
                                        <tr class="bg-fin" > 
                                    @else
                                        <tr> 
                                    @endif
                                            <th scope="row">{{$item->id}}</th>
                                            <td>{{$item->codigo_ies}}</td>
                                            <td>{{$item->codigo_carrera}}</td>
                                            <td>{{$item->ci_estudiante}}</td>
                                            <td>{{$item->nombre_estudiante}}</td>
                                            <td>{{$item->nombre_institucion}}</td>
                                            <td>{{$item->tipo_institucion}}</td>
                                            <td>{{$item->fecha_inicio}}</td>
                                            <td>{{$item->fecha_fin}}</td>
                                            <td>{{$item->numero_horas}}</td>
                                            <td>{{$item->campo_especifico}}</td>
                                            <td>{{$item->docente_tutor}}</td>
                                            <td>{{explode(' ',$item->updated_at)[0]}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    2 days ago
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
