<dl class="row">
    <dt class="col-sm-4">Master Package: </dt>
    <dd class="col-sm-8">{{ $master_package->name }}</dd>

    @if ($master_package->connection_type == 'PPPoE')
    <dt class="col-sm-4">IPv4 : </dt>
    <dd class="col-sm-8">
        {{ long2ip($master_package->pppoe_profile->ipv4pool->subnet).'/'. $master_package->pppoe_profile->ipv4pool->mask
        }}
    </dd>

    <dt class="col-sm-4">IPv6 : </dt>
    <dd class="col-sm-8">{{ $master_package->pppoe_profile->ipv6pool->prefix }}</dd>
    @endif

    <dt class="col-sm-4">Rate Limit : </dt>
    <dd class="col-sm-8">{{ $master_package->rate_limit }} {{ $master_package->readable_rate_unit }}</dd>

    <dt class="col-sm-4">Volume Limit : </dt>
    <dd class="col-sm-8">{{ $master_package->volume_limit }} {{ $master_package->volume_unit }}</dd>

    <dt class="col-sm-4">Validity : </dt>
    <dd class="col-sm-8">{{ $master_package->validity }}</dd>
</dl>
