@extends('layouts.app')

@section('title', 'Usuarios del Sistema')

@section('content')

    <br>

    <br>

    <form method="GET">
        <div class="row">
            <div class="col-md-6 col-md-offset-1">
                <input type="text" class="form-control" name="filter" value="{{ request('filter') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-default">Buscar</button>
            </div>
        </div>

    </form>


    <table class="table">
        <thead>
            <tr>
                <th>Fecha de Creación</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <a href="{{ $user->edit_url }}">Editar</a>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role ? $user->role->name : '' }}</td>
                    <td>
                        {{--
                        @if($user->files)
                            <img src="{{ url($user->files->path) }}">
                        @endif
                        --}}
                    </td>
                </tr>
@endforeach
</tbody>
</table>
@endsection