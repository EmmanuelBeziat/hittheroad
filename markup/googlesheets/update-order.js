function findRow (searchValue) {
	const sheet = SpreadsheetApp.getActiveSheet()
	const data = sheet.getDataRange().getValues()
	const columnCount = sheet.getDataRange().getLastColumns()

	const i = data.flat().indexOf(searchValue)
	const columnIndex = i % columnCount
	const rowIndex = ((i - columnIndex) / columnCount)

	return i >= 0 ? rowIndex + 1 : 'Search value not found'
}

//get invoked when webapp receives a POST request
function doPost (e) {
  const sheet = SpreadsheetApp.getActiveSheet()
	const data = JSON.parse([e.postData.contents])
  const row = sheet.getRow(findRow(data.number))

	if (!row) {
		return HtmlService.createHtmlOutput('Impossible de trouver la commande')
	}

	sheet.getRange(row, 4).setValue(data.status)
}
