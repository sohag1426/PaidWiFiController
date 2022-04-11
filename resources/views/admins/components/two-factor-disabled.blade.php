@section('contentTitle')
<h3>Two Factor Authentication</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="card-text">
            You have not enabled two factor authentication.
        </p>

        <p class="card-text">
            When two factor authentication is enabled, you will be prompted for a secure, random token during
            authentication.
            You may retrieve this token from your phone's Google Authenticator application.
        </p>

        <form method="POST" action="{{ route('two-factor.store') }}">
            @csrf
            <input type="hidden" name="action" value="enable">
            <button type="submit" class="btn btn-dark">ENABLE</button>
        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
