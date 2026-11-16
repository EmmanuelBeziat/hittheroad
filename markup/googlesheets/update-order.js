/**
 * Webhook receiver: update the status column of an order already in the sheet.
 * Requires security.js and the WEBHOOK_TOKEN script property.
 * Note: defines doPost, like order-script.js — must live in a separate Apps Script project.
 */

/**
 * Find the sheet row (1-based) containing the given value.
 * @param {*} searchValue
 * @returns {number|null}
 */
function findRow (searchValue) {
	const data = SpreadsheetApp.getActiveSheet().getDataRange().getValues()
	const index = data.findIndex(row => row.includes(searchValue))
	return index >= 0 ? index + 1 : null
}

// Invoked when the web app receives a POST request
function doPost (e) {
	if (!isAuthorizedRequest(e)) {
		return unauthorizedResponse()
	}

	const data = JSON.parse(e.postData.contents)
	const row = findRow(data.number)

	if (!row) {
		return HtmlService.createHtmlOutput('Impossible de trouver la commande')
	}

	SpreadsheetApp.getActiveSheet().getRange(row, 4).setValue(toCellText(String(data.status)))
	return HtmlService.createHtmlOutput('Statut mis à jour')
}
