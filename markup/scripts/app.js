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

	// Sliders (tiny-slider.js)
	const productsSlider = document.querySelectorAll('.products-slider')
	if (productsSlider.length) {
		productsSlider.forEach(slider => {
			new Swiper(slider, {
				pagination: {
					el: slider.querySelector('.nav-dots'),
					type: 'bullets',
					clickable: true,
					bulletClass: 'nav-dots-item',
					bulletActiveClass: 'active',
					renderBullet (index, className) {
						return `<button type="button" class="${className}"><span class="screen-reader-text">${index + 1}</span></button>`
					}
				},
				navigation: {
					prevEl: slider.querySelector('.slider-prev'),
					nextEl: slider.querySelector('.slider-next'),
				},
				slidesPerView: 1,
				spaceBetween: 16,
				rewind: true,
				breakpoints: {
					768: {
						slidesPerView: 2,
						// slidesPerGroup: 2,
					},
					992: {
						slidesPerView: 3,
						// slidesPerGroup: 3
					},
					1280: {
						slidesPerView: 4,
						// slidesPerGroup: 4
					},
				}
			})
		})
	}

/* 	jQuery(document).ready(function($) {
		const button = document.getElementById('button');
		button.addEventListener('click', () => {
			$.ajax( {
				method : 'POST',
				dataType : 'json',
				url : query_products.ajaxurl,
				data : {
					foo : 'foobar',
					nonce : query_products.nonce,
					action : 'query_products'
				}
			} )
			.done(
				function(data){
					console.log('win')
					console.log(data);
				}
			)
			.fail(function(error) {
				console.log('fail')
				console.log(error.responseText);
			})
		// Button end
		})
	}) */
/* 	const button = document.getElementById('button');
	button.addEventListener('click', () => {
		const data = new FormData()
		data.append('action', 'get_products')
		data.append('nonce', query_products.nonce)
		// const params = new URLSearchParams(data)
		const params = {
			action: 'get_products',
			nonce: query_products.nonce
		}

		fetch(query_products.ajaxurl, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			credentials: 'same-origin',
			body: params
		})
		.then(response => response.json())
		.then(data => {
			console.log(data)
		})
		.catch(error => {
      console.error(error);
    })
	}) */

})
