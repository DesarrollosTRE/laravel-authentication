@extends(config('authentication.parentView'))

@section('title', trans('authentication::profile.show'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">{{ trans('authentication::profile.show') }}</h1>

                @if(config('authentication.registration.userName') != 'off')
                    <div class="form-group">
                        <label>{{ trans('authentication::user.name') }}</label>
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>
                @endif

                <div class="form-group">
                    <label>{{ trans('authentication::user.email') }}</label>
                    <p class="form-control-static">{{ $user->email }}</p>
                </div>

                <div class="form-group text-center">
                    <a href="{{ route('authentication::profile.edit') }}" class="btn btn-primary">
                        {{ trans('authentication::profile.edit') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection