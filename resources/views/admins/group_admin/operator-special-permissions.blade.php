<ul class="nav nav-pills mb-2">
    <li class="nav-item">
        <a class="nav-link active"
            href="{{ route('operators.special-permission.create', ['operator' => $operator->id]) }}">Edit</a>
    </li>
</ul>

<div class="card" style="width: 18rem;">
    @if ($permissions->count())
    <div class="card-header text-danger">
        This operator Can:
    </div>
    @else
    <div class="card-header">
        No Special Permission given
    </div>
    @endif
    <ul class="list-group list-group-flush">
        @foreach ($permissions as $permission)
        <li class="list-group-item">{{ $permission }}</li>
        @endforeach
    </ul>
</div>
