@extends('layouts.app', ["titulo" => "MaisCode Editar Roles"])


@section('content-breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Editar Categoria</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="" class="text-muted">Admin</a></li>
                        <li class="breadcrumb-item"><a href="" class="text-muted">Imóveis</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>        
    </div>
</div>
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
