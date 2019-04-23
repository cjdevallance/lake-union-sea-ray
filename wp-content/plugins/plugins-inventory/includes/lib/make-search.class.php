<?php
//Code for boat search API
class MakeSearch {


    private $searchAPI_url;
    private $Makelist;
    private $Condlist;
    private $commonParams = "&SalesStatus=Active&Co0pIndicator=true&Source=IMT";
    private $multiValueFields = array('BoatClassCode', 'BoatCountryID');
    private $rangeFields=array("PriceMin" => "price:min","PriceMax" => "price:max","LengthMin" => "length:min","LengthMax" => "length:max", "LengthUnit" => "length:unit", "ModelYearMin" => "year:min", "ModelYearMax" => "year:max");

    public $QUERYPARAMS = 'queryParams';
    public $RANGEPARAMS = 'rangeParams';
    public $BODY = 'body';
    public $STATUS = 'status';
    public $ERROR = 'ERROR';
    public $SUCCESS = 'SUCCESS';

    public function autoload_class( $class, $create_object = FALSE )
    {
        // create the path base just once
        static $base = FALSE;

        ! $base && $base = ( ABSPATH . 'wp-content/plugins/plugins-inventory/includes/lib' );
        ! class_exists( $class ) && require "$base/$class.class.php";

        return $create_object ? new $class : TRUE;
    }

    public function __construct() {

        $this->autoload_class( 'auth' );
        $this->autoload_class( 'party' );
        $this->autoload_class( 'make' );
        $this->autoload_class( 'cond' );
        $auth = new Auth();
        $party = new Party();
        $make = new Make();
        $cond = new Cond();
        $this->searchAPI_url = "https://services.boats.com/" . $auth->getApiKey() . "/mmp/search?OwnerPartyId=" . $party->getPartyID() . "&SalesStatus=Active&fields=MakeStringExact,SaleClassCode" . "&MakeStringExact=" . $make->getMake() . "&condition=" . $cond->getCond();
        $this->Makelist = "&MakeStringExact=" . $make->getMake();
        $this->Condlist = "&condition=" . $cond->getCond();
    }

    public function makesearch($criteria = NULL, //a string of search criteria in HTTP GET format
                           $fields = NULL, //an array of the fields to be returned
                           $facetFields = NULL, //an array of facet fields
                           $results_per_page=20, //Number of results per page
                           $sort = '', //A String for the sort order.  Format: 'fieldName|order' where order is asc or desc
                           $debug = false,
                           $facetLimit = 1000,
                           $facetMinCount = 1
    ) {

        $toReturn = array();
        $rangeParams=array();

        if (!empty($fields)) {
            $fieldQuery = '&fields=';
            foreach($fields as $field) {
                $fieldQuery .= "$field,";
            }
            $fieldQuery = rtrim($fieldQuery, ',');
        } else {
            $fieldQuery = '';
        }

        if (!empty($facetFields)) {
            $facetQuery = '&facets=';
            foreach($facetFields as $facetField) {
                $facetQuery .= "$facetField;";
            }
            $facetQuery = rtrim($facetQuery, ';') . "&facetLimit=$facetLimit&facetMincount=$facetMinCount";
        } else {
            $facetQuery = '';
        }
        $rowCount = "&rows=$results_per_page";

        if (!empty($sort)) {
            $sortOrder = "&sort=$sort";
        } else {
            $sortOrder = '';
        }

        //Get search Results
        if ($criteria == NULL) {
            $query = $this->searchAPI_url . $this->commonParams . $this->Makelist . $this->Condlist . $fieldQuery . $facetQuery . $rowCount . $sortOrder;
        } else {
            $queryString = str_replace("+", " ", $criteria);
            $queryString = str_replace("%2B", "+", $queryString);
            $params = explode("&", $queryString);
            $queryParams = array();
            foreach($params as $param) {
                $kvp = explode("=", urldecode($param));
                //Remove empty parameters
                if ($kvp[1] != "") {
                    //For valid multi value fields, clean multiples of the same param into a comma separated list on the one param
                    if (array_key_exists($kvp[0],$this->multiValueFields) && array_key_exists($kvp[0], $queryParams)) {
                        $queryParams[$kvp[0]] = $queryParams[$kvp[0]] . "," . $kvp[1];
                    } else {
                        //Merge range query min & max vals
                        if (array_key_exists($kvp[0], $this->rangeFields)) {
                            $rangeKVP = explode(":", $this->rangeFields[$kvp[0]]);
                            if (!array_key_exists($rangeKVP[0], $rangeParams)) {
                                $rangeParams[$rangeKVP[0]] = array();
                            }
                            $rangeParams[$rangeKVP[0]][$rangeKVP[1]] = $kvp[1];

                        } else {
                            //It's not a range param, just add it
                            $queryParams[$kvp[0]] = $kvp[1];
                        }
                    }
                }
            }
            $toReturn[$this->QUERYPARAMS] = $queryParams;
            $toReturn[$this->RANGEPARAMS] = $rangeParams;
            $searchString = "";
            foreach($queryParams as $key => $value) {
                $searchString = $searchString . "&" . $key . "=" . $value;
            }
            foreach($rangeParams as $key => $value) {
                $operator = "=";
                if (array_key_exists("min", $value)) {
                    $min = $value["min"];
                } else {
                    $min = "";
                    $operator = "=<";
                }
                if (array_key_exists("max", $value)) {
                    $max = ":" . $value["max"];
                } else {
                    $max="";
                    $operator = "=>";
                }
                if (array_key_exists("unit", $value)) {
                    $unit = "|" . $value["unit"];
                } else {
                    $unit = "";
                }
                if (! ($min == "" && $max == "")) {
                    $searchString = $searchString . "&" . $key . $operator . $min . $max . $unit;
                }
            }
            $query = $this->searchAPI_url . $this->commonParams . $this->Makelist . $this->Condlist . $searchString . $fieldQuery . $facetQuery . $rowCount . $sortOrder;
            $query=str_replace(' ', '+', $query); //replace spaces with + because otherwise file_get_contents explodes.
        }

        $opts = array('http' =>
            array(
                'method'  => 'GET',
                //'user_agent '  => "Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9.2) Gecko/20100301 Ubuntu/9.10 (karmic) Firefox/3.6",
                'header' => array(
                    'Accept-Language:en-GB,en-US;q=0.8,en;q=0.6
		'
                ),
            )
        );
        $context  = stream_context_create($opts);

        //Supress warnings on file_get_contents with @, and turn on error tracking
        $old_track = ini_set('track_errors', '1');
        $file = @file_get_contents($query, false, $context);
        //Check we got a response
        if($file === FALSE) {
            $toReturn[$this->STATUS] = $this->ERROR;
            $toReturn[$this->BODY] = array($this->ERROR => $php_errormsg);

        } else {
            $search_response=json_decode($file, true);

            if (array_key_exists('error',$search_response)) {
                // Output error message in the source but don't display anything
                $toReturn[$this->STATUS] = $this->ERROR;
                $toReturn[$this->BODY] = array($this->ERROR => print_r($search_response['error'], true));
            } else if (!array_key_exists('results',$search_response)) {
                $toReturn[$this->STATUS] = $this->ERROR;
                $toReturn[$this->BODY] = array($this->ERROR => "An unknown error occurred");
            } else {
                $toReturn[$this->STATUS] = $this->SUCCESS;
                $toReturn[$this->BODY] = $search_response;
            }
            if ($debug) {
                echo '<!-- ' . str_replace('-->', '- - >', $query) . ' -->';
                echo "<!-- " . str_replace('-->', '- - >', print_r($toReturn, true)) . " -->";
            }
        }
        //turn error tracking off again
        ini_set('track_errors', $old_track);

        return $toReturn;
    }
}

?>
