class CookiesBanner {
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
