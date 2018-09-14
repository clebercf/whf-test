@extends('layouts.app')
<!-- index.blade.php -->

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Lista de Usuários') }}</div>

                <div class="card-body">
                  <form action="users" method="GET">
                    <div class="form-group row">
                        <div class="col-md-10">
                          <input type="text" class="form-control" name="searchTerm" placeholder="Procura por nome, cpf ou email..." value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                        </div>
                        <div class="col-md-2">
                          <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">Procurar</button>
                          </span>
                        </div>
                    </div>
                  </form>

                  <div class="row">
                    @if (\Session::has('success'))
                      <div class="alert alert-success">
                        <p>{{ \Session::get('success') }}</p>
                      </div><br />
                    @endif
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>ID</th>
                          @auth<th>Foto</th>@endauth
                          <th>Nome</th>
                          <th>Email</th>
                          <th>CPF</th>
                          <th>Data de aniversário</th>
                          <th colspan="2">Ações</th>
                        </tr>
                      </thead>
                      <tbody>

                      @foreach($users as $user)
                        @php
                          $date=date('d-m-Y', $user['birth_date']);
                        @endphp
                        <tr>
                          <td>{{$user['id']}}</td>
                          @auth
                          <td><img class="card-img-top; width:5px" src="{{url('uploads/'.$user['filename'])}}"></td>
                          @endauth
                          <td>{{$user['name']}}</td>
                          <td>{{$user['email']}}</td>
                          <td>{{$user['cpf']}}</td>
                          <td>{{$date}}</td>
                          <td>
                            <a href="{{action('UserController@edit', $user['id'])}}" class="btn btn-primary">Editar</a>
                          </td>
                          <td>
                            <form action="{{action('UserController@destroy', $user['id'])}}" method="post">
                              @csrf
                              <input name="_method" type="hidden" value="DELETE">
                              <button class="btn btn-danger" type="submit">Apagar</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                    {{ $users->appends(request()->query())->links()}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<!DOCTYPE html>
<html>
  <body>
    <div class="container">
    <br />
 
  </div>
  </body>
</html>
@endsection