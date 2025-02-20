/**
 * @property {Object} options
 * @property {Array} markers
 */
class MapLibre {
	/**
	 * https://maplibre.org/maplibre-gl-js-docs/
	 * @param {Object} options https://maplibre.org/maplibre-gl-js-docs/api/properties/
	 * @param {Array} markers List of markers
	 */
	constructor (options, markers) {
		if (!document.getElementById(options.container)) return
		this.token = options.token
		this.markers = markers
		this.mapInit(options)
		this.createMarkers()
	}

	mapInit (options) {
		this.map = new maplibregl.Map(options)
		this.map.scrollZoom.disable()
	}

	createMarkers (markers = this.markers) {
		markers.forEach(marker => {
			const el = Object.assign(document.createElement('a'), {
				className: 'marker htr-marker',
				href: `/shop/?place=${marker.slug}`,
			})

			new maplibregl.Marker(el)
				.setLngLat([marker.lng, marker.lat])
				.addTo(this.map)
		})
	}
}
