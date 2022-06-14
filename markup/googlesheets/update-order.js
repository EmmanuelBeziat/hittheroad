const { Logger } = require("sass");

//get invoked when web app receives a GET request
function doGet (e) {
  return HtmlService.createHtmlOutput("request received");
}

function findRow (searchValue) {
	const sheet = SpreadsheetApp.getActiveSheet()
	const data = sheet.getDataRange().getValues()
	const columnCount = sheet.getDataRange().getLastColumns()

	const i = data.flat().indexOf(searchValue)
	const columnIndex = i % columnCount
	const rowIndex = ((i - columnIndex) / columnCount)

	Logger.log({ columnIndex, rowIndex })

	return i >= 0 ? rowIndex + 1 : 'Search value not found'
}

//get invoked when webapp receives a POST request
function doPost (e) {
  const sheet = SpreadsheetApp.getActiveSheet()
	const data = JSON.parse([e.postData.contents])
  const row = sheet.getRow(findRow(data.number))
}
