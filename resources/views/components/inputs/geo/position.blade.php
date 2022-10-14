<script>
    function onClick_{{ $data->name }} (coords) {

        if (marker_{{ $data->name }} !== null) {
            map_{{$data->name}}.removeLayer(marker_{{ $data->name }});
        }

        marker_{{ $data->name }} = L.marker([coords.lat, coords.lng]).addTo(map_{{$data->name}});

        let input = document.getElementById('input-' + map_{{ $data->name }}._container.id);
        let value = coords.lat + ':' + coords.lng;

        input.value = value;
    }

    
    function boot_{{ $data->name }} () {
        
    }
</script>

@include('beluga::components.inputs.map', ['data' => $data])