@section('content')

<div class="card">

    <div class="card-body">

        <div class="row">

            <div class="col-sm-6">

                <form method="POST"
                    action="{{ route('temp_customers.update', ['temp_customer' => $temp_customer->id]) }}"
                    onsubmit="return showWait()">

                    @method('put')

                    @csrf

                    <!--billing_profile_id-->
                    <div class="form-group">
                        <label for="billing_profile_id"><span class="text-danger">*</span>
                            On which day of every month customer will pay
                            @if (config('consumer.country_code') == 'BD')
                            (প্রতি মাসের কোন দিনে গ্রাহক পেমেন্ট করবেন)
                            @endif
                        </label>
                        <select class="form-control" id="billing_profile_id" name="billing_profile_id" required>
                            @if ($selected_profile)
                            <option value="{{ $selected_profile->id }}" selected>
                                {{ $selected_profile->due_date_figure }}
                            </option>
                            @endif
                            @foreach ($billing_profiles->sortBy('billing_due_date') as $billing_profile)
                            <option value="{{ $billing_profile->id }}">{{ $billing_profile->due_date_figure }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/billing_profile_id-->

                    <!--package_id-->
                    <div class="form-group">
                        <label for="package_id"><span class="text-danger">*</span>Package</label>
                        <select class="form-control" id="package_id" name="package_id" required>
                            <option value="">Please select...</option>
                            @foreach ($packages->sortBy('name') as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--/package_id-->

                    <button type="submit" class="btn btn-dark">NEXT<i class="fas fa-arrow-right"></i></button>

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
