@extends('layouts.app')
@section('content')
@if (Auth::user()->email != 'admin@admin.com')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Atención !</div>
                    <div class="card-body">Usuario sin permisos</div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Usuarios 
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="bg-principal text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Fecha de Creación</th>
                                    <th scope="col">Fecha de Modificación</th>
                                    <th class="text-center" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <th scope="row">{{$item->id}}</th>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->email}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->updated_at}}</td>
                                        <td class="text-center">
                                            <button class="btn btn-principal btn-sm text-white btnHref" title="Editar" data-url="{{ route('editUser',['id' => $item->id])}}"><i class="mdi mdi-pencil"></i></button> 
                                            <button class="btn btn-warning btn-sm btnHref" title="Contraseña" data-url="{{ route('editPassword',['id' => $item->id])}}"><i class="mdi mdi-key-variant"></i></button> 
                                            <button class="btn btn-danger btn-sm text-white eliminarUsuario" title="Eliminar"  {{$item->email == 'admin@admin.com' ? 'disabled' : '' }}  data-url="{{ route('deleteUser',['id' => $item->id])}}"><i class="mdi mdi-delete"></i></button> 
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <nav class="float-right" aria-label="Page navigation example">
                            {!! str_replace('/?', '?', $users->appends(app('request')->query())->render()) !!}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
@section('js')
<script>
    url = '';
    $(document).ready(function() {
        $('.eliminarUsuario').click(function() {
            url = $(this).data("url");
            swal({
              title: "Atencion !",
              text: 'Seguro desea borrar el Usuario',
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
    });
</script>
@endsection