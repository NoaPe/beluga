<form action="{{ $route }}" method="POST" class="d-inline-block">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-icon" aria-label="Button" onclick="return confirm('Are you sure?')">
        <img src="{{ asset('assets/beluga/img/trash.svg') }}" alt="Delete" />
    </button>
</form>