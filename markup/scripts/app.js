'use strict'

document.addEventListener('DOMContentLoaded', () => {
	// AOS animations
	AOS.init()

	// Mobile menu
	const toggler = document.querySelector('.navbar-toggler')
	new mobileNav(toggler)

	// Cookies banner
	new CookiesBanner()

	// Shop Filters
/* 	if (document.querySelector('.filterbycountry')) {
		const countryFilter = new ShopFilter('filterbycountry')
		countryFilter.onChange(() => {
			const nextState = {}
			const nextTitle = ''
			const url = new URL(`${window.location.origin}${window.location.pathname}`)
			const params = new URLSearchParams(url.search)
			params.append('country', countryFilter.getValue())
			const nextUrl = `${window.location.origin}${window.location.pathname}?${params.toString()}`
			window.history.pushState(nextState, nextTitle, nextUrl)
			location.reload()
		});
	} */

	const shopFilters = document.querySelectorAll('.shop-filter')
	if (shopFilters.length) {
		// If query string is present, set the filter
		const urlParameter = new URLParameter(window.location.href)
		const parameters = urlParameter.getAllQueryParameters().entries()
		for (const param of parameters) {
			const filterElement = document.querySelector(`[name="${param[0]}"]`)
			if (filterElement) {
				filterElement.value = param[1]
			}
		}

		shopFilters.forEach(shopFilter => {
			const filter = new ShopFilter(shopFilter.id)
			filter.onChange(() => {
				window.history.pushState({}, '', filter.setURL(filter.getParameter(), filter.getValue()))
			})
		})

		const buttonFilterSubmit = document.querySelector('#filter-submit')
		if (buttonFilterSubmit) {
			buttonFilterSubmit.addEventListener('click', () => {
				location.reload()
			})
		}

		const buttonFilterReset = document.querySelector('#filter-reset')
		if (buttonFilterReset) {
			buttonFilterReset.addEventListener('click', () => {
				window.history.pushState({}, '', `${window.location.origin}${window.location.pathname}`)
				location.reload()
			})
		}
	}

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
