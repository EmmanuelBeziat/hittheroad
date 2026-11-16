/**
 * Shared helpers: configuration, webhook authentication and cell sanitizing.
 * Add this file to every Apps Script project using doPost or the WooCommerce API.
 *
 * Script properties (Project Settings > Script properties):
 * - WEBHOOK_TOKEN: long random secret, also appended to the WooCommerce webhook
 *   delivery URL (…/exec?token=<WEBHOOK_TOKEN>). Apps Script cannot read request
 *   headers, so the WooCommerce HMAC signature cannot be checked.
 * - WC_API_URL: WooCommerce REST API base URL, e.g. https://example.com/wp-json/wc/v3
 * - WC_CONSUMER_KEY / WC_CONSUMER_SECRET: WooCommerce REST API keys
 */

/**
 * Read a required script property.
 * @param {string} key Property name
 * @returns {string}
 */
function getConfig (key) {
	const value = PropertiesService.getScriptProperties().getProperty(key)
	if (!value) {
		throw new Error(`Propriété de script manquante : ${key}`)
	}
	return value
}

/**
 * Constant-time string comparison.
 * @param {string} a
 * @param {string} b
 * @returns {boolean}
 */
function safeEqual (a, b) {
	if (typeof a !== 'string' || typeof b !== 'string' || a.length !== b.length) {
		return false
	}
	let diff = 0
	for (let i = 0; i < a.length; i++) {
		diff |= a.charCodeAt(i) ^ b.charCodeAt(i)
	}
	return diff === 0
}

/**
 * Whether a doPost request carries the expected token (?token=…).
 * @param {GoogleAppsScript.Events.DoPost} e
 * @returns {boolean}
 */
function isAuthorizedRequest (e) {
	const token = e && e.parameter && e.parameter.token
	return safeEqual(String(token || ''), getConfig('WEBHOOK_TOKEN'))
}

/**
 * Response returned to unauthorized requests.
 * @returns {GoogleAppsScript.Content.TextOutput}
 */
function unauthorizedResponse () {
	Logger.log('Requête refusée : jeton absent ou invalide')
	return ContentService.createTextOutput('Unauthorized')
}

/**
 * Neutralize spreadsheet formulas in user-provided text (formula injection).
 * Values starting with =, +, -, @ are prefixed with an apostrophe (kept as text).
 * @param {*} value
 * @returns {*}
 */
function toCellText (value) {
	if (typeof value !== 'string') {
		return value
	}
	return /^[=+\-@\t\r]/.test(value) ? `'${value}` : value
}
