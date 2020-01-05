@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (Auth::user()->email == 'admin@admin.com')
                    <div class="card-header">Cambiar Contraseña</div>
                    <div class="card-body">
                        <form method="POST" action="{{ $url }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" disabled value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Reestablecer</button>
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
