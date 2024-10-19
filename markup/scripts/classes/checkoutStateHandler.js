class CheckoutStateHandler {
	/**
	 * Initializes the CheckoutStateHandler instance.
	 * Sets up the country select and state field elements.
	 */
	constructor () {
		this.countrySelect = jQuery('#calc_shipping_country')
		this.stateField = document.getElementById('calc_shipping_state_field')
		this.stateInput = document.getElementById('calc_shipping_state')

		this.countriesWithState = new Set(['CH', 'SE', 'US', 'CA'])

		this.init()
	}

	/**
	 * Initializes event listeners and checks for element existence.
	 */
	init () {
		if (this.countrySelect && this.stateField && this.stateInput) {
			this.toggleStateField()
			this.countrySelect.on('select2:select', () => this.toggleStateField())
		}
	}

	/**
	 * Toggles the visibility of the state field based on the selected country.
	 */
	toggleStateField () {
		const isVisible = this.countriesWithState.has(this.countrySelect.val())
		this.stateInput.value = isVisible ? this.stateInput.value : ''
		const item = document.querySelector('#calc_shipping_state')

		if (isVisible) {
			this.stateField.style.display = 'block'
			item.classList.add('select2-hidden-accessible')
			item.setAttribute('aria-hidden', 'true')
		}
		else {
			this.stateField.style.display = 'none'
			item.classList.remove('select2-hidden-accessible')
			item.removeAttribute('aria-hidden')
		}
	}
}
