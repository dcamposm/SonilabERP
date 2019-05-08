@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="alias_usuari" class="col-md-4 col-form-label text-md-right">{{ __('Usuari') }}</label>

                            <div class="col-md-6">
                                <input id="alias_usuari" type="text" class="form-control{{ $errors->has('alias_usuari') ? ' is-invalid' : '' }}" name="alias_usuari" value="{{ old('alias_usuari') }}" required autofocus>

                                @if ($errors->has('alias_usuari'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alias_usuari') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contrasenya') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-3 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Iniciar sessió') }}
                                </button>
                            </div>

                            <div class="col-4">
                                <div class="mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Desa el meu usuari') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
