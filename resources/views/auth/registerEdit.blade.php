@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (Auth::user()->email == 'admin@admin.com')
                    <div class="card-header">Editar Usuario</div>
                    <div class="card-body">
                        <form method="POST" action="{{ $url }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') != '' ? old('name') : $user->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" {{$user->email == 'admin@admin.com' ? 'disabled' : '' }}  name="email" value="{{ old('email') != '' ? old('email') : $user->email }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                    <button type="button" class="btn btn-danger btnHref" data-url="{{ route('users')}}">Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="card-header">Atención !</div>
                    <div class="card-body">Usuario sin permisos</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
