@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')

<div class="container">

    <form method="POST" action="{{ url('core/users/'.$user->id) }}">

        <input type="hidden" name="_method" value="PUT">

        {{ csrf_field() }}

        @include('core.users.form')

        <div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>

</div>

@endsection