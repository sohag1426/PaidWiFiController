<ul class="nav justify-content-end">
    <li class="nav-item mr-4 font-italic font-weight-bold">
        Helpline : {{ $operator->helpline ?? "" }}
    </li>
    <li class="nav-item">
        <form class="form-inline" method="get" action="{{ route('customer.web.logout') }}">
            <button type="submit" class="btn btn-dark mb-2"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </li>
</ul>
