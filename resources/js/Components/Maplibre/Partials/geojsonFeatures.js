import maplibregl from 'maplibre-gl';

export function filterPoints(map, ids){
    map.setFilter('natural-features-filter-match', ['in', 'id'].concat(ids));
    map.setFilter('natural-features-filter-no-match', ids.length > 0 ? ['match', ['get', 'id'], ids, false, true] : null);
}

function buildTooltip(place) {
    return `<b>${place.name}</b>`;
}

export function loadGeojsonFeatures(map, geojson, color) {
    const ids = geojson.features.map(feature => feature.properties.id);
    map.addSource('all', {
        type: 'geojson',
        data: geojson,
    });

    map.addLayer({
        id: 'natural-features-filter-match',
        type: 'circle',
        source: 'all',
        paint: {
            'circle-color': color,
            'circle-radius': 8,
            'circle-stroke-width': 3,
            'circle-stroke-color': '#fff'
        },
        filter: ['in', 'id'].concat(ids)
    });

    map.addLayer({
        id: 'natural-features-filter-no-match',
        type: 'circle',
        source: 'all',
        paint: {
            'circle-color': color,
            'circle-radius': 5,
            'circle-opacity': 0.4,
        },
        filter: ['in', 'id']
    });

    map.on('click', 'natural-features-filter-match', (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice();
        const id = e.features[0].properties.id;

        axios.get(`/api/features/id/${id}`).then(response => {
          const tooltip = buildTooltip(response.data);
          new maplibregl.Popup()
            .setLngLat(coordinates)
            .setHTML(tooltip)
            .addTo(map);
        });
      });
}
