@extends('layouts.app', ["titulo" => "MaisCode Editar Roles"])


@section('content-breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Usuário</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Usuários</li>
            </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-none">Grid With Row Label</h4>
                    <form action="{{ route('dashboard.usuarios.update', ['usuario' => $usuario->id]) }}" method="POST">
                        @csrf
                        {{ method_field('PUT') }}
                        <p class="">Nome: <strong>{{ $usuario->name }}</strong></p>
                        <p class="">E-mail: <strong>{{ $usuario->email }}</strong></p>
                        <p class="group-field">
                            @foreach ($roles as $role)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="custom-control-input" id="role_{{ $role->id }}" {{ $usuario->hasAnyRole($role->name) ? 'checked':'' }}>
                                    <label class="custom-control-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            @endforeach
                        </p>


                        

                        <div class="form-actions">
                            <div class="text-right">
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
