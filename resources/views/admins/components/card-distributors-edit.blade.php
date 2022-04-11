@section('contentTitle')

<h3>Edit Card Distributor</h3>

@endsection

@section('content')

<div class="card">

    <div class="card-body">

        <p class="text-danger">* required field</p>

        <div class="row">
            <div class="col-sm-6">
                <form id="quickForm" method="POST"
                    action="{{ route('card_distributors.update', ['card_distributor' => $card_distributor->id ]) }}">
                    @csrf
                    @method('put')

                    <!--name-->
                    <div class="form-group">
                        <label for="name"><span class="text-danger">*</span>Name</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ $card_distributor->name }}" autocomplete="name" required>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/name-->

                    <!--mobile-->
                    <div class="form-group">
                        <label for="mobile"><span class="text-danger">*</span>Mobile</label>
                        <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                            id="mobile" value="{{ $card_distributor->mobile }}" autocomplete="mobile" required>
                        @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/mobile-->

                    <!--store_name-->
                    <div class="form-group">
                        <label for="store_name"><span class="text-danger">*</span>Store Name</label>
                        <input name="store_name" type="text"
                            class="form-control @error('store_name') is-invalid @enderror" id="store_name"
                            value="{{ $card_distributor->store_name }}" autocomplete="store_name" required>
                        @error('store_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/store_name-->

                    {{-- store_address --}}
                    <div class="form-group">
                        <label for="store_address"><span class="text-danger">*</span>Store Address</label>
                        <textarea name="store_address" class="form-control" id="store_address" rows="3"
                            required>{{ $card_distributor->store_address }}</textarea>
                    </div>
                    {{-- store_address --}}

                    <button type="submit" class="btn btn-dark">Submit</button>

                </form>

            </div>
            <!--/col-sm-6-->

        </div>
        <!--/row-->

    </div>
    <!--/card-body-->

</div>

@endsection

@section('pageJs')
@endsection
