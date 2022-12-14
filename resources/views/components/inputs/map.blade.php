<div class="map-container">
    <div id="map-{{ $data->name }}" style="width: 100%; height: 400px;"></div>
</div>
<div class="input-map">
    <input id="input-map-{{ $data->name }}"
        type="hidden" 
        name="{{ $data->name }}"
        value="{{ old($name) ?? $shell->getAttribute($name) ?? $data->default ?? '' }}" >
</div>

<style>
    .map-{{ $data->name }} {
        cursor: pointer;
    }
</style>

<script>
    let marker_{{ $data->name }} = null;

    let map_{{$data->name}} = initMap('map-{{ $data->name }}');

    bindClickEvent(map_{{$data->name}}, onClick_{{ $data->name }});

    boot_{{ $data->name }}();
</script>
