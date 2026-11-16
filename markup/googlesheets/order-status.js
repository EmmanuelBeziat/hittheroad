/**
 * Mark the WooCommerce order as completed when "FAIT" is selected in the shipping column.
 * Requires security.js and the WC_API_URL, WC_CONSUMER_KEY, WC_CONSUMER_SECRET script properties.
 */
function onEdit (event) {
	const range = event.range
	const sheet = range.getSheet()
	const row = range.getRow()
	const columnIndexOfSelector = 37 // AL, expedition

	if (sheet.getName() === 'Commandes reçues' && range.getColumn() === columnIndexOfSelector && event.value === 'FAIT') {
		updateStatusOrder(sheet, row)
	}
}

function updateStatusOrder (sheet, row) {
	const orderId = parseInt(sheet.getRange(row, 2).getValue(), 10)
	if (!orderId) {
		Logger.log('Numéro de commande invalide ligne ' + row)
		return
	}

	const credentials = `${getConfig('WC_CONSUMER_KEY')}:${getConfig('WC_CONSUMER_SECRET')}`
	const options = {
		method: 'put',
		contentType: 'application/json',
		headers: {
			'Authorization': 'Basic ' + Utilities.base64Encode(credentials)
		},
		payload: JSON.stringify({ status: 'completed' }),
		muteHttpExceptions: true
	}

	try {
		const response = UrlFetchApp.fetch(`${getConfig('WC_API_URL')}/orders/${orderId}`, options)
		Logger.log(`Commande ${orderId} : HTTP ${response.getResponseCode()}`)
	}
	catch (error) {
		Logger.log('Failed to update order: ' + error.toString())
	}
}
