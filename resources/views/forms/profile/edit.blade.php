<form action="{{ $route or route('authentication::profile.update') }}" method="post">

    {!! method_field('patch') !!}

    {!! csrf_field() !!}

    @if(config('authentication.registration.userName') != 'off')
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="control-label">{{ trans('authentication::user.name') }}</label>
            @if(config('authentication.registration.userName') == 'required')
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            @else
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control">
                <div class="help-block">{{ trans('authentication::user.optional') }}</div>
            @endif
            {!! $errors->first('name', '<div class="help-block">:message</div>') !!}
        </div>
    @endif

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="control-label">{{ trans('authentication::user.email') }}</label>
        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        {!! $errors->first('email', '<div class="help-block">:message</div>') !!}
    </div>

    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">
            {{ trans('authentication::profile.update') }}
        </button>
        <a href="{{ route('authentication::profile.show') }}" class="btn btn-link">
            {{ trans('authentication::core.cancel') }}
        </a>
    </div>

</form>