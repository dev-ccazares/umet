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
                    <form action="" method="GET">
                        <div class="row pb-4">
                            <div class="col-4">
                                <label for="period"><h5>Periodo</h5></label>
                                <select id="period" name="period" class="form-control">
                                    <option value="" > Escoja una opción</option>
                                    @foreach ($period as $item)
                                        <option value="{{$item->id}}" {{ $periodSelected == $item->id ? 'selected' : ''}}>{{$item->detail}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3  text-center">
                                <label><h5>Acciones</h5></label> 
                                <div class="mt-1">
                                    <button id="nuevo" data-url="{{route('savePeriod')}}" type="button" class="btn btn-principal text-white btn-sm" data-toggle="modal" data-target="#modalPeriodo" ><i class="mdi mdi-plus-circle"></i>&nbsp;Nuevo </button>
                                    <button id="editar" data-url="{{route('editPeriod')}}" type="button" class="btn btn-principal text-white btn-sm desactivar" data-toggle="modal" data-target="#modalPeriodo"><i class="mdi mdi-pencil"></i>&nbsp;Editar </button>
                                    <button  id="eliminar" type="button" class="btn btn-danger btn-sm desactivar" data-url="{{route('deletePeriod')}}" ><i class="mdi mdi-delete"></i>&nbsp;Eliminar </button>
                                </div>    
                            </div>
                            <div class="col-md-5 text-center">
                                <label><h5>Filtros</h5></label> 
                                <div class="row">
                                    <div class="col-4 px-0">
                                        <select id="final" name="final" class="form-control">
                                            <option value="" > Escoja una opción</option>
                                            <option value="N" >Finalizado - Normal</option>
                                            <option value="T" >Finalizado - Trabajo</option>
                                            <option value="S" >Sin Finalizar</option>
                                        </select>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <input type="text" class="form-control" name="search" id="search" placeholder="Buscar" value="{{$search}}">
                                    </div>
                                    <div class="col-3 m-auto text-right">
                                        <button type="submit" class="btn btn-principal text-white btn-sm" ><i class="mdi mdi-magnify"></i>&nbsp;Buscar </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-dark text-white btnModal btn-sm desactivar" data-url="{{route('newRegistry')}}" ><i class="mdi mdi-plus-circle"></i>&nbsp;Agregar </button>
                            <button  class="btn btn-success text-white btn-sm parametros" data-url="{{route('exportRegistry')}}" ><i class="mdi mdi-file-excel"></i>&nbsp;Excel </button>
                        </div>
                        <div class="col-12 pt-2">
                            <table class="table table-sm">
                                <thead class="bg-principal text-white">
                                    <tr>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'id', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">#</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'id_period', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Periodo</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'codigo_ies', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Código IES</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'codigo_carrera', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Código Carrera</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'ci_estudiante', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Cédula Estudiante</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'nombre_estudiante', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Nombre Estudiante</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'nombre_institucion', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Nombre Institución</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'tipo_institucion', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Tipo Institución</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'fecha_inicio', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Fecha Inicio</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'fecha_fin', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Fecha Fin</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'numero_horas', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Num Horas</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'campo_especifico', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Campo Específico</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'docente_tutor', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Docente Tutor</th>
                                        <th class="text-center cabeceraTabla" data-id="{{ \Request::fullUrlWithQuery(['sort' => 'updated_at', 'order' => $order_list])}}" style="vertical-align: middle;" scope="col">Fecha de Modificación</th>
                                        <th scope="col" width="120px" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($registry->count())
                                        @foreach ($registry as $item)
                                        @if($item->fecha_fin != '' || isset($item->fecha_fin))
                                            <tr class="bg-fin" > 
                                        @elseif ($item->convalidacion && $item->fecha_fin == '')
                                            <tr class="bg-convalidacion" >    
                                        @elseif ($item->papeleo && $item->fecha_fin == '')
                                            <tr class="bg-papeleo" > 
                                        @else
                                            <tr> 
                                        @endif
                                                <th scope="row">{{$item->id}}</th>
                                                <td>{{$item->period->detail}}</td>
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
                                                <td class="text-center">
                                                    <a class="btn btn-principal btn-sm text-white btnModal" title="Editar"  data-url="{{ route('editRegistry',['id' => $item->id])}}"><i class="mdi mdi-pencil"></i></a> 
                                                    <button type="button" class="btn btn-secondary text-white btn-sm wordId" title="Carta Presentación" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalWord" ><i class="mdi mdi-file-document"></i></button>
                                                    <a class="btn btn-danger btn-sm text-white eliminarRegistro" title="Eliminar"  data-url="{{ route('deleteRegistry',['id' => $item->id])}}"><i class="mdi mdi-delete"></i></a> 
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <nav class="float-right" aria-label="Page navigation example">
                        {!! str_replace('/?', '?', $registry->appends(app('request')->query())->render()) !!}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPeriodo" tabindex="-1" role="dialog" aria-labelledby="periodoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="periodoLabel">Periodo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="load" class="col-12 m-auto text-center loader" style="display: none;">
                <i class="mdi mdi-spin mdi-loading" style="font-size: 90px;"></i>
                </br><span style="font-size: 20px;">Guardando ...<span>
            </div>
            <form id="formPeriodo" class="loader row">
                <div class="col-12" >
                    <div class="form-group row">
                        <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Nombre:</label>
                        <div class="col-sm-7">
                            @csrf
                            <input name="id" id="idPeriodo" value=" " hidden >
                            <input type="text" class="form-control" name="detail" id="detail" placeholder="Nombre" value="" required >
                        </div>
                    </div>
                </div> 
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger load" data-dismiss="modal"><i class="mdi mdi-cancel"></i>&nbsp;Cancelar</button>
            <button id="savePeriodo" type="button" data-url="" class="btn btn-success load" ><i class='mdi mdi-content-save'></i>&nbsp; Guardar</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalWord" tabindex="-1" role="dialog" aria-labelledby="wordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="wordoLabel">Descargar Carta de Presentación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formWord" action = "{{route('wordRegistry')}}" method="get">
            <div class="modal-body row">
                <div class="col-12" >
                    <input name="id" id="idRegistro" value="" hidden >
                    <div class="form-group row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="control-label col-sm-3 my-auto text-right"><span class="text-danger">*&nbsp;</span>Titulo:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="titulo" placeholder="Titulo" value="" required >
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="control-label col-sm-3 my-auto text-right"><span class="text-danger">*</span>&nbsp;Nombre:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="" required >
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="control-label col-sm-3 my-auto text-right"><span class="text-danger">*&nbsp;</span>Nivel:</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="nivel" placeholder="Nivel" value="" required >
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="mdi mdi-cancel"></i>&nbsp;Cancelar</button>
                <button type="submit" class="btn btn-success"><i class='mdi mdi-file-download'></i>&nbsp; Descargar</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
@section('js')
<script>
    url = '';
    $(document).ready(function() {
        disbaledButton();

        $('#period').change(function() {
            disbaledButton();
        });

        $('#nuevo').click(function() {
            url = $(this).data("url");
            $("#detail").val('');
            $("#idPeriodo").val('');
        });

        $('.wordId').click(function() {
            $('#formWord')[0].reset();
            id = $(this).data("id");
            $("#idRegistro").attr('value',id);
        });

        $('#eliminar').click(function() {
            url = $(this).data("url");
            swal({
              title: "Atencion !",
              text: 'Seguro desea borrar '+$('#period option:selected').text(),
              icon: "warning",
              dangerMode: true,
              buttons: ["Cancelar","Aceptar"]
              
            })
            .then((willDelete) => {
                if(willDelete){
                    $(location).attr('href',url+'?id='+$('#period option:selected').val());
                }
            });
        });

        $('.eliminarRegistro').click(function() {
            url = $(this).data("url");
            swal({
              title: "Atencion !",
              text: 'Seguro desea borrar el resgistro',
              icon: "warning",
              dangerMode: true,
              buttons: ["Cancelar","Aceptar"]
              
            })
            .then((willDelete) => {
                if(willDelete){
                    $(location).attr('href',url);
                }
            });
        });

       
        
        $('#editar').click(function() {
            url = $(this).data("url");
            $("#detail").val($("#period option:selected").text());
            $("#idPeriodo").val($("#period option:selected").val());
        });

        $('#savePeriodo').click(function() {
            if ($('#load').is(':visible')) {
                $('#load').toggle();
            }
            $('.loader').toggle();
            $('.load').attr('disabled', true);
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#formPeriodo').serialize(),
                dataType: 'json',
                success: function(data) {
                    location.reload();
                },
                error: function(xhr) {
                    $('.load').attr('disabled', false);
                    $('.loader').toggle("slow");
                    if (xhr.status == 422) {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.has-error').remove();
                        var errors = $.parseJSON(xhr.responseText);
                        $.each(errors, function(key, value) {
                            var element = document.getElementsByName(key);
                            $(element).addClass('is-invalid');
                            var padre = $(element).parent();
                            padre.append('<span class="has-error text-danger">' + value + '</span>');
                        });
                        toastr["warning"]("Datos incorrectos","Atención!");
                    } else if (xhr.status == 409) {
                        var errors = $.parseJSON(xhr.responseText);
                        toastr["error"](errors.message,"Error!");
                    } else if (xhr.status == 401) {
                        location.reload();
                    } else {
                        toastr["error"]("Error en el servidor", "Error!");
                    }
                }
            });
        });
    });

    function numberOnly(id) {
        var element = document.getElementById(id);
        var regex = /[^0-9]/gi;
        element.value = element.value.replace(regex, "");
    }

    function disbaledButton (){
        if($('#period option:selected').val() == ''){
            $(".desactivar").attr('disabled',true);
            // $(".ocultar").hide("slow");
        }else{
            $(".desactivar").attr('disabled',false);
            // $(".ocultar").show("slow");
        } 
    }
</script>
@endsection
