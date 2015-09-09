<form action="{{ route('authentication::user.ban', $user->id) }}" method="post">

    {!! method_field('patch') !!}

    {!! csrf_field() !!}

    <button type="submit" class="btn btn-link">
        {{ trans('authentication::user.ban') }}
    </button>

</form>