		
<?php
// Jumptap Publisher Integration Code
// Language: PHP
// Version: 1.0.0
// Generation Date : 3/15/12 11:17 PM
// Copyright Jumptap Inc., All Rights Reserved
// Documentation at some jumptap URL

//Instructions:
//1.	Select the code to use on your site or in your application and copy/paste it into your source code.
//2.	Set the mandatory values in the code.
//3.	Set the optional values in the code - For example, you can set a different category for each content page of your site/application to receive more relevant ads.
//4.	Validate that your integration works
//5.	If you have any questions, Click Here https://support.jumptap.com/index.php/Publisher_integration_guide or send email to publishercustomerservice@jumptap.com

// 
// Notes:
// 1. This code will work on a web server running apache and PHP Version 4.0 or higher.
// 2. requestAd MUST be run before any output has been emitted, as it will try to set cookies

// Variables from Wordpress Plug-in UI
$publisherAlias = get_option('jtwp_publisher_alias');
//$siteAlias = get_option('jtwp_site_alias');
$spotAlias = get_option('jtwp_spot_alias');

$wpLibVer = get_plugin_data('jtwp.php')

echo $publisherAlias;
echo $wpLibVer;
exit();


// Jumptap Publisher Integration Test Code
error_reporting ( E_ALL );
ini_set ( "display_errors" , "1" ); 

// Add this section each time you want to add an ad to your page 
$adTap = new adTap();

// TapLink url
$adTap->setBaseRequestURL('http://a.jumptap.com/a/ads');

//Your Publisher Id as assigned by Jumptap. 
//To find your Publisher Id. Log into Publisher application system,click on the Administer Sites, and press Site Details  near the relevent site
$adTap->setPublisherAlias($publisherAlias);

//An Ad Spot Id assigned by Jumptap
//Add your ad spot alias from the list: pa_jumptap18_jtwp_mob_webbanner
$adTap->setAdSpot($spotAlias);

//A Site Id assigned by Jumptap. If this is not provided, the default site is used. 
//To find your Site Id .Log into Publisher application system,click on the Administer Sites, and press Site Details  near the relevent site
//$adTap->setPublisherVariable('site', $siteAlias);

//The IP Address of the device requesting the ad. 
//This is used by tapLink and our Ad Providers for Carrier/Gateway targeting
//$adTap->setPublisherVariable('client-ip', 'ADD YOUR VALUE HERE');

//	Postal code
//* If you are passing latitude/longitude, then the pc parameter should not be passed.
//* The value of this parameter must be encoded.
//* If postal code is included in the request, the country parameter is required.
//* Example: pc=02141&country=us 
//$adTap->setPublisherVariable('pc', 'ADD YOUR VALUE HERE');

//The two letter ISO country code of the originating users request. http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2.
//* Country should be passed only if the country of the user originating the ad request is definitively known; it should not be set for a static value for all of your requests.
//* If country is not included in the request, Jumptap will automatically determine the country based on the user or gateway IP.
//* The country parameter is required if the postal code (pc) parameter is passed.
//* If you are passing latitude/longitude, then the country parameter should not be passed.
//$adTap->setPublisherVariable('country', 'ADD YOUR VALUE HERE');

//Latitude/Longitude
//* Latitude and longitude must be comma-separated.
//* The value of this parameter must be encoded.
//* Example, ll=42.369%2C-71.075
//* Latitude/Longitude is preferred to and supersedes the postal code and country parameters. 
//$adTap->setPublisherVariable('ll', 'ADD YOUR VALUE HERE');

//The unique device hardware ID, if known.
//This is primarily for use by iPhone applications and corresponds to the device DeviceID
//$adTap->setPublisherVariable('hid', 'ADD YOUR VALUE HERE');

//The users age in years. Valid values include any integer from 1-199.
//$adTap->setPublisherVariable('mt-age', 'ADD YOUR VALUE HERE');

//The users gender. Valid values are m or f 
//$adTap->setPublisherVariable('mt-gender', 'ADD YOUR VALUE HERE');

//The users household income in thousands , if known.
	//Valid values include: 000_015, 015_020, 020_030, 030_040, 040-050, 050-075, 075-100, 100_125, 125_150 and 150_OVER.
//$adTap->setPublisherVariable('mt-hhi', 'ADD YOUR VALUE HERE');

//For publishers having on-deck instances of their sites, this parameter should be used to indicate the on-deck mobile operator.
//* This parameter should be passed only for on-deck instances for which the operator/carrier is definitively known.
//* For off-deck requests, Jumptap will determine the operator based on request header and gateway IP information.
//* See https://support.jumptap.com/index.php/Valid_Operators for a list of valid operators. 
//$adTap->setPublisherVariable('operator', 'ADD YOUR VALUE HERE');

//For search sites or applications, pass the search terms using the q ("query") parameter.
//* The value of this parameter should be encoded.  
//$adTap->setPublisherVariable('q', 'ADD YOUR VALUE HERE');

//Unique id of the end-user. tapLink uses this identifier for frequency capping.
//* Different mobile operators use different headers to pass user information, and as such, we strongly recommend that you forward the device's HTTP headers so that tapLink can determine which header contains the user ID.
//* Only in cases in which you cannot pass headers should you create your own algorithm to determine which header contains the user ID.
//* In the specific case in which you are unable to forward the device headers and you cannot create an algorithm to check for user ID within the various possible parameters and your site requires a login, you may pass the hashed login ID in the u parameter. Please note that the value that you pass in must be unique for each user, but should be consistent for each request from the same user.
//$adTap->setPublisherVariable('u', 'ADD YOUR VALUE HERE');

/////////////////////////////////
// Do not edit below this line //
/////////////////////////////////
$adTap->requestAd();
?>
<?php echo $adTap->getResponse(); ?>

<?php
class adTap {
  //var $headerMappings = array();
  var $publisherAlias; // required
  var $adSpot;
  var $response;
  var $publisherVariables = array();
  var $baseRequestURL;

  // *** initializer ***
  function adTap() {
  }

  function setPublisherVariable($key, $value) {
    if (validatePublisherVariable($key)) {
      $this->publisherVariables[$key] = $value;
    }
  }

  function setAdSpot($adSpot) {
    $this->adSpot = $adSpot;
  }
  
  function setBaseRequestURL($baseRequestURL) {
    $this->baseRequestURL = $baseRequestURL;
  }
  
   function setPublisherAlias($publisherAlias) {
    $this->publisherAlias = $publisherAlias;
  }
  
  function getTargetingParams(){
    $jtTargetingParams = '';
    foreach ($this->publisherVariables as $key => $value){
      $jtTargetingParams .= (!empty($value)) ? '&' . $key . '=' . $value : null;
    }
    return $jtTargetingParams;
  }

  function requestAd($adSpot = '') {
    // if no adSpot is supplied, use the one 
    // that was previously set
    if (!$adSpot) { $adSpot = $this->adSpot; }
    if (!$adSpot) { 
      // signal an error and do nothing
      trigger_error("adTap: No spot ID supplied", E_USER_WARNING);
      return;
    }
    $requestURL = $this->baseRequestURL . "?pub=" . $this->publisherAlias . "&spot=" . $adSpot;
    $targetingParams = $this->getTargetingParams();
	$pageURL = urlencode($_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
    $queryString =$targetingParams . '&url=http://' . $pageURL;
    $requestURL = $requestURL . $queryString;
    $this->response = $this->getURLWithTapLinkHeaders($requestURL);
    return $this->response;
  }

  function processXJTHeader($headerArray) {
    foreach ($headerArray as $header) {
            if (strpos($header, 'XJT-UserId: ') === 0) {
                    $xjt = substr($header, 12);
                    $expires = time()+(60*60*24*365);
                   setcookie('XJT-UserId', $xjt, $expires, "/");
            }
    }
  }

	function getURLWithTapLinkHeaders($reqUrl) {
	  // headers will be an associative array mapping header names onto
	  // values
	  $exclusions = array("HTTP_HOST", "HTTP_KEEP_ALIVE", "HTTP_CONNECTION", "HTTP_COOKIE", "HTTP_CACHE_CONTROL");
	  $httpHeader = "";
	  $gotXFF = false;
	  foreach ($_SERVER as $header => $value) {
		if (substr($header, 0, 4) == 'HTTP' && !(in_array($header, $exclusions)) && isset($value)) {
		  $rewrittenHeader = $this->rewriteHeader($header);
		  if ($rewrittenHeader == 'X-Forwarded-For'){
		$gotXFF = true;
		$value = $value . ',' . $_SERVER['REMOTE_ADDR'];
		  }
		  $httpHeader = $httpHeader . $rewrittenHeader . ": " . $value . "\r\n";
		}}
	  if (!$gotXFF) {
		// make sure that there is always an X-Forwarded-For header
		$httpHeader = $httpHeader . 'X-Forwarded-For' . ": " . $_SERVER['REMOTE_ADDR'] . "\r\n";
	  }
	
	  // if there is a XJT-UserId cookie supplied, make sure the cookie is
	  // passed to Jumptap as the appropriate header
	  $xjt_uid = isset($_COOKIE['XJT-UserId']) ? $_COOKIE['XJT-UserId'] : null;
	  if ($xjt_uid) {
		$httpHeader = $httpHeader . "XJT-UserId" . ": " . $xjt_uid . "\r\n";
	  }
	
	  $httpOpts = array("http" => array("header" => $httpHeader));
	  $context = stream_context_create($httpOpts);
	
	  $answer = file_get_contents($reqUrl, 'r', $context);
	  $this->processXJTHeader($http_response_header);
	  return $answer;
	}

	function rewriteHeader($headerString) {
		//global $headerMappings;
		$headerMappings = array();
		if (isset($headerMappings[$headerString])) return $headerMappings[$headerString];

		$header = substr($headerString, 5); // strip off HTTP_                                                                                             
		$words = explode("_", $header);
		$newWords = array();
		foreach ($words as $word) {
			$newWords[] = ucfirst(strtolower($word));
		}
			$mapping = implode("-", $newWords);
		$headerMappings[$headerString] = $mapping;
		return $mapping;
	}

  function getResponse() {
    return $this->response;
  }
}

function validateResponseFormat($format) {
  switch ($format) {
  case "xhtml":
  case "xml":
    return true;
    break;
  default:
    trigger_error("adTap: invalid response format: ($format)", E_USER_WARNING); 
    return false;
    break;
  }
}

function validatePublisherVariable($name) {
  switch ($name) {
  case "country":
  case "loc":
  case "mt-gender":
  case "mt-age":
  case "mt-ethnicity":
  case "mt-areacode":
  case "mt-hhi":
  case "mt-site_traffic_source":
  case "mt-sitecategory":
  case "mt-pagecategory":
  case "ll":
  case "l":
  case "c":
  case "p":
  case "operator":
  case "category":
  case "pc":
  case "hid":
  case "u":
  case "url":
  case "a":
  case "site":
    return true;
    break;
  default:
    trigger_error("adTap: invalid publisher variable: ($name)", E_USER_WARNING);
    return false;
    break;
  }
}
?>