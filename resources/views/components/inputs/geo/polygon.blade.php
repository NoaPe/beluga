@include('beluga::components.inputs.geo.multipoint', ['data' => $data])
<script>
    function render_{{ $data-> name }} (coords) {
        marker_{{ $data->name }} = L.polygon(coords).addTo(map_{{$data->name}});
    }
</script>
@include('beluga::components.inputs.map', ['data' => $data])