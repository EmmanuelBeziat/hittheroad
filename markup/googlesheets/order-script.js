//get invoked when web app receives a GET request
function doGet(e) {
  return HtmlService.createHtmlOutput("request received");
}

function productInformations (item) {
	const line_price = item.price;
	const product_name = item.parent_name;
	const quantity = item.quantity;
	const product_size = item.meta_data[0].display_value;
	// const total = item.total;
	const product_finish = item.meta_data[1].value.Fields[0].SelectedValues[0].Value;
	return { line_price, product_name, quantity, product_size, product_finish };
}

function makeProductRow (product) {
	return ['','','','',product.product_name,product.quantity,product.product_size,product.product_finish,'','','','','',product.line_price,''];
}

//get invoked when webapp receives a POST request
function doPost(e) {
  const sheet = SpreadsheetApp.getActiveSheet();
  const data = JSON.parse([e.postData.contents]);
  const execution_date = new Date();

  const order_number = data.number;
  const order_created = data.date_created;
  const order_status = data.status;

  const billing_name = data.billing.first_name + ' ' + data.billing.last_name;
  const billing_phone = data.billing.phone;
  const billing_email = data.billing.email;
  const shipping_address = data.shipping.address_1+' '+data.shipping.address_2+' '+data.shipping.postcode+' '+data.shipping.city+', '+data.shipping.country;
  const order_total = data.total;
  const shipping_cost = data.shipping_total;

	if (data.line_items.length === 1) {
		const product = productInformations(data.line_items[0]);
		sheet.appendRow([execution_date,order_number,order_created,order_status,product.product_name,product.quantity,product.product_size,product.product_finish,billing_name,billing_email,billing_phone,shipping_address,shipping_cost,product.line_price,order_total]);
	}
	else {
		sheet.appendRow([execution_date,order_number,order_created,order_status,'⬇️','⬇️','⬇️','⬇️',billing_name,billing_email,billing_phone,shipping_address,shipping_cost,'⬇️',order_total]);
		data.line_items.forEach(function(item) {
			const product = productInformations(item);
			sheet.appendRow(makeProductRow(product));
		})
	}


  // Separator
  sheet.appendRow(['------', '------', '------', '------', '------', '------', '------', '------', '------', '------', '------', '------', '------','-----']);
}
