//get invoked when web app receives a GET request
function doGet(e) {
  return HtmlService.createHtmlOutput('Requête Reçue')
}

function productInformations (item) {
	return {
		price: item.price,
		name: item.parent_name,
		quantity: item.quantity,
		size: `${item.meta_data[0].display_value}`,
		width: item.width,
		height: item.height,
		finish: item.meta_data[1].value.Fields[0].SelectedValues[0].Value,
		number: item.number,
		vimeoCode: item.vimeo_code
	}
}

const makeProductRow = (product, orderNumber) => [
	'',
	orderNumber,
	'',
	product.name,
	'', '',
	product.quantity,
	product.size,
	product.width,
	product.height,
	product.finish,
	product.number,
	'', '', '', '', '', '', '', '', '', '', '', '', '',
	product.price,
	product.vimeoCode,
	' '
]

const countries = [
	{ iso: 'af', tel: '93', name: 'Afghanistan' },
	{ iso: 'za', tel: '27', name: 'Afrique du sud' },
	{ iso: 'al', tel: '355', name: 'Albanie' },
	{ iso: 'dz', tel: '213', name: 'Algérie' },
	{ iso: 'de', tel: '49', name: 'Allemagne' },
	{ iso: 'ad', tel: '376', name: 'Andorre' },
	{ iso: 'gb', tel: '44', name: 'Angleterre' },
	{ iso: 'ao', tel: '244', name: 'Angola ' },
	{ iso: 'ai', tel: '1264', name: 'Anguilla' },
	{ iso: 'ag', tel: '1268', name: 'Antigua et Barbuda ' },
	{ iso: 'an', tel: '599', name: 'Antilles néerlandaises' },
	{ iso: 'sa', tel: '966', name: 'Arabie saoudite' },
	{ iso: 'ar', tel: '54', name: 'Argentine' },
	{ iso: 'am', tel: '374', name: 'Arménie' },
	{ iso: 'aw', tel: '297', name: 'Aruba' },
	{ iso: 'au', tel: '61', name: 'Australie' },
	{ iso: 'at', tel: '43', name: 'Autriche' },
	{ iso: 'az', tel: '994', name: 'Azerbaïdjan' },
	{ iso: 'bs', tel: '1242', name: 'Bahamas' },
	{ iso: 'bh', tel: '973', name: 'Bahreïn' },
	{ iso: 'bd', tel: '880', name: 'Bangladesh' },
	{ iso: 'bb', tel: '1246', name: 'Barbade ' },
	{ iso: 'be', tel: '32', name: 'Belgique' },
	{ iso: 'bz', tel: '501', name: 'Bélize' },
	{ iso: 'bj', tel: '229', name: 'Bénin' },
	{ iso: 'bm', tel: '1441', name: 'Bermudes' },
	{ iso: 'bt', tel: '975', name: 'Bhoutan' },
	{ iso: 'by', tel: '375', name: 'Biélorussie' },
	{ iso: 'mm', tel: '95', name: 'Myanmar (ex. Birmanie)' },
	{ iso: 'bo', tel: '591', name: 'Bolivie' },
	{ iso: 'ba', tel: '387', name: 'Bosnie-Herzégovine' },
	{ iso: 'bw', tel: '267', name: 'Botswana' },
	{ iso: 'br', tel: '55', name: 'Brésil' },
	{ iso: 'bn', tel: '673', name: 'Brunei Darussalam' },
	{ iso: 'bg', tel: '359', name: 'Bulgarie' },
	{ iso: 'bf', tel: '226', name: 'Burkina Faso' },
	{ iso: 'bi', tel: '257', name: 'Burundi' },
	{ iso: 'kh', tel: '855', name: 'Cambodge' },
	{ iso: 'cm', tel: '237', name: 'Cameroun' },
	{ iso: 'ca', tel: '1', name: 'Canada' },
	{ iso: 'cv', tel: '238', name: 'Cap-Vert' },
	{ iso: 'cl', tel: '56', name: 'Chili' },
	{ iso: 'cn', tel: '86', name: 'Chine' },
	{ iso: 'cy', tel: '357', name: 'Chypre' },
	{ iso: 'co', tel: '57', name: 'Colombie' },
	{ iso: 'km', tel: '269', name: 'Comores' },
	{ iso: 'cg', tel: '242', name: 'Congo' },
	{ iso: 'cd', tel: '243', name: 'Congo ' },
	{ iso: 'kr', tel: '82', name: 'Corée du Sud' },
	{ iso: 'kp', tel: '850', name: 'Corée du Nord' },
	{ iso: 'cr', tel: '506', name: 'Costa Rica' },
	{ iso: 'ci', tel: '225', name: 'Cote d’ivoire' },
	{ iso: 'hr', tel: '385', name: 'Croatie' },
	{ iso: 'cu', tel: '53', name: 'Cuba' },
	{ iso: 'dk', tel: '45', name: 'Danemark' },
	{ iso: 'io', tel: '246', name: 'Archipel CHAGOS' },
	{ iso: 'dj', tel: '253', name: 'Djibouti' },
	{ iso: 'dm', tel: '1767', name: 'Dominique' },
	{ iso: 'gb', tel: '44', name: 'Ecosse' },
	{ iso: 'eg', tel: '20', name: 'Egypte' },
	{ iso: 'sv', tel: '503', name: 'Salvador' },
	{ iso: 'ae', tel: '971', name: 'Emirats arabes unis' },
	{ iso: 'ec', tel: '593', name: 'Equateur ' },
	{ iso: 'er', tel: '291', name: 'Erythrée' },
	{ iso: 'es', tel: '34', name: 'Espagne ' },
	{ iso: 'ee', tel: '372', name: 'Estonie' },
	{ iso: 'us', tel: '1', name: 'Etats-Unis d’Amérique' },
	{ iso: 'et', tel: '251', name: 'Ethiopie' },
	{ iso: 'fk', tel: '500', name: 'Iles Falkland' },
	{ iso: 'fi', tel: '358', name: 'Finlande' },
	{ iso: 'fr', tel: '33', name: 'France' },
	{ iso: 'ga', tel: '241', name: 'Gabon' },
	{ iso: 'gm', tel: '220', name: 'Gambie' },
	{ iso: 'ge', tel: '995', name: 'Géorgie' },
	{ iso: 'gh', tel: '233', name: 'Ghana' },
	{ iso: 'gi', tel: '350', name: 'Gibraltar' },
	{ iso: 'gr', tel: '30', name: 'Grèce' },
	{ iso: 'gd', tel: '1473', name: 'Grenade ' },
	{ iso: 'gl', tel: '299', name: 'Groenland' },
	{ iso: 'fr', tel: '590', name: 'Guadeloupe' },
	{ iso: 'gt', tel: '502', name: 'Guatemala' },
	{ iso: 'gn', tel: '224', name: 'Guinée' },
	{ iso: 'gw', tel: '245', name: 'Guinée-Bissau' },
	{ iso: 'gq', tel: '240', name: 'Guinée équatoriale' },
	{ iso: 'gy', tel: '592', name: 'Guyana' },
	{ iso: 'fr', tel: '594', name: 'Guyane' },
	{ iso: 'ht', tel: '509', name: 'Haïti' },
	{ iso: 'hn', tel: '504', name: 'Honduras' },
	{ iso: 'hk', tel: '852', name: 'Hong-Kong' },
	{ iso: 'hu', tel: '36', name: 'Hongrie' },
	{ iso: 'sh', tel: '247', name: 'Ile Ascencion' },
	{ iso: 'sb', tel: '677', name: 'Ile Salomon' },
	{ iso: 'mu', tel: '230', name: 'Ile Maurice' },
	{ iso: 'cx', tel: '61', name: 'Ile Christmas' },
	{ iso: 'fo', tel: '298', name: 'Iles Féroé' },
	{ iso: 'ky', tel: '1345', name: 'Iles Caïmans' },
	{ iso: 'ck', tel: '682', name: 'Iles Cook' },
	{ iso: 'fj', tel: '679', name: 'Iles Fidji' },
	{ iso: 'mp', tel: '1670', name: 'Iles Mariannes du nord' },
	{ iso: 'mh', tel: '692', name: 'Ile Marshall ' },
	{ iso: 'vg', tel: '1284', name: 'Iles Vierges britanniques' },
	{ iso: 'vi', tel: '1340', name: 'Iles Vierges des Etats-Unis ' },
	{ iso: 'in', tel: '91', name: 'Inde' },
	{ iso: 'id', tel: '62', name: 'Indonésie' },
	{ iso: 'iq', tel: '964', name: 'Iraq' },
	{ iso: 'ir', tel: '98', name: 'Iran ' },
	{ iso: 'ie', tel: '353', name: 'Irlande' },
	{ iso: 'gb', tel: '45', name: 'Irlande du Nord' },
	{ iso: 'is', tel: '354', name: 'Islande' },
	{ iso: 'il', tel: '972', name: 'Israël' },
	{ iso: 'it', tel: '39', name: 'Italie' },
	{ iso: 'jm', tel: '1876', name: 'Jamaïque' },
	{ iso: 'jp', tel: '81', name: 'Japon' },
	{ iso: 'jo', tel: '962', name: 'Jordanie' },
	{ iso: 'kz', tel: '7', name: 'Kazakhstan' },
	{ iso: 'ke', tel: '254', name: 'Kenya' },
	{ iso: 'kg', tel: '996', name: 'Kirghizistan' },
	{ iso: 'ki', tel: '686', name: 'Kiribati' },
	{ iso: 'xk', tel: '381', name: 'Kosovo' },
	{ iso: 'kw', tel: '965', name: 'Koweït' },
	{ iso: 'la', tel: '856', name: 'Laos ' },
	{ iso: 'ls', tel: '266', name: 'Lesotho' },
	{ iso: 'lv', tel: '371', name: 'Lettonie' },
	{ iso: 'lb', tel: '961', name: 'Liban' },
	{ iso: 'lr', tel: '231', name: 'Liberia' },
	{ iso: 'ly', tel: '218', name: 'Libye' },
	{ iso: 'li', tel: '423', name: 'Liechtenstein' },
	{ iso: 'lt', tel: '370', name: 'Lituanie' },
	{ iso: 'lu', tel: '352', name: 'Luxembourg' },
	{ iso: 'mo', tel: '853', name: 'Maçao' },
	{ iso: 'mk', tel: '389', name: 'Macédoine ' },
	{ iso: 'mg', tel: '261', name: 'Madagascar ' },
	{ iso: 'my', tel: '60', name: 'Malaisie ' },
	{ iso: 'mw', tel: '265', name: 'Malawi' },
	{ iso: 'mv', tel: '960', name: 'Maldives' },
	{ iso: 'ml', tel: '223', name: 'Mali' },
	{ iso: 'mt', tel: '356', name: 'Malte' },
	{ iso: 'ma', tel: '212', name: 'Maroc' },
	{ iso: 'fr', tel: '596', name: 'Martinique' },
	{ iso: 'mr', tel: '222', name: 'Mauritanie' },
	{ iso: 'fr', tel: '262', name: 'Mayotte' },
	{ iso: 'mx', tel: '52', name: 'Mexique' },
	{ iso: 'fm', tel: '691', name: 'Micronésie' },
	{ iso: 'md', tel: '373', name: 'Moldavie' },
	{ iso: 'mc', tel: '377', name: 'Monaco' },
	{ iso: 'mn', tel: '976', name: 'Mongolie' },
	{ iso: 'me', tel: '382', name: 'Monténégro' },
	{ iso: 'ms', tel: '1664', name: 'Montserrat' },
	{ iso: 'mz', tel: '258', name: 'Mozambique' },
	{ iso: 'na', tel: '264', name: 'Namibie' },
	{ iso: 'nr', tel: '674', name: 'Nauru' },
	{ iso: 'np', tel: '977', name: 'Népal' },
	{ iso: 'ni', tel: '505', name: 'Nicaragua' },
	{ iso: 'ne', tel: '227', name: 'Niger' },
	{ iso: 'ng', tel: '234', name: 'Nigeria' },
	{ iso: 'nu', tel: '683', name: 'Niue' },
	{ iso: 'no', tel: '47', name: 'Norvège' },
	{ iso: 'nc', tel: '687', name: 'Nouvelle-Calédonie' },
	{ iso: 'nz', tel: '64', name: 'Nouvelle-Zélande' },
	{ iso: 'om', tel: '968', name: 'Oman' },
	{ iso: 'ug', tel: '256', name: 'Ouganda' },
	{ iso: 'uz', tel: '998', name: 'Ouzbékistan' },
	{ iso: 'pk', tel: '92', name: 'Pakistan' },
	{ iso: 'pw', tel: '680', name: 'Palau' },
	{ iso: 'ps', tel: '970', name: 'Palestine' },
	{ iso: 'pa', tel: '507', name: 'Panama' },
	{ iso: 'pg', tel: '675', name: 'Papouasie-Nouvelle-Guinée' },
	{ iso: 'py', tel: '595', name: 'Paraguay' },
	{ iso: 'nl', tel: '31', name: 'Pays-Bas' },
	{ iso: 'gb', tel: '46', name: 'Pays des Galles' },
	{ iso: 'pe', tel: '51', name: 'Pérou' },
	{ iso: 'ph', tel: '63', name: 'Philippines' },
	{ iso: 'pl', tel: '48', name: 'Pologne' },
	{ iso: 'fr', tel: '689', name: 'Polynésie française' },
	{ iso: 'pr', tel: '1', name: 'Porto-Rico' },
	{ iso: 'pt', tel: '351', name: 'Portugal ' },
	{ iso: 'qa', tel: '974', name: 'Qatar' },
	{ iso: 'cf', tel: '236', name: 'République Centrafricaine ' },
	{ iso: 'do', tel: '1809', name: 'Republique Dominicaine' },
	{ iso: 'cz', tel: '420', name: 'Republique Tchèque' },
	{ iso: 'fr', tel: '262', name: 'Réunion' },
	{ iso: 'ro', tel: '40', name: 'Roumanie' },
	{ iso: 'gb', tel: '44', name: 'Royaume-Uni' },
	{ iso: 'ru', tel: '7', name: 'Russie ' },
	{ iso: 'rw', tel: '250', name: 'Rwanda' },
	{ iso: 'fr', tel: '590', name: 'Saint-Barthélemy' },
	{ iso: 'sm', tel: '378', name: 'Saint-Marin' },
	{ iso: 'fr', tel: '590', name: 'Saint-Martin' },
	{ iso: 'pm', tel: '508', name: 'Saint Pierre et Miquelon' },
	{ iso: 'sh', tel: '290', name: 'Sainte Hélène ' },
	{ iso: 'lc', tel: '1758', name: 'Sainte Lucie' },
	{ iso: 'ws', tel: '685', name: 'Samoa' },
	{ iso: 'st', tel: '239', name: 'Sao tome et principe' },
	{ iso: 'sn', tel: '221', name: 'Sénégal' },
	{ iso: 'rs', tel: '381', name: 'Serbie' },
	{ iso: 'sc', tel: '248', name: 'Seychelles ' },
	{ iso: 'sl', tel: '232', name: 'Sierra Leone' },
	{ iso: 'sg', tel: '65', name: 'Singapour' },
	{ iso: 'sk', tel: '421', name: 'Slovaquie' },
	{ iso: 'si', tel: '386', name: 'Slovénie' },
	{ iso: 'so', tel: '252', name: 'Somalie' },
	{ iso: 'sd', tel: '249', name: 'Soudan' },
	{ iso: 'sd', tel: '211', name: 'Sud soudan' },
	{ iso: 'lk', tel: '94', name: 'Sri Lanka (ex Ceylan)' },
	{ iso: 'kn', tel: '1869', name: 'Saint kits et Nevis' },
	{ iso: 'vc', tel: '1784', name: 'Saint Vincent & les Grenadines' },
	{ iso: 'se', tel: '46', name: 'Suède' },
	{ iso: 'ch', tel: '41', name: 'Suisse' },
	{ iso: 'sr', tel: '597', name: 'Suriname' },
	{ iso: 'sz', tel: '268', name: 'Swaziland' },
	{ iso: 'sy', tel: '963', name: 'Syrie ' },
	{ iso: 'tj', tel: '992', name: 'Tadjikistan' },
	{ iso: 'tw', tel: '886', name: 'Taiwan' },
	{ iso: 'tz', tel: '255', name: 'Tanzanie ' },
	{ iso: 'td', tel: '235', name: 'Tchad' },
	{ iso: 'th', tel: '66', name: 'Thaïlande' },
	{ iso: 'tl', tel: '670', name: 'Timor leste' },
	{ iso: 'tg', tel: '228', name: 'Togo' },
	{ iso: 'tk', tel: '690', name: 'Tokelau' },
	{ iso: 'to', tel: '676', name: 'Tonga ' },
	{ iso: 'tt', tel: '1868', name: 'Trinité-et-Tobago' },
	{ iso: 'tn', tel: '216', name: 'Tunisie' },
	{ iso: 'tm', tel: '993', name: 'Turkménistan' },
	{ iso: 'tc', tel: '1649', name: 'Iles Turks et caïques ' },
	{ iso: 'tr', tel: '90', name: 'Turquie' },
	{ iso: 'tv', tel: '688', name: 'Tuvalu' },
	{ iso: 'ua', tel: '380', name: 'Ukraine' },
	{ iso: 'uy', tel: '598', name: 'Uruguay' },
	{ iso: 'vu', tel: '678', name: 'Vanuatu ' },
	{ iso: 'va', tel: '39', name: 'Vatican ' },
	{ iso: 've', tel: '58', name: 'Venezuela' },
	{ iso: 'vn', tel: '84', name: 'Viet Nam' },
	{ iso: 'wf', tel: '681', name: 'Wallis et Futuna' },
	{ iso: 'ye', tel: '967', name: 'Yémen' },
	{ iso: 'zm', tel: '260', name: 'Zambie' },
	{ iso: 'zw', tel: '263', name: 'Zimbabwe'}
]

const dropdowns = [
  { column: 31, list: ['A FAIRE', 'FAIT', 'N/A', 'EN COURS'] },
  { column: 32, list: ['A FAIRE', 'FAIT', 'N/A'] },
  { column: 33, list: ['A FAIRE', 'FAIT F6000', 'FAIT F6400', 'FAIT F7200', 'N/A'] },
  { column: 34, list: ['A FAIRE', 'FAIT F6000', 'FAIT F6400', 'FAIT F7200', 'N/A'] },
  { column: 36, list: ['A FAIRE', 'FAIT', 'N/A', 'EN COURS'] },
  { column: 37, list: ['A FAIRE', 'FAIT', 'N/A', 'EN COURS'] },
  { column: 38, list: ['A FAIRE', 'FAIT', 'N/A'] },
  { column: 39, list: ['A FAIRE', 'FAIT', 'N/A', 'EN COURS'] },
]

const getPhoneIndicator = iso => countries.find(item => item.iso === iso.toLowerCase()).tel || ''

function createDropdown (range, list) {
  if (!list) return
	const rule = SpreadsheetApp.newDataValidation().requireValueInList(list, true).setAllowInvalid(true).build()
	range.setDataValidation(rule)
	// Set the initial value to the first item in the list
	range.setValue(list[0])
}

function createCheckboxes (sheet, cells = [1, 30, 35, 40]) {
	cells.forEach(cell => {
		sheet.getRange(sheet.getLastRow(), cell).insertCheckboxes()
	})
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
	const shipping = {
		firstname: data.shipping.first_name,
		lastname: data.shipping.last_name,
		indicator: `'+${getPhoneIndicator(data.shipping.country)}`,
		phone: `'${data.shipping.phone}`,
		email: data.meta_data.find(item => item.key === '_shipping_email').value,
		address1: data.shipping.address_1,
		address2: data.shipping.address_2,
		postcode: data.shipping.postcode,
		city: data.shipping.city,
		country: new Intl.DisplayNames(['EN'], { type: 'region' }).of(data.shipping.country),
		note: data.customer_note,
		cost: data.shipping_total
	}
	const total = data.total

	// Separator
	sheet.appendRow(['  '])

	data.line_items.forEach((item, index) => {
		const orderNumber = data.line_items.length > 1 ? `${order.number} (${index + 1}/${data.line_items.length})` : order.number
		if (index + 1 === 1) {
			const product = productInformations(item)
			sheet.appendRow([
				'',
				orderNumber,
				order.date,
				product.name,
				'', '',
				product.quantity,
				product.size,
				product.width,
				product.height,
				product.finish,
				product.number,
				product.vimeoCode,
				shipping.lastname,
				shipping.firstname,
				shipping.email,
				shipping.indicator,
				shipping.phone,
				shipping.company,
				shipping.address1,
				shipping.address2,
				shipping.postcode,
				shipping.city,
				shipping.country,
				shipping.note,
				shipping.cost,
				product.price,
				total,
				'',
			])
			createCheckboxes(sheet)
		}
		else {
			const product = productInformations(item)
			sheet.appendRow(makeProductRow(product, orderNumber))
			createCheckboxes(sheet)
		}

		dropdowns.forEach(({ column, list }) => {
			createDropdown(sheet.getRange(sheet.getLastRow(), column), list)
		})
	})

	// Get the URL of the current Google Sheet
	const sheetUrl = SpreadsheetApp.getActiveSpreadsheet().getUrl()

	// Send email notification
	MailApp.sendEmail({
		to: '',
		subject: 'Nouvelle commande Hit the Road',
		htmlBody: `Une nouvelle commande a été ajoutée sur <a href="${sheetUrl}">le Google Sheet HitTheRoad</a>.`
	})

	return HtmlService.createHtmlOutput('Commande ajoutée avec succès')
}
