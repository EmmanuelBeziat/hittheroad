class URLParameter {
	constructor (url) {
		this.url = url
	}

	setParameter(parameter, value) {
		const href = new URL(this.url)

		if (!value) {
			href.searchParams.delete(parameter)
		}
		else {
			href.searchParams.set(parameter, value)
		}

		return href.toString()
	}

	getAllQueryParameters() {
		const href = new URL(this.url)
		return href.searchParams
	}
}

class ShopFilters {
	constructor (rootElement, options = {}) {
		this.rootElement = document.querySelector(rootElement)
		if (!this.rootElement) return

		this.initFiltersCheckboxes(options.filters)
		this.initButtonSubmit(options.buttonSubmit)
		this.initButtonReset(options.buttonReset)
	}

	initFiltersCheckboxes (filters = 'input.shop-filter[type="checkbox"]') {
		const shopFilters = this.rootElement.querySelectorAll(filters)
		if (!shopFilters.length) return

		shopFilters.forEach(shopFilter => {
			const urlParameter = new URLParameter(window.location.href)
			const parameters = urlParameter.getAllQueryParameters().entries()

			for (const param of parameters) {
				if (param[0] === shopFilter.name) {
					const values = param[1].split(',')
					shopFilter.checked = values.includes(shopFilter.value)
				}
			}

			const filter = new ShopFilterCheckbox(shopFilter.id)
			filter.onChange(() => {
				window.history.pushState({}, '', filter.setURL(filter.getParameter(), decodeURI(filter.getValues().join(','))))
			})
		})
	}

	initButtonReset (buttonReset = '#filter-reset') {
		const buttonFilterReset = document.querySelector(buttonReset)
		if (!buttonFilterReset) return

		buttonFilterReset.addEventListener('click', event => {
			event.preventDefault()
			this.reload(`${window.location.origin}${window.location.pathname}`)
		})
	}

	initButtonSubmit (buttonSubmit = '#filter-submit') {
		const buttonFilterSubmit = document.querySelector(buttonSubmit)
		if (!buttonFilterSubmit) return

		buttonFilterSubmit.addEventListener('click', event => {
			event.preventDefault()
			this.reload()
		})
	}

	reload (value = '') {
		if (value) {
			window.history.pushState({}, '', value)
		}
		location.reload()
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

	setURL (key = this.getParameter(), value = this.getValues().join(',')) {
		const urlParameter = new URLParameter(window.location.href)
		const finalURL = urlParameter.setParameter(key, value)
		const regex = new RegExp(/\/page\/.+?\//g)
		return finalURL.replace(regex, '/')
	}
}

class ShopFilterCheckbox extends ShopFilter {
	constructor (name) {
		super(name)
		if (!this.filter) return

		this.filter.addEventListener('change', () => {
			window.history.pushState({}, '', this.setURL())
		})
	}

	getValues () {
		const group = document.querySelectorAll(`[name=${this.name}]`)
		if (!group.length) return

		return Array.from(group).filter(x => x.checked).map(x => x.value)
	}
}
