@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Olá!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @auth
                    <div class="form-group row ">
                        <img class="card-img-top; heigth:20px" src="{{url('uploads/'.Auth::user()->filename)}}" alt="{{Auth::user()->filename}}">
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">{{ __('Nome') }}</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" id="name" value="{{ Auth::user()->name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label">{{ __('Email') }}</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" id="email" value="{{ Auth::user()->email }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cpf" class="col-sm-4 col-form-label">{{ __('CPF') }}</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" id="cpf" value="{{ Auth::user()->cpf }}">
                        </div>
                    </div>
                    @php
                        $date=date('d-m-Y', Auth::user()->birth_date);
                    @endphp
                    <div class="form-group row">
                        <label for="birth_date" class="col-sm-4 col-form-label">{{ __('Data de Nascimento') }}</label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control-plaintext" id="birth_date" value="{{ $date }}">
                        </div>
                    </div>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection