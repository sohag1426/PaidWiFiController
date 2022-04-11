@if ($fair_usage_policy->id == 0)

<h1 class="display-4">No fair usage policy found</h1>

<a class="btn btn-dark"
    href="{{ route('master_packages.fair_usage_policy.create', ['master_package' => $master_package->id]) }}"
    role="button">
    CREATE
</a>

@else

<p class="lead">
    If the data usage exceeds <span class="font-weight-bold"> {{ $fair_usage_policy->data_limit }} GB </span>,
    the speed limit will drop to <span class="font-weight-bold"> {{ $fair_usage_policy->speed_limit }} Mbps </span>
    and customers will get IPv4 address from <span
        class="font-weight-bold">{{ long2ip($fair_usage_policy->ipv4pool->subnet).'/'. $fair_usage_policy->ipv4pool->mask }}</span>
    .
</p>

<form method="POST"
    action="{{ route('master_packages.fair_usage_policy.destroy', ['master_package' => $master_package->id, 'fair_usage_policy' => $fair_usage_policy->id]) }}">
    @csrf
    @method('DELETE')

    <ul class="nav flex-column flex-sm-row">

        <li class="nav-item">
            <a class="btn btn-primary"
                href="{{ route('master_packages.fair_usage_policy.edit', ['master_package' => $master_package, 'fair_usage_policy' => $fair_usage_policy->id]) }}"
                role="button">
                EDIT
            </a>
        </li>

        <li class="nav-item ml-4">
            <button type="submit" class="btn btn-danger">DELETE</button>
        </li>

    </ul>

</form>
@endif
