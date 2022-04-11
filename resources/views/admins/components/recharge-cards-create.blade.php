@section('contentTitle')
<h3> Generate Recharge Cards</h3>
@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <form id="quickForm" method="POST" action="{{ route('recharge_cards.store') }}">

            @csrf
            <div class="col-sm-6">

                <!-- card_distributor_id -->
                <div class="form-group">
                    <label for="card_distributor_id"><span class="text-danger">*</span>Distributor</label>
                    <select name="card_distributor_id" id="card_distributor_id" class="form-control" required>
                        <option value="">please select...</option>
                        @foreach ($distributors as $distributor)
                        <option value="{{ $distributor->id }}">{{ $distributor->name }}</option>
                        @endforeach

                    </select>
                </div>
                <!--/card_distributor_id -->

                <!--package_id-->
                <div class="form-group">
                    <label for="package_id"><span class="text-danger">*</span>Package</label>

                    <div class="input-group">
                        <select name="package_id" id="package_id" class="custom-select mr-sm-2" required>
                            @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('package_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/package_id-->

                <!--commission-->
                <div class="form-group">
                    <label for="commission"><span class="text-danger">*</span>Commission/Card</label>

                    <div class="input-group">
                        <input name="commission" type="text"
                            class="form-control @error('commission') is-invalid @enderror" id="commission"
                            value="{{ old('commission') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text">{{ config('consumer.currency') }}</span>
                        </div>
                    </div>

                    @error('commission')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/commission-->

                <!--unit-->
                <div class="form-group">
                    <label for="unit"><span class="text-danger">*</span>Number of Cards</label>

                    <div class="input-group">
                        <input name="unit" type="text" class="form-control @error('unit') is-invalid @enderror"
                            id="unit" value="{{ old('unit') }}" required>
                    </div>

                    @error('unit')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                </div>
                <!--/unit-->

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
