@extends ('laraview.layouts.topNavLayout')

@section('title')
Complaints
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
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
        $active_link = '6';
        @endphp
        @include('customers.nav-links')
    </div>
    {{-- Navigation bar --}}

    {{-- New Complaint --}}
    <ul class="nav justify-content-end">

        <li class="nav-item">
            <a class="nav-link text-danger"
                href="{{ route('complaints-customer-interface.create', ['mobile' => $customer->mobile]) }}"
                onclick="showWait()">
                <i class="fas fa-plus"></i>
                New Complaint
            </a>
        </li>

    </ul>
    {{-- New Complaint --}}

    <div class="card-body">

        <table id="data_table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Category</th>
                    <th scope="col">Complaint</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->category->name }}</td>
                    <td>{{ $complaint->message }}</td>
                    <td>{{ $complaint->status }}</td>
                    <td>
                        <a href="{{ route('complaints-customer-interface.show', ['customer_complain' => $complaint->id]) }}"
                            onclick="showWait()">
                            <i class="fas fa-exchange-alt"></i>
                            Details
                        </a>
                    </td>
                </tr>
                @endforeach
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
