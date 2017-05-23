<div class="row">
    <div class="col-md-4 form-group">
        <label>Nombre</label>
        <input type="text" class="form-control" name="name" value="{{ isset($user) ? $user->name : '' }}">
        <p class="text-danger">{{ $errors->first('name') }}</p>
    </div>
    <div class="col-md-4 form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" value="{{ isset($user) ? $user->email : '' }}">
        <p class="text-danger">{{ $errors->first('email') }}</p>
    </div>
</div>
<div class="row">
    <div class="col-md-4 form-group">
        <label>Contraseña</label>
        <input type="password" class="form-control" name="password">
        <p class="text-danger">{{ $errors->first('password') }}</p>
    </div>
    <div class="col-md-4 form-group">
        <label>Rol</label>
        <select class="form-control" name="role_id">
            <option value="">--Seleccione--</option>
            @foreach($roles as $key => $val)
                @if(isset($user) && $user->role_id == $key)
                    <option selected value="{{ $key }}">
                        {{ $val }}
                    </option>
                @else
                    <option value="{{ $key }}">
                        {{ $val }}
                    </option>
                @endif
            @endforeach
        </select>
        <p class="text-danger">{{ $errors->first('role_id') }}</p>
    </div>
</div>
