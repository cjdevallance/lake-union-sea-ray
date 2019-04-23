<?php
class TestImportSupportedBrands extends PHPUnit_Framework_TestCase {

	function testSample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}
	
	function setUp()
	{
	    $partyId = 29999;
	    $provisioningWsUrl = 'http://10.93.193.108:8080/prov-ws';
	    $this->importer = new Import_Supported_Brands($provisioningWsUrl, $partyId);
	}
	
	function testParseXmlNoBrandElements()
	{
	    $xmlInput ='<org-unit format-version="2" id="29999" type="orgunit" status-id="ACTV"></org-unit>';
	
	    $expected_brand_ids = array();
	    $this->importer->set_party_xml($xmlInput);
	    $actual_brand_ids = $this->importer->get_supported_brands();
	
	    $this->assertEquals($expected_brand_ids, $actual_brand_ids);
	}	
	
	function testParseXmlNoValidBrand()
	{
	    $xmlInput ='
<org-unit format-version="2" id="29999" type="orgunit" status-id="ACTV">
    <supplier-relationships>
        <party-relationship party-role="carried" supplier-party="orgunit:11111:Some other party " client-party="brand:23373:Beneteau USA">a</party-relationship>
    </supplier-relationships>
</org-unit>
';
	     
	    $expected_brand_ids = array();
	    $this->importer->set_party_xml($xmlInput);
	    $actual_brand_ids = $this->importer->get_supported_brands();
	     
	    $this->assertEquals($expected_brand_ids, $actual_brand_ids);	    
	}
	
	function testParseXmlFromPartyServiceTwoBrands()
	{
	    
	    $expected_brand_ids = array(
            '23373' => 'Beneteau USA',
            '22858' => 'Dufour'
	    );
	    
	    $this->importer->set_party_xml($this->_getValidPartyServiceTwoBrands());
	    $actual_brand_ids = $this->importer->get_supported_brands();
	    
	    $this->assertEquals($expected_brand_ids, $actual_brand_ids);
	}
	
	function testParseBrandsAndSupportedBrandsXml() {
	    
	    $oem1 = array(
                'id' => '21809',
    	        'name' => 'Beneteau USA',
    	        'logo' => 'http://www.boats.com/published/images/logos/logo_beneteauUSA09.gif'            
	    );
	    $oem2 = array(
	            'id' => '21628',
	            'name' => 'Dufour',
	            'logo' => 'http://www.boats.com/published/images/logos/logo_dufour07.gif'
	    );	    
	    
	    $expected_map = array(
	           '23373' => $oem1,
	           '22858' => $oem2 
	    );
	     
	    $this->importer->set_brands_xml($this->_getTwoValidBrandsXmlBrandsService());
	    $this->importer->set_party_xml($this->_getValidPartyServiceTwoBrands());
	    
	    $actual_map = $this->importer->get_supported_brand_parties();
	     
	    $this->assertEquals($expected_map, $actual_map);	    
	    
	    // test stats too
	    $expected_stats = array(
	            'total_brands' => 2,     // we set 2 as total
	            'brands_supported' => 2  // we set 2 as supported
	    );
	    $actual_stats = $this->importer->get_stats();
	    
	    $this->assertEquals($expected_stats, $actual_stats);
	    
	    // lets also test get_supported_brands_party_ids()
	    $expectedPartyIds = array(21809, 21628);
	    $actualPartyIds = $this->importer->get_supported_brands_party_ids();
	    $this->assertEquals($expectedPartyIds, $actualPartyIds);
	    
	}
	
	function testBrandsNotSupportedAreNotReturned() 
	{
	    $supportedBrandXml = '
	            <org-unit format-version="2" id="29999" type="orgunit" status-id="ACTV">
                    <supplier-relationships>
                        <party-relationship party-role="carried" supplier-party="orgunit:29999:Denison Yacht Sales " client-party="brand:23188:Pacific Explorer">b</party-relationship>
                    </supplier-relationships>
                </org-unit>';
	    
	    $expected_map = array();
	    
	    $this->importer->set_brands_xml($this->_getTwoValidBrandsXmlBrandsService());
	    $this->importer->set_party_xml($supportedBrandXml);
	     
	    $actual_map = $this->importer->get_supported_brand_parties();
	    
	    $this->assertEquals($expected_map, $actual_map);	    
	}
	
	function _getTwoValidBrandsXmlBrandsService()
	{
	    return '<party-list>
                    <parties xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" format-version="2" id="23373" parent-id="21809" type="brand" status-id="ACTV" xsi:type="brand">
                        <name>Beneteau USA</name>
                        <logo-url>
                        http://www.boats.com/published/images/logos/logo_beneteauUSA09.gif
                        </logo-url>
                        <sales-message/>
                        <address>
                            <website-uRL>www.beneteauusa.com</website-uRL>
                        </address>
                    </parties>
                    <parties xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" format-version="2" id="22858" parent-id="21628" type="brand" status-id="ACTV" xsi:type="brand">
                        <name>Dufour</name>
                        <logo-url>
                            http://www.boats.com/published/images/logos/logo_dufour07.gif
                        </logo-url>
                        <sales-message/>
                        <address>
                            <website-uRL>www.dufour-yachts.com</website-uRL>
                        </address>
                    </parties>	            
                </party-list>';
	}

	function _getValidPartyServiceTwoBrands()
	{
	    return '<org-unit format-version="2" id="29999" type="orgunit" status-id="ACTV">
                    <supplier-relationships>
                        <party-relationship party-role="carried" supplier-party="orgunit:29999:Denison Yacht Sales " client-party="brand:23373:Beneteau USA">a</party-relationship>
                        <party-relationship party-role="carried" supplier-party="orgunit:29999:Denison Yacht Sales " client-party="brand:22858:Dufour">b</party-relationship>
                    </supplier-relationships>
                </org-unit>';
	}	
}

