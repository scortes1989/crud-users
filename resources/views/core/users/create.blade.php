@extends('layouts.app')

@section('title', 'Registrar Usuario')

@section('content')

<div class="container">

    <form method="POST" action="{{ url('core/users') }}">

        {{ csrf_field() }}

        @include('core.users.form')

        <div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>

</div>

@endsection