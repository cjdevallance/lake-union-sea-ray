<?php
/**
 * Bm_API - Interface used to submit leads to the "boats monitor" routing system
 * Documentation https://confluence.boats.com:8443/display/LM/Accepting+BoatsMonitor+Submissions+From+A+New+Partner
 *
 * @package plugin-core
 *
 * @version 1.0
 * @author Jesus Rodriguez
 * @link https://github.dominionenterprises.com/DMM-CW-US/plugin-core
 */

/**
 * Bm_API class
 */
class Bm_API {
    
    // username for BMRS
    protected static $_username = 'boats';

    // password for BMRS
    protected static $_password = 'boats';
    
    // API endpoints for BMRS
    protected static $_qa_url = 'http://crmapp01.qa.boats.local:8088/boatsmonitor/mates-acceptor';
    protected static $_prod_url = 'http://mws.boats.com/boatsmonitor/mates-acceptor';
    
    // debug mode
    protected $_debug = false;
    
    // password for BMRS
    protected $_request_body = '';

    // data to parse XML with
    protected $_data = array();

    // store last request
    protected $_last_response = array();
    
    // content type
    protected $_content_type = 'Content-Type: text/xml';

    /**
     * Lead manager request body in XML format.
     *
     * @param systemEnvironmentCode String valid values "Test" and "Production"
     * @param TaskId String
     * @param CreatorNameCode String
     * @param SenderNameCode String
     * @param URI String
     * @param CreationDateTime DatetTime in ISO 8601 format (eg. 2015-06-05T11:08:23-07:00)
     * @param DestinationNameCode String
     * @param DocumentID String Unique request identifier
     * @param SaleClassCode String
     * @param LeadSourceCode String
     * @param LeadComments String
     * @param GivenName String
     * @param FamilyName String
     * @param CountryID String
     * @param URIID String
     * @param ChannelCode String
     * @param BusinessTypeCode String
     * @param OrganizationID String
     * @param ProgramIdDescription String
     * @param MarketingID String
     * @param LeadCreationDateTime String
     * @param LeadStatus String
     * @param LeadRequestTypeString String
     * @param MediaSourceURI String
     * @param MakeString String
     * @param ModelDescription String
     * @param ModelYear String
     * @param unitCode String
     * @param BoatLengthMeasure String
     */
    protected $_xml = <<<XML_BODY
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<ProcessSalesLead releaseID="5.4.4" systemEnvironmentCode="{systemEnvironmentCode}" xmlns:ns2="http://www.openapplications.org/oagis/9" xmlns="http://www.starstandard.org/STAR/5">
    <ApplicationArea>
        <Sender>
            <TaskID>{TaskID}</TaskID>
            <CreatorNameCode>{CreatorNameCode}</CreatorNameCode>
            <SenderNameCode>{SenderNameCode}</SenderNameCode>
            <URI>{URI}</URI>
        </Sender>
        <CreationDateTime>{CreationDateTime}</CreationDateTime>
        <Destination>
            <DestinationNameCode>{DestinationNameCode}</DestinationNameCode>
        </Destination>
    </ApplicationArea>
    <ProcessSalesLeadDataArea>
        <Process/>
        <SalesLead>
            <SalesLeadHeader>
                <DocumentIdentificationGroup>
                    <DocumentIdentification>
                        <DocumentID>{DocumentID}</DocumentID>
                    </DocumentIdentification>
                </DocumentIdentificationGroup>
                <SaleClassCode>{SaleClassCode}</SaleClassCode>
                <LeadSourceCode>{LeadSourceCode}</LeadSourceCode>
                <LeadComments>{LeadComments}</LeadComments>
                <CustomerProspect>
                    <ProspectParty>
                        <SpecifiedPerson>
                            <GivenName>{GivenName}</GivenName>
                            <FamilyName>{FamilyName}</FamilyName>
                            <ResidenceAddress>
                                <CountryID>{CountryID}</CountryID>
                            </ResidenceAddress>
                            <URICommunication>
                                <URIID>{URIID}</URIID>
                                <ChannelCode>{ChannelCode}</ChannelCode>
                            </URICommunication>
                        </SpecifiedPerson>
                    </ProspectParty>
                </CustomerProspect>
                <ReceivingDealerParty>
                    <SpecifiedOrganization>
                        <BusinessTypeCode>{BusinessTypeCode}</BusinessTypeCode>
                        <OrganizationID>{OrganizationID}</OrganizationID>
                    </SpecifiedOrganization>
                </ReceivingDealerParty>
                <Marketing>
                    <ProgramIdDescription>{ProgramIdDescription}</ProgramIdDescription>
                    <MarketingID>{MarketingID}</MarketingID>
                </Marketing>
                <LeadCreationDateTime>{LeadCreationDateTime}</LeadCreationDateTime>
            </SalesLeadHeader>
            <SalesLeadDetail>
                <LeadStatus>{LeadStatus}</LeadStatus>
                <LeadRequestTypeString>{LeadRequestTypeString}</LeadRequestTypeString>
                <SalesLeadLineItem>
                    <SalesLeadMarineLineItem>
                        <SalesLeadBoatLineItem>
                            <AdditionalMedia>
                                <MediaSourceURI>{MediaSourceURI}</MediaSourceURI>
                            </AdditionalMedia>
                            <SalesLeadBoat>
                                <MakeString>{MakeString}</MakeString>
                                <ModelDescription>{ModelDescription}</ModelDescription>
                                <ModelYear>{ModelYear}</ModelYear>
                                <BoatLengthGroup>
                                    <BoatLengthMeasure unitCode="{unitCode}">{BoatLengthMeasure}</BoatLengthMeasure>
                                </BoatLengthGroup>
                            </SalesLeadBoat>
                        </SalesLeadBoatLineItem>
                    </SalesLeadMarineLineItem>
                </SalesLeadLineItem>
            </SalesLeadDetail>
        </SalesLead>
    </ProcessSalesLeadDataArea>
</ProcessSalesLead>
XML_BODY;

    /**
     *
     * @param $debug bool send request to testing environment
     * @param $values values to build the XML with (default false)
     */
    public function __construct($values, $debug = false){
        $values['{systemEnvironmentCode}'] = ( $debug ? "Test" : "Production");
        $this->_data = $values;
        $this->_debug = $debug;
    }

    public function prepare()
    {
        $this->_request_body = str_replace(
            array_keys($this->_data),
            array_values($this->_data),
            $this->_xml
        );
    }

    /**
     * Submit request
     * 
     * @return bool True if submission was successful. False otherwise
     */
    public function send_request () {
        $url = $this->_debug ? Bm_API::$_qa_url : Bm_API::$_prod_url;
        // $url = "http://crmapp01.qa.boats.local:8088/boatsmonitor/test/mates-acceptor.html";
        $credentials = Bm_API::$_username . ':' . Bm_API::$_password;
        $curl_session = curl_init();

        // set URL
        curl_setopt_array(
            $curl_session,
            array(

                // Set content type
                CURLOPT_HTTPHEADER, array(
                    $this->_content_type
                ),

                // set URL
                CURLOPT_URL => $url,

                // fail verbosely if the HTTP code returned
                // is greater than or equal to 400
                CURLOPT_FAILONERROR => TRUE,

                // will follow as many "Location: "
                // headers that it is sent
                CURLOPT_FOLLOWLOCATION => TRUE,

                // return response as opposed to
                // echoing it
                CURLOPT_RETURNTRANSFER => TRUE,

                // set timeout of "x" seconds
                CURLOPT_TIMEOUT => 30,

                // output verbose information
                CURLOPT_VERBOSE => true,

                // set authentication method to use
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,

                // define username and password
                CURLOPT_USERPWD => $credentials,

                // set the request method to post
                CURLOPT_POST => true,

                CURLOPT_POSTFIELDS => http_build_query(
                    array(
                        "matesXml" => $this->_request_body
                    )
                ),
            )
        );

        $response = curl_exec($curl_session);;
        $curl_errno = curl_errno($curl_session);
        $curl_error = curl_error($curl_session);
        $curl_info = curl_getinfo($curl_session);

        curl_close($curl_session);

        $this->_last_response = array(
            "data" => $this->_data,
            "request" => $this->_request_body,
            "status" => $curl_info["http_code"],
            "successful" => (bool)$response and $curl_info["http_code"] == 200,
            "url" => $url,
            "response" => ((bool)$response?$response:''),
            "curl_errno" => $curl_errno,
            "curl_error" => $curl_error
        );
        
        return $this->isSuccessfull();
    }

    /**
     * PHP XML doesn't seem to handle elements with colon well.
     * 
     * @return bool True if submission was successful. False otherwise
     */
    public function isSuccessfull () {
        return (bool)strpos(
            $this->_last_response['response'],
            "DocumentId ".$this->_last_response['data']['{DocumentID}']." received at "
        );
    }

    /***********
     * GETTERS *
     ***********/
    
    /**
     * Get request body
     *
     * @return string Valid xml format
     */
    public function getRequestBody() {
        return $this->_request_body;
    }

    /**
     * Get content type header
     *
     * @return string content type header to send
     */
    public function getContentType() {
        return $this->_content_type;
    }

    /************************************
     * OVERLOADED BASE MEMBER FUNCTIONS *
     ************************************/

    /**
     * Overload string convertion operator
     *
     */
    public function __tostring () {
        return $this->_request_body;
    }
    
}
