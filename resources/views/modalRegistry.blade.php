<div class="modal-header">
    <h5 class="modal-title" id="modalDefaultLabel"><i class='mdi mdi-account-card-details-outline'></i>&nbsp; {{$title}}</h5>
    <button type="button" class="close load" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
        <div id="load" class="col-12 m-auto text-center loader" style="display: none;">
            <i class="mdi mdi-spin mdi-loading" style="font-size: 90px;"></i>
            </br><span style="font-size: 20px;">Guardando ...<span>
        </div>
        <form id="formDefault" class="loader row">
        @csrf
        <div class="col-12" >
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Periodo:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="periodo" placeholder="Periodo" value="{{ isset($tmp) ? $tmp->name : ''}}" required disabled>
                </div>
            </div>
        </div>
        <div class="col-12" >
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Código IES:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="codigo_ies" placeholder="Código IES" value="{{ isset($tmp) ? $tmp->name : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12" >
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Código Carrera:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="codigo_carrera" placeholder="Código Carrera" value="{{ isset($tmp) ? $tmp->name : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12" >
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Identificación Estudiante:</label>
                <div class="col-sm-7">
                    <input type="text" oninput="numberOnly(this.id);"  maxlength="10" class="form-control" name="ci_estudiante" id="ci_estudiante" placeholder="Identificación Estudiante" value="{{ isset($tmp) ? $tmp->name : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Nombre Estudiante:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="nombre_estudiante" placeholder="Nombre Estudiante" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Nombre Institución:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="nombre_institucion" placeholder="Nombre Institución" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Tipo Institución:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="tipo_institucion" placeholder="Tipo Institución" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Fecha Inicio:</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="fecha_inicio" placeholder="Fecha Inicio" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Fecha Fin:</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="fecha_fin" placeholder="Fecha Fin" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Número Horas:</label>
                <div class="col-sm-7">
                    <input type="number" min="1" max='9999' class="form-control" name="numero_horas" placeholder="Número Horas" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Campo Específico:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="campo_especifico" placeholder="Campo Específico" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">
                <label class="control-label col-sm-3 my-auto text-right" ><span class="text-danger">*&nbsp;</span>Docente Tutor:</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="docente_tutor" placeholder="Docente Tutor" value="{{ isset($tmp) ? $tmp->alias : ''}}" required>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group row">  
                <label class="control-label col-sm-3 my-auto text-right" >&nbsp;Convalidación horas trabajo:</label>     
                <div class="col-sm-7"> 
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="convalidacion" name="convalidacion"{{ isset($tmp) ? ($tmp->status ? 'checked':'') : ''}} value="1">
                        <label class="custom-control-label" for="convalidacion">&nbsp;</label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger load" data-dismiss="modal"><i class="mdi mdi-cancel"></i>&nbsp;Cancelar</button>
    <button id="save" type="button" data-url="{{$url}}" class="btn btn-success load" ><i class='mdi mdi-content-save'></i>&nbsp; Guardar</button>
</div>
<script>
    $(document).ready(function() {
        $('#save').click(function() {
            if ($('#load').is(':visible')) {
                $('#load').toggle();
            }
            $('.loader').toggle();
            $('.load').attr('disabled', true);
            url = $(this).data("url");
            $.ajax({
                url: url,
                type: 'POST',
                data: $('#formDefault').serialize(),
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
</script>