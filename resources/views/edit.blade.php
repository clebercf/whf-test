<!-- edit.blade.php -->
<!--
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
  <body>
    <div class="container">
      <h2>Atualiza Cadastro de Usuário</h2><br  />
        <form method="post" action="{{action('UserController@update', $id)}}">
        @csrf
        <input name="_method" type="hidden" value="PATCH">

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="Email">Email</label>
                <input type="text" class="form-control" name="email" value="{{$user->email}}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <label for="Name">Nome</label>
                <input type="text" class="form-control" name="name" value="{{$user->name}}">
            </div>
        </div>
        @php
            $date=date('Y-m-d', $user['birth_date']);
        @endphp
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <strong>Data de aniversário</strong>  
                <input class="date form-control"  type="date" id="birth_date" name="birth_date" value="{{$date}}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4"> 
                <strong>CPF</strong>  
                <input class="form-control" type="text" pattern="\d{11}" id="cpf" name="cpf" value="{{$user->cpf}}">   
            </div>
        </div>

        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4" style="margin-top:60px">
                <button type="submit" class="btn btn-success" style="margin-left:38px">Update</button>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

      </form>
    </div>
  </body>
</html>
-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar usuário') }}</div>

                <div class="card-body">
                    <form method="post" action="{{action('UserController@update', $id)}}" enctype="multipart/form-data">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH">
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{$user->name}}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cpf" class="col-md-4 col-form-label text-md-right">{{ __('CPF') }}</label>

                            <div class="col-md-6">
                                <input id="cpf" type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" value="{{$user->cpf}}" required autofocus>

                                @if ($errors->has('cpf'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                       <div class="form-group row">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-right">{{ __('Data de aniversário') }}</label>

                            <div class="col-md-6">
                                <input id="birth_date" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{$date}}" required autofocus>

                                @if ($errors->has('birth_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('birth_date') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @auth
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirma Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control" name="photo"/>
                            </div>
                        </div>
                        @endauth
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Atualizar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection