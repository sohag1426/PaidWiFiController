@section('contentTitle')
Edit Package
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST" action="{{ route('packages.update', ['package' => $package->id]) }}">

            @csrf

            @method('PUT')

            <div class="col-sm-6">

                <!--package_owner-->
                <div class="form-group">
                    <label for="package_owner">Package Owner</label>
                    <input type="text" class="form-control" id="package_owner"
                        value="{{ $package->operator->id }} :: {{ $package->operator->name }}" disabled>
                </div>
                <!--/package_owner-->

                <!--master_package-->
                <div class="form-group">
                    <label for="master_package">Master Package</label>
                    <input type="text" class="form-control" id="master_package"
                        value="{{ $package->master_package->name }}" disabled>
                </div>
                <!--/master_package-->

                <!--name-->
                @if (Auth::user()->can('updateName', $package))
                <div class="form-group">
                    <label for="name"><span class="text-danger">*</span>Name</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $package->name }}" required>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                @else
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        value="{{ $package->name }}" disabled>
                </div>
                @endif
                <!--/name-->

                <!--price-->
                @if (Auth::user()->can('updatePrice', $package))
                <div class="form-group">
                    <label for="price"><span class="text-danger">*</span>Customer's Price</label>

                    <div class="input-group">
                        <input name="price" type="number" class="form-control @error('price') is-invalid @enderror"
                            id="price" value="{{ $package->price }}" required>
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
                @else
                <div class="form-group">
                    <label for="price">Customer's Price</label>

                    <div class="input-group">
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            value="{{ $package->price }}" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ config('consumer.currency') }}</span>
                        </div>
                    </div>

                </div>
                @endif
                <!--/price-->

                <!--operator_price-->
                @if (Auth::user()->can('updateOperatorPrice', $package))
                <div class="form-group">
                    <label for="operator_price"><span class="text-danger">*</span>Operator's Price</label>

                    <div class="input-group">
                        <input name="operator_price" type="number"
                            class="form-control @error('operator_price') is-invalid @enderror" id="operator_price"
                            value="{{ $package->operator_price }}" required>
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
                @else
                <div class="form-group">
                    <label for="operator_price"><span class="text-danger">*</span>Operator's Price</label>

                    <div class="input-group">
                        <input type="number" class="form-control @error('operator_price') is-invalid @enderror"
                            id="operator_price" value="{{ $package->operator_price }}" disabled>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ config('consumer.currency') }}</span>
                        </div>
                    </div>

                </div>
                @endif
                <!--/operator_price-->

                <!--visibility-->
                @can('updateName', $package)
                <div class="form-group">
                    <label for="visibility"><span class="text-danger">*</span>Visibility</label>

                    <div class="input-group">

                        <select class="form-control" id="visibility" name="visibility" required>
                            <option selected>{{ $package->visibility }}</option>
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
                @endcan
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
