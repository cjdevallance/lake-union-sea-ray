<?php
class States {
    private static $states = array();
    private static $provinces = array();

    public function __construct() {
        
        // US States
        self::$states[' '] = 'Unknown';
        self::$states['AL'] = 'Alabama';
        self::$states['AK'] = 'Alaska';
        self::$states['AZ'] = 'Arizona';
        self::$states['AR'] = 'Arkansas';
        self::$states['CA'] = 'California';
        self::$states['CO'] = 'Colorado';
        self::$states['CT'] = 'Connecticut';
        self::$states['DE'] = 'Delaware';
        self::$states['DC'] = 'District Of Columbia';
        self::$states['FL'] = 'Florida';
        self::$states['GA'] = 'Georgia';
        self::$states['HI'] = 'Hawaii';
        self::$states['ID'] = 'Idaho';
        self::$states['IL'] = 'Illinois';
        self::$states['IN'] = 'Indiana';
        self::$states['IA'] = 'Iowa';
        self::$states['KS'] = 'Kansas';
        self::$states['KY'] = 'Kentucky';
        self::$states['LA'] = 'Louisiana';
        self::$states['ME'] = 'Maine';
        self::$states['MD'] = 'Maryland';
        self::$states['MA'] = 'Massachusetts';
        self::$states['MI'] = 'Michigan';
        self::$states['MN'] = 'Minnesota';
        self::$states['MS'] = 'Mississippi';
        self::$states['MO'] = 'Missouri';
        self::$states['MT'] = 'Montana';
        self::$states['NE'] = 'Nebraska';
        self::$states['NV'] = 'Nevada';
        self::$states['NH'] = 'New Hampshire';
        self::$states['NJ'] = 'New Jersey';
        self::$states['NM'] = 'New Mexico';
        self::$states['NSW'] = 'New South Wales';
        self::$states['NY'] = 'New York';
        self::$states['NC'] = 'North Carolina';
        self::$states['ND'] = 'North Dakota';
        self::$states['OH'] = 'Ohio';
        self::$states['OK'] = 'Oklahoma';
        self::$states['OR'] = 'Oregon';
        self::$states['PA'] = 'Pennsylvania';
        self::$states['QC'] = 'Quebec Canada';
        self::$states['RI'] = 'Rhode Island';
        self::$states['SC'] = 'South Carolina';
        self::$states['SD'] = 'South Dakota';
        self::$states['TN'] = 'Tennessee';
        self::$states['TX'] = 'Texas';
        self::$states['UT'] = 'Utah';
        self::$states['VT'] = 'Vermont';
        self::$states['VA'] = 'Virginia';
        self::$states['WA'] = 'Washington';
        self::$states['WV'] = 'West Virginia';
        self::$states['WI'] = 'Wisconsin';
        self::$states['WY'] = 'Wyoming';
        
        // Covering provinces in case country is Canada
        self::$provinces['BC'] = 'British Columbia';
        self::$provinces['ON'] = 'Ontario';
        self::$provinces['QC'] = 'Quebec';
        self::$provinces['AB'] = 'Alberta';
        self::$provinces['NS'] = 'Nova Scotia';
        self::$provinces['NB'] = 'New Brunswick';
        self::$provinces['NL'] = 'Newfoundland and Labrador';
        self::$provinces['SK'] = 'Saskatchewan';
        self::$provinces['PE'] = 'Prince Edward Island';
        
    }

    public function getStateName($code) {
        
        $state = '';
        if(isset(self::$states[$code])) {
            $state = self::$states[$code];
        }
        
        if(empty($state) && isset(self::$provinces[$code])) {
            $state = self::$provinces[$code];
        }
        
        if(empty($state)) {
            $state = $code;
        }
        
        return $state;
    }
    
    public function getCountryByState($stateCode) {
        if(isset(self::$states[$stateCode])) {
            return 'US';
        }
        elseif(isset(self::$states[$stateCode])) {
            return 'CA';
        }
    }
}
?>
