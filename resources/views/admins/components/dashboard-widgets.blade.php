{{-- Today's update --}}
<div class="card border border-danger">

    <div class="card-header">
        <h3> Today's update ({{ date('l, d F Y') }})</h3>
    </div>

    <div class="card-body">

        {{-- First row --}}
        <div class="row">

            {{-- Will be suspended --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="will_be_suspended">0</h3>
                        <p>
                            Customers will be suspended
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-down"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['will_be_suspended' => 1]) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Will be suspended --}}

            {{-- Amount to be collected --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="amount_to_be_collected">0</h3>
                        <p>Amount to be collected</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    @can('viewCustomerBills')
                    <a href="{{ route('customer_bills.index', ['due_date' => date(config('app.date_format'))]) }}"
                        class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Amount to be collected --}}

            {{-- Collected Amount --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="collected_amount">0</h3>
                        <p>Collected Amount</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    @can('viewCustomerPayments')
                    <a href="{{ route('customer_payments.index', ['date' => date(config('app.date_format'))]) }}"
                        class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Collected Amount --}}

        </div>
        {{-- First row --}}

    </div>

</div>
{{-- Today's update --}}

<div class="card">

    <div class="card-body">

        {{-- First row --}}
        <div class="row">

            {{-- Online Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="online_customers">0</h3>
                        <p>
                            Online Customers
                            @if (Auth::user()->role == "group_admin")
                            (Including Reseller)
                            @endif
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    @can('viewOnlineCustomers')
                    <a href="{{ route('online_customers.index') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Online Customers --}}

            {{-- Active Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="active_customers">0</h3>
                        <p>Active Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-creative-commons-sampling"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['status' => 'active']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Active Customers --}}

            {{-- Suspended Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="suspended_customers">0</h3>
                        <p>Suspended Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['status' => 'suspended']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan

                </div>
            </div>
            {{-- Suspended Customers --}}

        </div>
        {{-- First row --}}

        {{-- Second row --}}
        <div class="row">

            {{-- disabled Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="disabled_customers">0</h3>
                        <p>Disabled Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-thumbs-down"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['status' => 'disabled']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan

                </div>
            </div>
            {{-- disabled Customers --}}

            {{-- Billed Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="billed_customers">0</h3>
                        <p>Billed Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['payment_status' => 'billed']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Billed Customers --}}

            {{-- Paid Customers --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="paid_customers">0</h3>
                        <p>Paid Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['payment_status' => 'paid']) }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Paid Customers --}}

        </div>
        {{-- Second row --}}


        {{-- Third row --}}
        <div class="row">

            {{-- Amount Paid --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="amount_paid">0</h3>
                        <p>
                            Amount Paid,
                            {{ date(config('app.month_format')) }} - {{ date(config('app.year_format')) }}
                        </p>

                    </div>
                    <div class="icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    @can('viewCustomerPayments')
                    <a href="{{ route('customer_payments.index', ['year' => date(config('app.year_format')), 'month' => date(config('app.month_format'))]) }}"
                        class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Amount Paid --}}

            {{-- Amount Due --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="amount_due">0</h3>
                        <p>
                            Amount Due,
                            {{ date(config('app.month_format')) }} - {{ date(config('app.year_format')) }}
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    @can('viewCustomerBills')
                    <a href="{{ route('customer_bills.index', ['year' => date(config('app.year_format')), 'month' => date(config('app.month_format'))]) }}"
                        class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- Amount Due --}}

            {{-- SMS Sent --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="sms_sent">0</h3>
                        <p>
                            SMS Sent,
                            {{ date(config('app.month_format')) }} - {{ date(config('app.year_format')) }}
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    @can('viewSmsHistories')
                    <a href="{{ route('sms_histories.index', ['year' => date(config('app.year_format')), 'month' => date(config('app.month_format'))]) }}"
                        class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- SMS Sent --}}

        </div>
        {{-- Third row --}}

        {{-- Fourth row --}}
        <div class="row">

            {{-- User Registrations --}}
            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="user_registrations">0</h3>
                        <p>
                            User Registrations,
                            {{ date(config('app.month_format')) }} - {{ date(config('app.year_format')) }}
                        </p>

                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    @can('viewCustomerDetails')
                    <a href="{{ route('customers.index', ['year' => date(config('app.year_format')), 'month' => date(config('app.month_format'))]) }}"
                        class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                    @endcan
                </div>
            </div>
            {{-- User Registrations --}}

            {{-- Account Balance --}}
            @if (Auth::user()->role == 'operator' ||
            Auth::user()->role == 'sub_operator')
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="account_balance">
                            @if (Auth::user()->account_type == 'credit')
                            {{ Auth::user()->credit_balance }}
                            @else
                            {{ Auth::user()->account_balance }}
                            @endif
                        </h3>
                        <p>
                            Account Balance
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                </div>
            </div>
            @endif
            {{-- Account Balance --}}

            {{-- sms_balance --}}
            @if (Auth::user()->role == 'group_admin' ||
            Auth::user()->role == 'operator' ||
            Auth::user()->role == 'sub_operator')

            <div class="col-lg-4 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="sms_balance">
                            {{ Auth::user()->sms_balance }}
                            {{ config('consumer.currency') }}
                        </h3>
                        <p>
                            SMS Balance
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <a href="{{ route('advance_sms_payments.create') }}" class="small-box-footer">
                        Add SMS Balance <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            @endif
            {{-- sms_balance --}}

            {{-- total_customer --}}
            @if (Auth::user()->role == 'group_admin')
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total_customer">0</h3>
                        <p>
                            Total Customer
                            (Including Reseller)
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            @endif
            {{-- total_customer --}}

        </div>
        {{-- Fourth row --}}

        {{-- Fifth row --}}
        <div class="row">

            {{-- total_customer --}}
            @if (Auth::user()->role !== 'group_admin')
            <div class="col-lg-4 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total_customer">0</h3>
                        <p>
                            Total Customer
                        </p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            @endif
            {{-- total_customer --}}

        </div>
        {{-- Fifth row --}}

    </div>

</div>
