'use strict'

// import Alpine from 'alpinejs'
// import feather from 'feather-icons'
// import { Collapse, Dropdown, Tooltip } from 'bootstrap'

class MapLibre {
	constructor (options, markers) {
		if (!document.getElementById(options.container)) return
		this.token = options.token
		this.markers = markers
		this.mapInit(options)
		this.createMarkers()
	}

	mapInit (options) {
		new maplibregl.Map(options)
	}

	createMarkers () {
		console.log(this.markers)
	}
}

class HitTheRoad {
	constructor () {
		/* window.Alpine = Alpine
		Alpine.start() */
		// feather.replace()
		AOS.init()
		if (htrMapToken && htrMapToken) {
			new MapLibre({
				container: 'htr-destinations',
				token: htrMapToken,
				style: htrMapStyle,
				center: [0, 30],
				zoom: 2,
				interactive: false
			},
			htrMapDestinations)
		}
	}
}

new HitTheRoad()
