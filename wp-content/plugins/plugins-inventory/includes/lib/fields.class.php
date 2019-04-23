<?php
class Fields {
    private static $fields;

    public function __construct() {

        self::$fields = 'Source,DocumentID,SalesStatus,CoOpIndicator,Price,BoatLocation,MakeString,MakeStringExact,ModelYear,SaleClassCode,Model,ModelExact,BoatCategoryCode,NominalLength,LengthOverall,NormNominalLength,NormPrice,GeneralBoatDescription,BoatClassCode,Images';

    }
    public function getFields() {
        return self::$fields;
    }
}

