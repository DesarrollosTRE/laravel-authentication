@extends(config('authentication.parentView'))

@section('title', trans('authentication::password.edit'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">{{ trans('authentication::password.edit') }}</h1>
                @include('authentication::forms.password.edit')
            </div>
        </div>
    </div>
@endsection