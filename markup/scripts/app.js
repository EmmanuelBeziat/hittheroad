'use strict'

document.addEventListener('DOMContentLoaded', () => {
	// AOS animations
	AOS.init()

	// Cookies banner
	new CookiesBanner()

	// Shop Filters
	const countryFilter = new ShopFilter('filterbycountry')
	countryFilter.onChange(() => {
		window.location.href = `${window.location.origin}${window.location.pathname}?place=${countryFilter.getValue()}`
	});

	// MapLibre (HomePage)
	if (typeof htrMapToken !== 'undefined' && typeof htrMapStyle !== 'undefined') {
		new MapLibre({
			container: 'htr-destinations',
			token: htrMapToken,
			style: htrMapStyle,
			center: [0, 20],
			zoom: 2,
			interactive: false,
			attributionControl: false
		},
		htrMapDestinations)
	}
})
