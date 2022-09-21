{{-- one-page-per-group rendering --}}

<script>
    {{-- Group list --}}
    let groups_{{ $name }} = [
        @foreach($groups as $group_name => $group)
            '{{ $group_name }}',
        @endforeach
    ];

    {{-- Current group --}}
    let currentGroup_{{ $name }} = 0;

    {{-- Add next and previous group button --}}
    $('#beluga-button-{{ $name }}').append('<button id="previous-group-{{ $name }}" class="beluga-button-prev btn btn-warning">< Précédant</button>');
    $('#beluga-button-{{ $name }}').append('<button id="next-group-{{ $name }}" class="beluga-button-next btn btn-warning">Suivant ></button>');

    {{-- Next group --}}
    function nextGroup_{{ $name }}() {
        if (currentGroup_{{ $name }} < groups_{{ $name }}.length - 1) {
            currentGroup_{{ $name }}++;
            showGroup_{{ $name }}();
        }
    }

    {{-- Previous group --}}
    function previousGroup_{{ $name }}() {
        if (currentGroup_{{ $name }} > 0) {
            currentGroup_{{ $name }}--;
            showGroup_{{ $name }}();
        }
    }

    {{-- Show group --}}
    function showGroup_{{ $name }}() {
        
        let group = groups_{{ $name }}[currentGroup_{{ $name }}];

        {{-- Hide all groups --}}
        $('.beluga-form-group').hide();

        {{-- Show current group --}}
        $('#beluga-form-group-' + group).show();

        {{-- Update buttons --}}
        if (currentGroup_{{ $name }} == 0) {
            $('#previous-group-{{ $name }}').hide();
        } else {
            $('#previous-group-{{ $name }}').show();
        }

        if (currentGroup_{{ $name }} == groups_{{ $name }}.length - 1) {
            $('#beluga-button-submit-{{ $name }}').show();
            $('#next-group-{{ $name }}').hide();
        } else {
            $('#beluga-button-submit-{{ $name }}').hide();
            $('#next-group-{{ $name }}').show();
        }
    }

    {{-- Show first group --}}
    showGroup_{{ $name }}();

    {{-- Next group button --}}
    $('#next-group-{{ $name }}').click(function(e) {
        e.preventDefault();
        nextGroup_{{ $name }}();
    });

    {{-- Previous group button --}}
    $('#previous-group-{{ $name }}').click(function(e) {
        e.preventDefault();
        previousGroup_{{ $name }}();
    });
</script>