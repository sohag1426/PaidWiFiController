@section('contentTitle')
<h3>Download Customers</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <form method="POST" action="{{ route('download-users-downloadable.store') }}">

            @csrf

            @include('admins.components.download-users-options')

        </form>

    </div>
    <!--/card-body-->

</div>

@endsection

@section('pageJs')
@endsection
