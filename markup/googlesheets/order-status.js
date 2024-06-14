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
  const orderId = sheet.getRange(row, 2).getValue()
  const url = `https://shop.co/wp-json/wc/v3/orders/${orderId}`
  const data = {
    status: 'completed'
  }
  const options = {
    method: 'put',
    contentType: 'application/json',
    headers: {
      'Authorization': 'Basic ' + Utilities.base64Encode('client_key:secret_key')
    },
    payload: JSON.stringify(data),
    muteHttpExceptions: true
  }

  try {
    const response = UrlFetchApp.fetch(url, options)
    Logger.log(response.getContentText())
  }
	catch (error) {
    Logger.log('Failed to update order: ' + error.toString())
  }
}
