<?php
class Environment {
    private static $protocol;
    private static $imtImgHost;
    private static $imgHost;
    private static $Makelist;
    private static $Condlist;
    private static $apiURL;
    private static $km2nm = 0.539957;
    private static $miles2nm = 0.868976;
    private static $feet2metres = 0.3048;
    private static $impgallons2litres = 4.54609188;
    private static $usgallons2litres = 3.78541;
    private static $usgallons2impgallons = 0.832674;
    private static $lbs2tonnes = 0.00045359237;  //Metric
    private static $lbs2tons = 0.0004464286;     // Imperial (UK Long Ton)
    private static $kgs2tonnes = 0.001;  //Metric
    private static $kgs2tons = 0.000984206528;     // Imperial (UK Long Ton)
    private static $resizerReplaceUrl = "http://imt.qa.boatwizard.com";
    private static $resizerUrl = "http://newimages.yachtworld.com/resize";

    public function autoload_class( $class, $create_object = FALSE )
    {
        // create the path base just once
        static $base = FALSE;

        ! $base && $base = ( ABSPATH . 'wp-content/plugins/plugins-inventory/includes/lib' );
        ! class_exists( $class ) && require "$base/$class.class.php";

        return $create_object ? new $class : TRUE;
    }

    public function __construct() {
        self::$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        self::autoload_class( 'auth' );
        self::autoload_class( 'party' );
        self::autoload_class( 'make' );
        self::autoload_class( 'cond' );
        self::autoload_class( 'fields' );
        $auth = new Auth();
        $party = new Party();
        $make = new Make();
        $cond = new Cond();
        $fields = new Fields();
        //API to use = 55b75f1d6c3b
        //Owner party ID to use = 29999
        self::$apiURL = "https://services.boats.com/" . $auth->getApiKey() . "/mmp/search?OwnerPartyId=" . $party->getPartyID() . "&SalesStatus=Active" . "&MakeStringExact=" . $make->getMake() . "&condition=" . $cond->getCond()/* . "&fields=" . $fields->getFields()*/;
        self::$Makelist = "&MakeStringExact=" . $make->getMake();
        self::$Condlist = "&condition=" . $cond->getCond();
        self::$resizerReplaceUrl = "http://imt.qa.boatwizard.com";
        self::$resizerUrl = "http://images.qa.boats.com/resize";
        }
    public static function getImgHost()
    {
        return self::$imgHost;
    }
    /**
     * @return string
     */
    public static function getImtImgHost()
    {
        return self::$imtImgHost;
    }
    /**
     * @return string
     */
    public function getApiURL() {
        return self::$apiURL;
    }
    /**
     * @return string
     */
    public function getMakelist() {
        return self::$Makelist;
    }
    /**
     * @return string
     */
    public function getCondlist() {
        return self::$Condlist;
    }
    /**
     * @param $value
     * @param $unit
     * @return string
     */
    public static function formatValue($value, $unit) {
        if (empty($value)) {
            return "";
        }
        switch ($unit) {
            case "kilometers per hour":
                $result = number_format($value * self::$km2nm, 0);
                $result .= 'kn';
                break;
            case "miles per hour":
                $result = number_format($value * self::$miles2nm, 0);
                $result .= 'kn';
                break;
            case "kn":
                $result = number_format($value . 'kn', 0);
                $result .= 'kn';
                break;
            case "kilometer":
                $result = number_format($value * self::$km2nm, 0);
                $result .= 'nm';
                break;
            case "mi":
                $result = number_format($value * self::$miles2nm, 0);
                $result .= 'nm';
                break;
            case "nautical mile":
                $result = $value . 'nm';
                break;
            case "lb":
                $result = number_format($value * self::$lbs2tonnes, 0);
                break;
            case "kg":
                $result = number_format($value * self::$kgs2tonnes, 0);
                break;
            case "ft":
                $result = number_format($value * self::$feet2metres, 0);
                break;
            case "m":
                $result = number_format($value, 0);
                break;
            case "imperial gallon":
                $result = number_format($value * self::$impgallons2litres, 0);
                break;
            case "gal":
                $result = number_format($value * self::$usgallons2litres, 0);
                break;
            default:
                $result = $value . ' ' . $unit;
        }
        return $result;
    }
    /**
     * @return string
     */
    public static function getResizerUrl()
    {
        return self::$resizerUrl;
    }
    /**
     * @return string
     */
    public static function getResizerReplaceUrl()
    {
        return self::$resizerReplaceUrl;
    }
}