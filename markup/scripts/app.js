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

	// Sliders (Glide.js)
	const productsSlider = document.querySelectorAll('.products-slider')
	if (productsSlider.length) {
		productsSlider.forEach(slider => {
			tns({
				container: slider,
				items: 1,
				gutter: 16,
				controlsPosition: 'bottom',
				controlsText: [
					'<i class="fas fa-chevron-left"></i><span class="screen-reader-text">Produits précédents</span>',
					'<i class="fas fa-chevron-right"></i><span class="screen-reader-text">Produits suivants</span>'
				],
				navPosition: 'bottom',
				responsive: {
					1280: {
						items: 4
					},
      		992: {
						items: 3
					},
					768: {
						items: 2
					}
				}
			})
		})
	}
})
