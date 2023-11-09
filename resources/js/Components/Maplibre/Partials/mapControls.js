import maplibregl from 'maplibre-gl';

export function addControls(map) {
  map.addControl(new maplibregl.NavigationControl());
  map.addControl(new maplibregl.FullscreenControl());
  map.addControl(new maplibregl.ScaleControl());
  map.addControl(new maplibregl.GeolocateControl());
  map.addControl(new maplibregl.LogoControl());
}
