
<ul class="nav flex-column flex-sm-row mb-2">

    <!--Upload PPPoE Profiles-->
    <li class="nav-item">
        <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('routers.pppoe_profiles.create' , ['router' => $router->id]) }}">
            <i class="fas fa-upload"></i>
            Upload PPPoE Profiles
        </a>
    </li>
    <!--/Upload PPPoE Profiles-->

</ul>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" style="width: 2%">#</th>
                <th scope="col">Profile Name</th>
                <th scope="col">IPv4 Pool</th>
                <th scope="col">IPv6 Pool</th>
                <th scope="col">IPv4 Allocation</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($profiles as $profile )
            <tr>
                <th scope="row">{{ $profile->id }}</th>
                <td>{{ $profile->name }}</td>
                <td>{{ long2ip($profile->ipv4pool->subnet) .'/' . $profile->ipv4pool->mask }}</td>
                <td>{{ $profile->ipv6pool->prefix }}</td>
                <td>{{ $profile->ip_allocation_mode }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
