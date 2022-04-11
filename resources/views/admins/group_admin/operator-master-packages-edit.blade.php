@extends ('laraview.layouts.sideNavLayout')

@section('title')
Edit Package
@endsection

@section('pageCss')
@endsection

@section('activeLink')
@php
if(Auth::user()->id == $operator->id){
$active_menu = '2';
$active_link = '7';
} else {
$active_menu = '1';
$active_link = '1';
}
@endphp
@endsection

@section('sidebar')
@include('admins.group_admin.sidebar')
@endsection


@section('contentTitle')
<h3>Edit Package</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title font-weight-bold">Operator: {{ $operator->name }}</h3>
    </div>

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST"
            action="{{ route('operators.master_packages.update', ['master_package' => $master_package->id, 'operator' => $operator->id]) }}">

            @csrf

            @method('PUT')

            <div class="col-sm-6">

                <!--name-->
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>Name</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $master_package->name }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <!--/name-->

                <!--price-->
                <div class="form-group">
                    <label for="price"><span class="text-danger">*</span>Customer's Price</label>

                    <div class="input-group">
                        <input name="price" type="number" class="form-control @error('price') is-invalid @enderror"
                            id="price" value="{{ $master_package->price }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ config('consumer.currency') }}</span>
                        </div>
                    </div>

                    @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/price-->

                <!--operator_price-->
                <div class="form-group">
                    <label for="operator_price"><span class="text-danger">*</span>Operator's Price</label>

                    <div class="input-group">
                        <input name="operator_price" type="number"
                            class="form-control @error('operator_price') is-invalid @enderror" id="operator_price"
                            value="{{ $master_package->operator_price }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ config('consumer.currency') }}</span>
                        </div>
                    </div>

                    @error('operator_price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/operator_price-->

                <!--visibility-->
                <div class="form-group">
                    <label for="visibility"><span class="text-danger">*</span>Visibility</label>

                    <div class="input-group">

                        <select class="form-control" id="visibility" name="visibility" required>
                            <option selected>{{ $master_package->visibility }}</option>
                            <option>public</option>
                            <option>private</option>
                        </select>

                    </div>

                    @error('visibility')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/visibility-->

            </div>
            <!--/col-sm-6-->

            <div class="col-sm-6">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>

        </form>

    </div>

</div>

@endsection

@section('pageJs')
@endsection
