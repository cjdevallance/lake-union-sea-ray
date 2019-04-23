<?php

/**
 * Mmp_Api_Boat_Helper
*
* @package plugin-core
*
* @version 1.0
* @author Tim Hysniu
* @link https://github.dominionenterprises.com/DMM-CW-US/plugin-core
*/

class Mmp_Api_Boat_Helper {
    
    /**
     * Does this block have any nonempty fields
     *
     * @param string $category
     * @param boolean $boat
     */
    public static function has_boat_category($category = '', $boat)
    {
        $has_category = false;
        switch($category) {
            case 'builder':
                $fields = array('ModelYear', 'BuilderName', 'DesignerName', 'BoatHullMaterialCode', 'BoatKeelCode');
                break;
            case 'dimensions':
                $fields = array('LengthOverall', 'NominalLength', 'BeamMeasure', 'MaxDraft', 'DriveUp', 'DisplacementMeasure', 'BallastWeightMeasure', 'BridgeClearanceMeasure', 'FreeBoardMeasure', 'CabinHeadroomMeasure', 'DryWeightMeasure');
                break;
            case 'tanks':
                $fields = array('FuelTankCountNumeric', 'FuelTankCapacityMeasure', 'WaterTankCountNumeric', 'WaterTankCapacityMeasure');
                break;
            case 'engines':
                $fields = array('NumberOfEngines', 'TotalEnginePowerQuantity', 'CruisingSpeedMeasure', 'PropellerCruisingSpeed', 'MaximumSpeedMeasure');
                break;
            default:
                $fields = array();
        }
    
        foreach($fields as $key) {
            $has_category = !empty($boat[$key]) || $has_category;
        }
    
        return $has_category;
    }  
    
    /**
     * Get field value or - if empty
     * @param array $boat
     * @param string $key
     * @return string
     */
    public static function get_field_value($boat, $key) {
        return !isset($boat[$key]) || empty($boat[$key]) ? '-' : $boat[$key];
    }    
}