<?php

class TestMmpAPI extends PHPUnit_Framework_TestCase {

    private $_mmp_api_key;
    private $_imt_party_id;
    private $_brand_party_ids;
    
    function setUp()
    {
        $this->_brand_party_ids = array(1234);
        $this->_mmp_api_key = '55b75f1d6c3b';
        $this->_imt_party_id = 29999;
        
        $this->importer = new Mmp_API($this->_mmp_api_key, $this->_imt_party_id);
        $this->importer->set_party_id($this->_imt_party_id);
    }
    
	function testCanQueryCheck() {
	    $this->assertTrue($this->importer->can_query());
	    
	    $this->importer->set_party_id(NULL);
	    $this->assertFalse($this->importer->can_query());
	    
	    $this->importer->set_document_id(1234);
	    $this->assertTrue($this->importer->can_query());
	}
	
	function testSetSortOrder()
	{
	    $expected_sort_by = 'Model|asc';
	    $sort_by = $this->importer->set_sort_by('Model', 'asc');
	    $this->assertEquals($expected_sort_by, $sort_by);
	    
	    $expected_sort_by = 'Model|desc';
	    $sort_by = $this->importer->set_sort_by('Model', 'notexistssortorder');
	    $this->assertEquals($expected_sort_by, $sort_by);
	}
	
	function testBuildQueryUrl()
	{
	    $page = 3;
	    $fields = 'DocumentID';
	    $additionalField = 'Owner';
	    $sort_order = 'desc';
	    $rows = 20;
	    $documentID = 1234;
	    $currentModels = true;
	    $models = true;
	    $make = 'Sea Ray';
	    $facets = 'BoatClassCode';
	    $currency = 'GBP';
	    
	    $this->importer->set_current_page($page);
	    $this->importer->set_current_models($currentModels);
	    $this->importer->set_models($models);
	    $this->importer->set_fields($fields);
	    $this->importer->add_field($additionalField);
	    $this->importer->add_filter('Make', $make);
	    $this->importer->set_results_per_page(20);
	    $this->importer->set_sort_by($fields, $sort_order);
	    $this->importer->set_document_id($documentID);
	    $this->importer->set_facets($facets);
	    $this->importer->set_services_url('https://services.boats.com/%s/mmp/search');
	    $this->importer->set_currency($currency);
	    
	    $expectedUrl = 'https://services.boats.com/' . $this->_mmp_api_key . '/mmp/search?';
	    $expectedUrl .= (($models == true) ? '&models=true' : '');
	    $expectedUrl .= '&currentModels=' . (($currentModels == true) ? 'true' : 'false');
	    $expectedUrl .= '&OwnerPartyId=' . $this->_imt_party_id;
	    $expectedUrl .= '&DocumentID=' . $documentID;
	    $expectedUrl .= '&Make=' . urlencode($make);
	    $expectedUrl .= '&fields=' . $fields . ',' . $additionalField;
	    $expectedUrl .= '&sort=' . $fields . '|' . $sort_order;
	    $expectedUrl .= '&rows=' . $rows;
	    $expectedUrl .= '&offset=' . $rows * 2;
	    $expectedUrl .= '&facets=' . $facets;
	    $expectedUrl .= '&currency=' . $currency;
	    
	    $actualUrl = $this->importer->build_query_url();
	    
	    $this->assertEquals($expectedUrl, $actualUrl);
	}
	
	function _testConvertJsonToPostFormat()
	{
	    $jsonInput = file_get_contents( dirname(__FILE__) . '/resources/mmp-results.json' );
	    $data = json_decode($jsonInput, true);
	    $raw_post = $data['results'][0];
	}
}

