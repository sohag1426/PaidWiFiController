@extends ('laraview.layouts.topNavLayout')

@section('title')
Internet History
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $operator->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
{{-- Logout Button --}}
@include('customers.logout-nav')
{{-- Logout Button --}}
@endsection

@section('content')

<div class="card">

    {{-- Navigation bar --}}
    <div class="card-header">
        @php
        $active_link = '2';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    <div class="card-body">

        <table id="data_table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Start Time</th>
                    <th scope="col">Stop Time</th>
                    <th scope="col">Total Time</th>
                    <th scope="col">Terminate Cause</th>
                    <th scope="col">Download(MB)</th>
                    <th scope="col">Upload(MB)</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total_download = 0;
                $total_upload = 0;
                @endphp
                @foreach ($customer->radaccts->sortBy('acctstoptime') as $radacct)
                @php
                $total_download = $total_download + $radacct->acctoutputoctets;
                $total_upload = $total_upload + $radacct->acctinputoctets;
                @endphp
                <tr>
                    <td>{{ $radacct->acctstarttime }}</td>
                    <td>{{ $radacct->acctstoptime }}</td>
                    <td>{{ sToHms($radacct->acctsessiontime) }}</td>
                    <td>{{ $radacct->acctterminatecause }}</td>
                    <td>{{ $radacct->acctoutputoctets/1000000 }}</td>
                    <td>{{ $radacct->acctinputoctets/1000000 }}</td>
                </tr>
                @endforeach
                @foreach ($radaccts_history->sortByDesc('acctstoptime') as $radacct_history)
                @php
                $total_download = $total_download + $radacct_history->acctoutputoctets;
                $total_upload = $total_upload + $radacct_history->acctinputoctets;
                @endphp
                <tr>
                    <td>{{ $radacct_history->acctstarttime }}</td>
                    <td>{{ $radacct_history->acctstoptime }}</td>
                    <td>{{ sToHms($radacct_history->acctsessiontime) }}</td>
                    <td>{{ $radacct_history->acctterminatecause }}</td>
                    <td>{{ $radacct_history->acctoutputoctets/1000000 }}</td>
                    <td>{{ $radacct_history->acctinputoctets/1000000 }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total:</td>
                    <td>{{ $total_download/1000000 }}</td>
                    <td>{{ $total_upload/1000000 }}</td>
                </tr>
            </tbody>
        </table>

    </div>


    <div class="card-body">
        <a href="{{ route('customers.packages',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">
            Buy Package
        </a>
        <a href="{{ route('customers.profile',['mobile' => $customer->mobile]) }}" class="card-link"
            onclick="showWait()">
            Profile
        </a>
    </div>

</div>

@endsection

@section('pageJs')
@endsection
