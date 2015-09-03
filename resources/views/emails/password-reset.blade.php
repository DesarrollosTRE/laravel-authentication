@extends(config('authentication.emailView'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">{{ trans('authentication::password-reset.edit') }}</h1>
                <p>{!! trans('authentication::password-reset.link', ['url' => route('authentication::password-reset.edit', ['token' => $reset->token])]) !!}</p>
            </div>
        </div>
    </div>
@endsection