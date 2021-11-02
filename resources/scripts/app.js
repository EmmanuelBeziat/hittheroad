'use strict'

import Alpine from 'alpinejs'
import feather from 'feather-icons'
import { Collapse, Dropdown, Tooltip } from 'bootstrap'

class HitTheRoad {
	constructor () {
		window.Alpine = Alpine
		Alpine.start()
		feather.replace()
	}
}

new HitTheRoad()
