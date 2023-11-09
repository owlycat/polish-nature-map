import maplibregl from 'maplibre-gl';

export function loadGeojsonFeatures(map, geojson, sourceName, color) {
    map.addSource(sourceName, {
        type: 'geojson',
        data: geojson,
        cluster: true,
        clusterMaxZoom: 14,
        clusterRadius: 50
    });

    map.addLayer({
        id: `clusters-${sourceName}`,
        type: 'circle',
        source: sourceName,
        filter: ['has', 'point_count'],
        paint: {
            'circle-color': '#fff',
            'circle-stroke-width': 8,
            'circle-stroke-color': color,
            'circle-radius': [
                'step',
                ['get', 'point_count'],
                20,
                100,
                30,
                750,
                40
            ]
        }
    });

    map.addLayer({
        id: `cluster-count-${sourceName}`,
        type: 'symbol',
        source: sourceName,
        filter: ['has', 'point_count'],
        layout: {
            'text-field': '{point_count_abbreviated}',
            'text-size': 15
        }
    });

    map.addLayer({
        id: `unclustered-point-${sourceName}`,
        type: 'circle',
        source: sourceName,
        filter: ['!', ['has', 'point_count']],
        paint: {
            'circle-color': color,
            'circle-radius': 8,
            'circle-stroke-width': 3,
            'circle-stroke-color': '#fff'
        },
    });


    map.on('click', `clusters-${sourceName}`, (e) => {
        const features = map.queryRenderedFeatures(e.point, {
            layers: [`clusters-${sourceName}`]
        });
        const clusterId = features[0].properties.cluster_id;
        map.getSource(sourceName).getClusterExpansionZoom(
            clusterId,
            (err, zoom) => {
                if (err) return;

                map.easeTo({
                    center: features[0].geometry.coordinates,
                    zoom
                });
            }
        );
    });

    map.on('click', `unclustered-point-${sourceName}`, (e) => {
        const coordinates = e.features[0].geometry.coordinates.slice();
        const name = e.features[0].properties.name;



        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
        }

        new maplibregl.Popup()
            .setLngLat(coordinates)
            .setHTML(
                `${name}`
            )
            .addTo(map);
    });
}
