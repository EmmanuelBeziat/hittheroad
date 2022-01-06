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
		this.map = new maplibregl.Map(options)
	}

	createMarkers () {
		this.markers.forEach(marker => {
			new maplibregl.Marker()
				.setLngLat([marker.lng, marker.lat])
				.addTo(this.map)
		})
	}
}

class cookies {
	constructor () {
		this.banner = document.querySelector('.cookies')
		if (!this.banner) return

		this.accept = document.querySelector('.cookies .cookies-accept')

		if (!this.getCookie('cookies')) {
			this.showBanner()
			this.closeButtonEvent()
		}
	}

	showBanner () {
		this.banner.classList.add('show')
	}

	hideBanner () {
		this.banner.classList.remove('show')
	}

	getCookie (name) {
		return localStorage.getItem(name)
	}

	setCookie (name, value) {
		localStorage.setItem(name, value)
	}

	closeButtonEvent () {
		if (!this.accept) return

		this.accept.addEventListener('click', event => {
			event.preventDefault()
			this.hideBanner()
			this.setCookie('cookies', 'accepted')
		})
	}
}

class HitTheRoad {
	constructor () {
		/* window.Alpine = Alpine
		Alpine.start() */
		// feather.replace()
		AOS.init()
		if (typeof htrMapToken !== 'undefined' && typeof htrMapStyle !== 'undefined') {
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

		new cookies()
	}
}

new HitTheRoad()
