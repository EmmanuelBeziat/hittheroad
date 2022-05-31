class URLParameter {
	constructor (url) {
		this.url = url
	}

	checkIfParameterExists (parameter) {
		return (this.url.indexOf(`?${parameter}=`) != -1 || this.url.indexOf(`&${parameter}=`) != -1)
	}

	setParameter(parameter, value) {
		const valueExist = this.checkIfParameterExists(parameter)
		const separator = valueExist ? '&' : '?'

		const href = new URL(this.url)
		href.searchParams.set(parameter, value)
		return href.toString()
	}

	getAllQueryParameters() {
		const href = new URL(this.url)
		return href.searchParams
	}
}

class ShopFilter {
	constructor (name) {
		this.filter = document.querySelector(`#${name}`)
		if (!this.filter) return

		this.name = this.filter.name
	}

	onChange (callback) {
		this.filter.addEventListener('change', callback)
	}

	getParameter () {
		return this.name
	}

	getLabel () {
		return this.filter.options[this.filter.selectedIndex].label
	}

	getValue () {
		return this.filter.options[this.filter.selectedIndex].value
	}

	setURL (key, value) {
		const urlParameter = new URLParameter(window.location.href)
		const finalURL = urlParameter.setParameter(this.name, this.getValue())
		return finalURL
	}
}
