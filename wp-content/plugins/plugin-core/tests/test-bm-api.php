<?php

date_default_timezone_set('UTC');

class TestBmAPI extends PHPUnit_Framework_TestCase {

    private $api;
    private $values;
    private $DocumentID;

    public function setUp () {
        $this->values = array(
            "{TaskID}" => "ProcessSalesLead",
            "{CreatorNameCode}" => "BC",
            "{SenderNameCode}" => "BC",
            "{URI}" => "essential-elite.dmmwebsites.local",
            "{CreationDateTime}" => date(DATE_ATOM),
            "{DestinationNameCode}" => "BC",
            "{DocumentID}" => uniqid(),
            
            "{SaleClassCode}" => "Used",
            "{LeadSourceCode}" => "essential-elite.dmmwebsites.local",
            "{LeadComments}" => "Body of request",
            "{CountryID}" => "US",

            // personal information
            "{GivenName}" => "John",
            "{FamilyName}" => "Doe",
            "{URIID}" => "Reycamera@aol.com",
            "{ChannelCode}" => "email",

            "{BusinessTypeCode}" => "provisioning",
            "{OrganizationID}" => "20680",
            "{ProgramIdDescription}" => "DMM IMT",
            "{MarketingID}" => "4504936",
            "{LeadCreationDateTime}" => date(DATE_ATOM),
            "{LeadStatus}" => "N/A",
            "{LeadRequestTypeString}" => "INTERESTED-IN",
            "{MediaSourceURI}" => "N/A",
            "{MakeString}" => "N/A",
            "{ModelDescription}" => "N/A",
            "{ModelYear}" => "2003",
            "{unitCode}" => "feet",
            "{BoatLengthMeasure}" => "0.0"
        );
        $this->api = new Bm_API($this->values, true);
    }

    /**
     * Test the xml has peen parsed properly
     */
    public function testPreparedXMLBody () {
        
        // prepare request
        $this->api->prepare();
        $body = $this->api->getRequestBody();

        // define which elements are attributes
        $attributes = array("{systemEnvironmentCode}", "{unitCode}");
        $custom_attributes = array("{BoatLengthMeasure}");

        // validate xml node elements
        foreach ($this->values as $key => $value) {
            $stripped_key = str_replace(array("{", "}"), "", $key);

            // test as long as the key is an XML node element
            if ( ! in_array($key, array_merge($attributes, $custom_attributes)) ){
                $this->assertContains("<{$stripped_key}>{$value}</$stripped_key>", $body);
            }
        }

        // handle attributes differently
        // validate xml node elements
        foreach ($attributes as $value) {
            $stripped_key = str_replace(array("{", "}"), "", $value);

            // test as long as the key is an XML node element
            if ( ! in_array($value, array_merge($attributes, $custom_attributes)) ){
                $this->assertContains("{$stripped_key}=\"{$value}\"", $body);
            }
        }

        // test special case
        // <BoatLengthMeasure unitCode="{unitCode}">{BoatLengthMeasure}</BoatLengthMeasure>
        $this->assertContains(">{$this->values['{BoatLengthMeasure}']}</BoatLengthMeasure>", $body);

    }

    /**
     * Test the content type is set as expected
     */
    public function testContentType () {
        $this->assertEquals($this->api->getContentType(), 'Content-Type: text/xml');
    }

    /**
     * Test submitted data
     */
    public function testResponse () {
        
        $this->api->prepare();
        $response = $this->api->send_request();

        // If there's content then 
        $this->assertTrue($response);

        // // simplexml_load_string
    }

}
