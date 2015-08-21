<form action="{{ $route or route('authentication::user.store') }}" method="post">

    {!! csrf_field() !!}

    @if(config('authentication.registration.userName') != 'off')
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="control-label">{{ trans('authentication::user.name') }}</label>
            @if(config('authentication.registration.userName') == 'required')
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
            @else
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
                <div class="help-block">{{ trans('authentication::user.optional') }}</div>
            @endif
            {!! $errors->first('name', '<div class="help-block">:message</div>') !!}
        </div>
    @endif

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="control-label">{{ trans('authentication::user.email') }}</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
        {!! $errors->first('email', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password" class="control-label">{{ trans('authentication::user.password') }}</label>
        <input type="password" name="password" id="password" class="form-control" required>
        {!! $errors->first('password', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group">
        <label for="password_confirmation" class="control-label">{{ trans('authentication::user.password_confirmation') }}</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">
            {{ trans('authentication::user.create') }}
        </button>
    </div>

</form>