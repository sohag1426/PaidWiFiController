@section('contentTitle')
<h3>Two Factor Authentication</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="card-text">
            You have enabled two factor authentication.
        </p>

        <p class="card-text">
            When two factor authentication is enabled, you will be prompted for a secure, random token during
            authentication.
            You may retrieve this token from your phone's Google Authenticator application.
        </p>

        <p class="card-text">
            Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator
            application.
        </p>

        <img src="data:image/svg+xml;base64, {{ $qrcode_image  }}" />

        <form method="POST" action="{{ route('two-factor.delete') }}">
            @csrf
            <input type="hidden" name="action" value="disable">
            <button type="submit" class="btn btn-danger">DISABLE</button>
        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
