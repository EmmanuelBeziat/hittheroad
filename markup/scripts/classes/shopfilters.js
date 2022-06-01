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

class ShopFilters {
	constructor (rootElement, options = {}) {
		this.rootElement = document.querySelector(rootElement)
		if (!this.rootElement) return

		this.initUrlParameters()
		this.initFilters(options.filters)
		this.initButtonSubmit(options.buttonSubmit)
		this.initButtonReset(options.buttonReset)
	}

	initUrlParameters () {
		const urlParameter = new URLParameter(window.location.href)
		const parameters = urlParameter.getAllQueryParameters().entries()

		for (const param of parameters) {
			const key = param[0]
			const value = param[1]
			/* const filterElement = this.rootElement.querySelector(`[name="${param[0]}"]`)
			if (filterElement) {
				filterElement.value = `${param[1]}`
				console.log(filterElement.value)
			} */
		}
	}

	initFilters (filters = '.shop-filter') {
		const shopFilters = this.rootElement.querySelectorAll(filters)
		if (!shopFilters.length) return

		shopFilters.forEach(shopFilter => {
			const items = []
			const urlParameter = new URLParameter(window.location.href)
			const parameters = urlParameter.getAllQueryParameters().entries()

			for (const param of parameters) {
				if (param[0] === shopFilter.name) {
					items.push(param[1].split(','))
				}
			}

			const filter = new ShopFilter(shopFilter.id)
			filter.onChange(() => {
				window.history.pushState({}, '', filter.setURL(filter.getParameter(), decodeURI(filter.getValues().join(','))))
			})

			if (items.length) {
				filter.setValues(items[0])
			}
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
		this.tomSelect = new TomSelect(`#${this.filter.id}`, {
			maxItems: 5
		});
	}

	onChange (callback) {
		this.tomSelect.on('change', callback)
	}

	getParameter () {
		return this.name
	}

	getLabel () {
		return this.filter.options[this.filter.selectedIndex].label
	}

	getValues () {
		// return [...this.filter.options].filter(x => x.selected).map(x => x.value)
		return this.tomSelect.getValue()
	}

	setValues (values = []) {
		this.tomSelect.setValue(values)
	}

	setURL (key = this.getParameter(), value = this.getValues().join(',')) {
		const urlParameter = new URLParameter(window.location.href)
		const finalURL = urlParameter.setParameter(key, value)
		return finalURL
	}
}
