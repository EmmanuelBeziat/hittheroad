class mobileNav {
	constructor (toggler) {
		if (!toggler) return

		const menu = document.getElementById(toggler.getAttribute('aria-controls'))
		if (!menu) return

		this.elements = {
			body: document.querySelector('body'),
			toggler,
			menu
		}

		this.init()
	}

	init () {
		this.elements.toggler.addEventListener('click', event => {
			event.preventDefault()
			this.elements.body.classList.toggle('menu-mobile-open')
			this.elements.toggler.classList.toggle('is-open')
		})
	}
}
