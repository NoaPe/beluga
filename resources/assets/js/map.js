
function initMap(name) {
    let map = L.map(name).setView([45.333429, 1.875504], 5);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    return map;
}

function bindClickEvent (map, funct) {
    map.on('click', function (e) {
        funct(e.latlng);
    });
}