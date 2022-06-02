'use strict'

document.addEventListener('DOMContentLoaded', () => {
	// AOS animations
	AOS.init({ once: true })

	// Mobile menu
	const toggler = document.querySelector('.navbar-toggler')
	new mobileNav(toggler)

	// Cookies banner
	new CookiesBanner()

	// Shop Filters
	new ShopFilters('.filters')

	// MapLibre (HomePage)
	if (typeof htrMapToken !== 'undefined' && typeof htrMapStyle !== 'undefined') {
		new MapLibre({
			container: 'htr-destinations',
			token: htrMapToken,
			style: htrMapStyle,
			center: [0, 20],
			zoom: 2,
			interactive: true,
			attributionControl: false
		},
		htrMapDestinations)
	}
})
