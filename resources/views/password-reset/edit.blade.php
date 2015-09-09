@extends(config('authentication.views.app'))

@section('title', trans('authentication::password-reset.edit'))

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-push-3">
                <h1 class="page-header">@lang('authentication::password-reset.edit')</h1>
                @include('authentication::forms.password-reset.edit')
            </div>
        </div>
    </div>
@endsection