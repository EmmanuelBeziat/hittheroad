//get invoked when web app receives a GET request
function doGet(e) {
  return HtmlService.createHtmlOutput('Requête Reçue')
}

function productInformations (item) {
	return {
		price: item.price,
		name: item.parent_name,
		quantity: item.quantity,
		size: `${item.meta_data[0].display_value} (${item.dimensions})`,
		finish: item.meta_data[1].value.Fields[0].SelectedValues[0].Value,
		number: item.number
	}
}

function makeProductRow (product) {
	return [
		'', '', '', '',
		product.name,
		product.quantity,
		product.size,
		product.finish,
		product.number,
		'', '', '', '', '', '', '', '', '', '',
		product.price,
		''
	]
}

//get invoked when webapp receives a POST request
function doPost(e) {
	const sheet = SpreadsheetApp.getActiveSheet()
	const data = JSON.parse([e.postData.contents])
	const order = {
		number: data.number,
		date: data.date_created,
		status: data.status
	}
	const billing = {
		firstname: data.billing.first_name,
		lastname: data.billing.last_name,
		phone: data.billing.phone,
		email: data.billing.email
	}
	const shipping = {
		address1: data.shipping.address_1,
		address2: data.shipping.address_2,
		postcode: data.shipping.postcode,
		city: data.shipping.city,
		country: new Intl.DisplayNames(['EN'], { type: 'region' }).of(data.shipping.country),
		cost: data.shipping_total
	}
	const total = data.total

	data.line_items.forEach((item, index) => {
		if (index + 1 === 1) {
			const product = productInformations(item)
			sheet.appendRow([
				'',
				order.number,
				order.date,
				order.status,
				product.name,
				product.quantity,
				product.size,
				product.finish,
				product.number,
				billing.lastname,
				billing.firstname,
				billing.email,
				`'${billing.phone}`,
				shipping.address1,
				shipping.address2,
				shipping.postcode,
				shipping.city,
				shipping.country,
				shipping.cost,
				product.price,
				total
			])
			sheet.getRange(sheet.getLastRow(), 1).insertCheckboxes()
		}
		else {
			const product = productInformations(item)
			sheet.appendRow(makeProductRow(product))
			sheet.getRange(sheet.getLastRow(), 1).insertCheckboxes()
		}
	})

	// Separator
	sheet.appendRow(['  '])
	return HtmlService.createHtmlOutput('Commande ajoutée avec succès')
}
