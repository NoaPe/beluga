<script>
    let circles_{{ $data->name }} = [];

    function distanceBetween (lat1, lon1, lat2, lon2) {
        var R = 6371; // km
        var dLat = (lat2-lat1) * Math.PI / 180;
        var dLon = (lon2-lon1) * Math.PI / 180;
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        var d = R * c;
        return d;
    }

    function coordLat(lat, lng) {
        return distanceBetween(lat, lng, 0, lng);
    }

    function coordLng(lat, lng) {
        return distanceBetween(lat, lng, lat, 0);
    }

    function onClick_{{ $data->name }} (coords) {
        if (marker_{{ $data->name }} !== null) {
            map_{{$data->name}}.removeLayer(marker_{{ $data->name }});
        }

        let input = document.getElementById('input-' + map_{{ $data->name }}._container.id);
        let value = input.value;

        // If lat and lng are set to 0 value is not modify
        if (coords.lat !== 0 || coords.lng !== 0) {
            
            // New circle
            circles_{{ $data->name }}.push(L.circle([coords.lat, coords.lng], {
                color: 'blue',
                fillColor: '#FFF',
                fillOpacity: 1,
                radius: 5
            }).addTo(map_{{$data->name}}));

            if (value === '') {
                value = coords.lat + ':' + coords.lng;
            } else {
                value += ';' + coords.lat + ':' + coords.lng;
            }
        }

        if (value !== '') {
            render_{{ $data->name }}(value.split(';').map(function (coord) {
                return coord.split(':');
            }));
        }

        input.value = value;
    }

    
    function boot_{{ $data->name }} () {
        // Append button on the map
        let button = document.createElement('button');
        button.innerHTML = 'Annuler dernier point';
        button.className = 'btn btn-primary leaflet-top leaflet-right m-2';
        button.style = "pointer-events: auto;";
        button.onclick = function (e) {
            e.stopPropagation();
            e.preventDefault();

            // Get value
            let input = document.getElementById('input-' + map_{{ $data->name }}._container.id);
            let value = input.value;

            // Remove last point
            value = value.split(';');
            value.pop();
            value = value.join(';');
            // Remove last circle
            if (circles_{{ $data->name }}.length > 0) {
                map_{{$data->name}}.removeLayer(circles_{{ $data->name }}.pop());
            }

            // Update input
            input.value = value;

            // Update map
            onClick_{{ $data->name }}({lat: 0, lng: 0});
        };
        map_{{$data->name}}.getContainer().appendChild(button);
    }
</script>