@extends('laraview.layouts.topNavLayout')

@section('title')
New Complaint
@endsection

@section('pageCss')
@endsection

@section('company')
{{ $customer->company }}
@endsection

@section('topNavbar')
@endsection

@section('contentTitle')
@include('customers.logout-nav')
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <h3> New Complaint </h3>

        <div class="row">

            <div class="col-sm-6">

                <form method="POST"
                    action="{{ route('complaints-customer-interface.store', ['mobile' => $customer->mobile]) }}"
                    onsubmit="return showWait()">

                    @csrf

                    <!--category_id-->
                    <div class="form-group">
                        <label for="category_id"><span class="text-danger">*</span>Category</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value=''>category...</option>
                            @foreach ($complain_categories as $complain_category)
                            <option value="{{ $complain_category->id }}">{{ $complain_category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/category_id-->

                    {{-- message --}}
                    <div class="form-group">
                        <label for="message">Complain</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    {{-- message --}}

                    <button type="submit" class="btn btn-dark">SUBMIT</button>

                </form>

            </div>
            <!--/col-sm-6-->

        </div>
        <!--/row-->

    </div>

</div>

@endsection

@section('pageJs')
@endsection
