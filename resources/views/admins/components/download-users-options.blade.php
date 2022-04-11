<div class="row">

    <div class="col-sm-6">

        {{-- connection_type --}}
        <div class="form-group">
            <label for="connection_type">Connection Type (Optional)</label>
            <select name="connection_type" id="connection_type" class="form-control">
                <option value=''>Please select...</option>
                <option value='PPPoE'>PPP</option>
                <option value='Hotspot'>Hotspot</option>
                <option value='StaticIp'>StaticIp</option>
            </select>
        </div>
        {{--connection_type --}}

        {{-- status --}}
        <div class="form-group">
            <label for="status">Status (Optional)</label>
            <select name="status" id="status" class="form-control">
                <option value=''>Please select...</option>
                <option value='active'>active</option>
                <option value='suspended'>suspended</option>
            </select>
        </div>
        {{--status --}}

        {{-- payment_status --}}
        <div class="form-group">
            <label for="payment_status">payment status (Optional)</label>
            <select name="payment_status" id="payment_status" class="form-control">
                <option value=''>Please select...</option>
                <option value='billed'>billed</option>
                <option value='paid'>paid</option>
            </select>
        </div>
        {{--payment_status --}}

        {{-- zone_id --}}
        <div class="form-group">
            <label for="zone_id">zone (Optional)</label>
            <select name="zone_id" id="zone_id" class="form-control">
                <option value=''>Please select...</option>
                @foreach (Auth::user()->customer_zones as $customer_zone)
                <option value="{{ $customer_zone->id }}">{{ $customer_zone->name }}</option>
                @endforeach
            </select>
        </div>
        {{--zone_id --}}

        {{-- package_id --}}
        <div class="form-group">
            <label for="package_id">package (Optional)</label>
            <select name="package_id" id="package_id" class="form-control">
                <option value=''>Please select...</option>
                @foreach (Auth::user()->assigned_packages as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
                @endforeach
            </select>
        </div>
        {{--package_id --}}

        {{-- year --}}
        <div class="form-group">
            <label for="year">year (Optional)</label>
            <select name="year" id="year" class="form-control">
                <option value=''>Please select...</option>
                @php
                $start = date(config('app.year_format'));
                $stop = $start - 5;
                @endphp
                @for($i = $start; $i >= $stop; $i--)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        {{--year --}}

        {{-- month --}}
        <div class="form-group">
            <label for="month">month (Optional)</label>
            <select name="month" id="month" class="form-control">
                <option value=''>Please select...</option>
                <option value='January'>January</option>
                <option value='February'>February</option>
                <option value='March'>March</option>
                <option value='April'>April</option>
                <option value='May'>May</option>
                <option value='June'>June</option>
                <option value='July'>July</option>
                <option value='August'>August</option>
                <option value='September'>September</option>
                <option value='October'>October</option>
                <option value='November'>November</option>
                <option value='December'>December</option>
            </select>
        </div>
        {{--month --}}

        {{-- operator --}}
        @if (Auth::user()->role == 'group_admin')
        <div class="form-group">
            <label for="operator_id">operator (Optional)</label>
            <select name="operator_id" id="operator_id" class="form-control">
                <option value=''>Please select...</option>
                @foreach (Auth::user()->operators->where('role', '!=', 'manager') as $operator)
                <option value="{{ $operator->id }}"> {{ $operator->name }} </option>
                @endforeach
            </select>
        </div>
        @endif
        {{--operator --}}

    </div>
    <!--/col-sm-6-->

    <div class="col-sm-6">

        <div class="card-header font-weight-bold">Select Fields to Download</div>

        {{-- Fields --}}

        @foreach ($downloadable_fields as $k => $val)

        <div class="form-check">
            <input name="downloadable_fields[]" class="form-check-input" type="checkbox" value="{{ $k }}" id="{{ $k }}">
            <label class="form-check-label" for="{{ $k }}">
                {{ $val }}
            </label>
        </div>

        @endforeach

        {{-- Fields --}}

        <button type="submit" class="btn btn-dark mt-4">Download</button>

    </div>
    <!--/col-sm-6-->

</div>
<!--/row-->
