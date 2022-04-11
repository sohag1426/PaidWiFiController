@section('contentTitle')
<h3>Customer's General Information</h3>
@endsection

@section('content')

<div class="card">

    <form id="quickForm" method="POST"
        action="{{ route('temp_customers.customers.store', ['temp_customer' => $temp_customer->id]) }}"
        onsubmit="return showWait()">

        @csrf

        <div class="card-body">

            <div class="row">

                <div class="col-sm-6">

                    <!--house_no-->
                    <div class="form-group">
                        <label for="house_no">House#</label>
                        <input name="house_no" type="text" class="form-control @error('house_no') is-invalid @enderror"
                            id="house_no" value="{{ old('house_no') }}">
                        @error('house_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/house_no-->

                    <!--road_no-->
                    <div class="form-group">
                        <label for="road_no">Road#</label>
                        <input name="road_no" type="text" class="form-control @error('road_no') is-invalid @enderror"
                            id="road_no" value="{{ old('road_no') }}">
                        @error('road_no')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/road_no-->

                    <!--thana-->
                    <div class="form-group">
                        <label for="thana">Thana</label>
                        <input name="thana" type="text" class="form-control @error('thana') is-invalid @enderror"
                            id="thana" value="{{ old('thana') }}">
                        @error('thana')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/thana-->

                    <!--district-->
                    <div class="form-group">
                        <label for="district">District</label>
                        <input name="district" type="text" class="form-control @error('district') is-invalid @enderror"
                            id="district" value="{{ old('district') }}">
                        @error('district')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/district-->

                </div>

                <div class="col-sm-6">

                    <!--type_of_client-->
                    <div class="form-group">
                        <label for="type_of_client">Type of Client</label>
                        <input name="type_of_client" type="text"
                            class="form-control @error('type_of_client') is-invalid @enderror" id="type_of_client"
                            value="Home">
                        @error('type_of_client')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/type_of_client-->

                    <!--type_of_connection-->
                    <div class="form-group">
                        <label for="type_of_connection">Type of connection</label>
                        <input name="type_of_connection" type="text"
                            class="form-control @error('type_of_connection') is-invalid @enderror"
                            id="type_of_connection" value="Wired">
                        @error('type_of_connection')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/type_of_connection-->

                    <!--type_of_connectivity-->
                    <div class="form-group">
                        <label for="type_of_connectivity">Type of connectivity</label>
                        <input name="type_of_connectivity" type="text"
                            class="form-control @error('type_of_connectivity') is-invalid @enderror"
                            id="type_of_connectivity" value="Shared">
                        @error('type_of_connectivity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!--/type_of_connectivity-->

                </div>
                <!--/col-sm-6-->
            </div>
            <!--/row-->

            {{-- custom fields --}}
            <div class="row">
                @while ($custom_field = $custom_fields->shift())
                <div class="col">
                    <div class="form-group">
                        <label for="{{ $custom_field->id }}">{{ $custom_field->name }}</label>
                        <input name="{{ $custom_field->id }}" type="text" class="form-control"
                            id="{{ $custom_field->id }}" value="">
                    </div>
                </div>
                @endwhile
            </div>
            {{-- custom fields --}}

        </div>
        <!--/card-body-->

        <div class="card-footer">
            <button type="submit" class="btn btn-dark">SUBMIT</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')
@endsection
