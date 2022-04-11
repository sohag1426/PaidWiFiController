@section('contentTitle')
<h3>Replace Package</h3>
@endsection

@section('content')

<div class="card">

    <p class="text-danger">* required field</p>

    <form method="POST" action="{{ route('packages.replace.store', ['package' =>  $package->id ]) }}"
        onsubmit="return showWait()">

        @csrf

        <div class="card-body">

            <!--name-->
            <div class="form-group">
                <label for="name">Package Name (To be Replaced)</label>

                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    value="{{ $package->name }} :: {{ long2ip($package->master_package->pppoe_profile->ipv4pool->subnet) .'/' . $package->master_package->pppoe_profile->ipv4pool->mask }}"
                    disabled>

                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <!--/name-->

            <!--package_id-->
            <div class="form-group">
                <label for="package_id"><span class="text-danger">*</span>Package</label>
                <select class="form-control" id="package_id" name="package_id" required>
                    <option value="">Please select...</option>
                    @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->name }} :: {{
                        long2ip($package->master_package->pppoe_profile->ipv4pool->subnet) .'/' .
                        $package->master_package->pppoe_profile->ipv4pool->mask }}</option>
                    @endforeach
                </select>
                @error('package_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <!--/package_id-->

        </div>
        <!--/Card Body-->

        <div class="card-footer">
            <button type="submit" class="btn btn-dark">Submit</button>
        </div>
        <!--/card-footer-->

    </form>

</div>

@endsection

@section('pageJs')
@endsection
