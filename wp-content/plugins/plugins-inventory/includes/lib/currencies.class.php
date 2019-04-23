<?php
class Currencies {
	private static $currencies = array();
	
	public function __construct() {
		self::$currencies['USD'] = '$';
		self::$currencies['GBP'] = '&pound;';
		self::$currencies['EUR'] = '&euro;';
		self::$currencies['AUD'] = 'A$';
		self::$currencies['NOK'] = 'kr';
		self::$currencies['RUB'] = 'руб';
	}
	
	public function getSymbol($code) {
		return self::$currencies[$code];
	}
}
?>
