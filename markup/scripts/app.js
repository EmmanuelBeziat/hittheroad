'use strict'

document.addEventListener('DOMContentLoaded', () => {
	// AOS animations
	AOS.init()

	// Cookies banner
	new CookiesBanner()

	// Shop Filters
	if (document.querySelector('.filterbycountry')) {
		const countryFilter = new ShopFilter('filterbycountry')
		countryFilter.onChange(() => {
			const nextState = {}
			const nextTitle = ''
			const nextUrl = `${window.location.origin}${window.location.pathname}?place=${countryFilter.getValue()}`
			window.history.pushState(nextState, nextTitle, nextUrl)
			location.reload()

			/* const file = '/wp-admin/admin-ajax.php'
			const payload = {
				action: 'filter_projects',
				category: $(this).data('slug'),
			}
			const request = new Request(file, {
				method: 'POST',
				headers: {
					'Content-Type': 'plain/html'
				},
				body: JSON.stringify(payload)
			})
			fetch(request)
				.then(response => {
					console.log(response)
				})
				.catch(err => console.error(err)) */
		});
	}

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
