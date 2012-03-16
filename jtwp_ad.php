		
<?php

// Switch them to JTWP if the request is from a handset
if(get_option('jtwp_reroute_iphone') == 'on' && preg_match('/(chrom|iphone)/i', $_SERVER['HTTP_USER_AGENT']))
{
	$reroute = (get_option('jtwp_reroute_iphone') == "on" || get_option('jtwp_reroute_android') == "on");
	if ($reroute)
		switch_theme('jtwptheme','jtwptheme');
}



function render_jumptap_ad()
{
	$reroute_iphone = get_option('jtwp_reroute_iphone');
	
	if ($reroute_iphone == "on")
	{
		$publisherAlias = get_option('jtwp_publisher_alias');
		$adSpotAlias = get_option('jtwp_adspot_alias');
		
		$request = new JumptapAdRequest();
		$request->setPublisherAlias($publisherAlias);
		$request->setAdSpotAlias($adSpotAlias);
		
		$manager = new JumptapAdManager();
		
		$html = $manager->requestAd($request)->getHtml();
		
		$display_iphone_position = get_option("jtwp_display_iphone_position");
		
		echo "<div id='adBox".ucwords($display_iphone_position)."'> $html </div>";
	}
	
}

class JumptapAdManager
{
	private $baseRequestUrl;

	public function __construct()
	{
		$this->baseRequestUrl = 'http://a-master.jumptap.com/a/ads';
	}
	
	public function setBaseRequestUrl($baseRequestUrl)
	{ $this->baseRequestUrl = $baseRequestUrl; }
	public function getBaseRequestUrl()
	{ return $this->baseRequestUrl; }

	private function constructRequestUrl($request)
	{
		$requestUrl = $this->getBaseRequestUrl() . "?";
		
		$requestUrl .= "format=xhtml";
		$requestUrl .= "&pub=" . $request->getPublisherAlias();
		$requestUrl .= "&spot=" . $request->getAdSpotAlias();
		foreach ($request->getTargetingParameters() as $key => $value)
		{
			$requestUrl .= "&$key=$value";
		}
		$refererUrl = "http://" . urlencode($_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]);
		$requestUrl .= "&url=$refererUrl";
		$requestUrl .= "&ua=iPhone";

		return $requestUrl;
	}

	public function requestAd($request)
	{
		$requestUrl = $this->constructRequestUrl($request);
		
		$receivedHeaders = array();
		foreach (getallheaders() as $key => $value)
		{
			if ($key != "Host")
				$receivedHeaders[] = "$key: $value";
		}
		//$receivedHeaders = array();
		
		if (!array_key_exists("X-Forwarded-For", $receivedHeaders))
		{
			$receivedHeaders[] = "X-Forwarded-For: " . $_SERVER['REMOTE_ADDR'];
		}
		
		$cUrlHandle = curl_init();
		curl_setopt($cUrlHandle, CURLOPT_URL, $requestUrl);
		curl_setopt($cUrlHandle, CURLOPT_HTTPHEADER, $receivedHeaders);
		curl_setopt($cUrlHandle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($cUrlHandle, CURLOPT_FOLLOWLOCATION, 1);
		
		$response = new JumptapAdResponse(curl_exec($cUrlHandle));
		
		return $response;
	}	
}

class JumptapAdRequest
{
	private $publisherAlias;
	private $adSpotAlias;
	private $targetingParameters = array();

	public function __construct()
	{
		$this->publisherAlias = null;
		$this->adSpotAlias = null;
		$this->targetingParameters = array();
	}

	function addTargetingParameter($key, $value)
	{
		if (isValidTargetingParameterKey($key))
		{
			$this->targetingParameters[$key] = $value;
		}
	}

	public function setPublisherAlias($publisherAlias)
	{ $this->publisherAlias = $publisherAlias; }
	public function getPublisherAlias()
	{ return $this->publisherAlias; }
	
	public function setAdSpotAlias($adSpotAlias)
	{ $this->adSpotAlias = $adSpotAlias; }
	public function getAdSpotAlias()
	{ return $this->adSpotAlias; }
	
	public function getTargetingParameters()
	{ return $this->targetingParameters; }
	
	private function isValidTargetingParameterKey($key)
	{
		switch ($name)
		{
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
				trigger_error("JumptapAdRequest: invalid publisher variable: ($name)", E_USER_WARNING);
				return false;
				break;
		}
	}

	public function isValid()
	{
		return
			$publisherAlias != null
			&& $adSpotAlias != null;
	}
}

class JumptapAdResponse
{
	private $html;
	
	public function __construct($html)
	{
		$this->html = $html;
	}
	
	public function render()
	{
		echo $this->html;
	}
	
	public function getHtml()
	{
		return $this->html;
	}
}
?>