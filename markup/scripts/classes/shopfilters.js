class ShopFilter {
	constructor (name) {
		this.filter = document.querySelector(`[name='${name}']`)
		if (!this.filter) return

		this.name = name
	}

	onChange (callback) {
		this.filter.addEventListener('change', callback)
	}

	getLabel () {
		return this.filter.options[this.filter.selectedIndex].label
	}

	getValue () {
		return this.filter.options[this.filter.selectedIndex].value
	}
}
