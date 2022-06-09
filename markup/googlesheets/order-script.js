//get invoked when web app receives a GET request
function doGet(e) {
  return HtmlService.createHtmlOutput("request received");
}

//get invoked when webapp receives a POST request
function doPost(e) {
  var sheet = SpreadsheetApp.getActiveSheet();
  var data = JSON.parse([e.postData.contents]);
  var execution_date = new Date();

  var order_number = data.number;
  var order_created = data.date_created;
  var order_status = data.status;

  var billing_name = data.billing.first_name + ' ' + data.billing.last_name;
  var billing_phone = data.billing.phone;
  var billing_email = data.billing.email;
  var shipping_address = data.shipping.address_1+' '+data.shipping.address_2+' '+data.shipping.postcode+' '+data.shipping.city+', '+data.shipping.country;
  var order_total = data.total;
  var shipping_cost = data.shipping_total;

  data.line_items.forEach(function(item) {
    var line_price = item.price;
    var product_name = item.parent_name;
    var quantity = item.quantity;
    var product_size = item.meta_data[0].display_value;
    var total = item.total;
    var product_finish = item.meta_data[1].value.Fields[0].SelectedValues[0].Value;

    sheet.appendRow([execution_date,order_number,order_created,order_status,product_name,quantity,product_size,product_finish,billing_name,billing_email,billing_phone,shipping_address,shipping_cost,line_price,total]);
  })

  // Separator
  sheet.appendRow(['------', '------', '------', '------', '------', '------', '------', '------', '------', '------', '------', '------', '------','-----']);
}
