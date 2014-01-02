<?php
	
    
class LuasApi {

	private $stations;
	private $data_url;
	
	function __construct() {		
		date_default_timezone_set ( "Europe/Dublin" );		
		$this->data_url = 'http://luasforecasts.rpa.ie/xml/get.ashx?encrypt=false&action=forecast&stop={stationcode}';
		$stations = <<<EEE
{"sts":{"nam":"St. Stephen's Green","lin":"G","lat":53.339072,"lon":-6.261333},"har":{"nam":"Harcourt Street","lin":"G","lat":53.333358,"lon":-6.26265},"cha":{"nam":"Charlemont","lin":"G","lat":53.330669,"lon":-6.258683},"ran":{"nam":"Ranelagh","lin":"G","lat":53.326433,"lon":-6.256203},"bee":{"nam":"Beechwood","lin":"G","lat":53.320822,"lon":-6.254653},"cow":{"nam":"Cowper","lin":"G","lat":53.316467,"lon":-6.253447},"mil":{"nam":"Milltown","lin":"G","lat":53.309917,"lon":-6.251728},"win":{"nam":"Windy Arbour","lin":"G","lat":53.301558,"lon":-6.250708},"dun":{"nam":"Dundrum","lin":"G","lat":53.292358,"lon":-6.245117},"bal":{"nam":"Balally","lin":"G","lat":53.286106,"lon":-6.236772},"kil":{"nam":"Kilmacud","lin":"G","lat":53.283008,"lon":-6.223886},"sti":{"nam":"Stillorgan","lin":"G","lat":53.279311,"lon":-6.209919},"san":{"nam":"Sandyford","lin":"G","lat":53.279311,"lon":-6.204678},"cpk":{"nam":"Central Park","lin":"G","lat":53.27015,"lon":-6.203764},"gle":{"nam":"Glencairn","lin":"G","lat":53.266336,"lon":-6.209942},"gal":{"nam":"The Gallops","lin":"G","lat":53.261164,"lon":-6.206022},"leo":{"nam":"Leopardstown Valley","lin":"G","lat":53.257996,"lon":-6.197485},"baw":{"nam":"Ballyogan Wood","lin":"G","lat":53.255047,"lon":-6.184475},"cck":{"nam":"Carrickmines","lin":"G","lat":53.254033,"lon":-6.169908},"lau":{"nam":"Laughanstown","lin":"G","lat":53.250606,"lon":-6.155006},"che":{"nam":"Cherrywood","lin":"G","lat":53.245333,"lon":-6.145853},"bri":{"nam":"Brides Glen","lin":"G","lat":53.242075,"lon":-6.142886},"tpt":{"nam":"The Point","lin":"R","lat":53.34835,"lon":-6.229258},"sdk":{"nam":"Spencer Dock","lin":"R","lat":53.348822,"lon":-6.237147},"mys":{"nam":"Mayor Square (NCI)","lin":"R","lat":53.349247,"lon":-6.243394},"gdk":{"nam":"George's Dock","lin":"R","lat":53.349528,"lon":-6.247575},"con":{"nam":"Connolly","lin":"R","lat":53.350922,"lon":-6.249942},"bus":{"nam":"Bus \u00c1ras","lin":"R","lat":53.348589,"lon":-6.258172},"abb":{"nam":"Abbey Street","lin":"R","lat":53.348589,"lon":-6.258172},"jer":{"nam":"Jervis","lin":"R","lat":53.347686,"lon":-6.265333},"fou":{"nam":"The Four Courts","lin":"R","lat":53.346864,"lon":-6.273436},"smi":{"nam":"Smithfield","lin":"R","lat":53.347133,"lon":-6.277728},"mus":{"nam":"Museum","lin":"R","lat":53.347867,"lon":-6.286714},"heu":{"nam":"Heuston","lin":"R","lat":53.346647,"lon":-6.291808},"jam":{"nam":"James'","lin":"R","lat":53.341942,"lon":-6.293361},"fat":{"nam":"Fatima","lin":"R","lat":53.338439,"lon":-6.292547},"ria":{"nam":"Rialto","lin":"R","lat":53.337908,"lon":-6.297242},"sui":{"nam":"Suir Road","lin":"R","lat":53.336617,"lon":-6.307211},"gol":{"nam":"Goldenbridge","lin":"R","lat":53.335892,"lon":-6.313569},"dri":{"nam":"Drimnagh","lin":"R","lat":53.335361,"lon":-6.318161},"bla":{"nam":"Blackhorse","lin":"R","lat":53.334258,"lon":-6.327394},"blu":{"nam":"Bluebell","lin":"R","lat":53.329297,"lon":-6.33396},"kyl":{"nam":"Kylemore","lin":"R","lat":53.326656,"lon":-6.343444},"red":{"nam":"Red Cow","lin":"R","lat":53.316833,"lon":-6.369872},"kin":{"nam":"Kingswood","lin":"R","lat":53.303694,"lon":-6.36525},"bel":{"nam":"Belgard","lin":"R","lat":53.299286,"lon":-6.374886},"coo":{"nam":"Cookstown","lin":"R","lat":53.293506,"lon":-6.384397},"hos":{"nam":"Hospital","lin":"R","lat":53.289369,"lon":-6.37885},"tal":{"nam":"Tallaght","lin":"R","lat":53.287494,"lon":-6.374589},"fet":{"nam":"Fettercairn","lin":"R","lat":53.293519,"lon":-6.395554},"cvn":{"nam":"Cheeverstown","lin":"R","lat":53.290982,"lon":-6.406849},"cit":{"nam":"Citywest Campus","lin":"R","lat":53.287833,"lon":-6.418915},"for":{"nam":"Fortunestown","lin":"R","lat":53.284251,"lon":-6.424602},"sag":{"nam":"Saggart","lin":"R","lat":53.284679,"lon":-6.43776255}}
EEE;
	$this->stations = json_decode($stations,true);
	}

	

	private function filter_data($data, $key, $value) {
		$fcast = array();
		if($key=="dest" && strlen($value) == 3) {
			if(isset($this->stations[strtolower($value)])) {
				$st = $this->stations[strtolower($value)];
				$value = $st['name'];
			}
		}
		foreach($data as $i => $journey) {
			if(isset($journey[$key]) && strtolower($journey[$key])!=strtolower($value)) continue;
			$fcast[] = $journey;
		}
		return $fcast;
	}

	private function OuputData($data, $params = null) {
		$params = ($params==null)?array():$params;
        $format = isset($params['format'])?$params['format']:"json";
        $return = isset($params['return'])?$params['return']:true;
        if(isset($params['format'])) unset($params['format']);
        foreach($params as $k => $v) $data = $this->filter_data($data,$k,$v);

        $type = "application/json";
        switch($format) {
                case "xml":
                    if(!$return) $type = "text/xml";        
                    $isstation = isset($data['con']);                            
                    $child = $isstation ? "station"  : "tram";
                    $xml = new SimpleXMLElement("<${child}s />");	
                	foreach($data as $abv => $stationinfo) {
                		$station = $xml->addChild($child);
                		if($isstation) $station->addAttribute("code",$abv);
                		foreach($stationinfo as $k => $v) {
                			$station->addAttribute($k,$v);	
                		}
                	}
                    $data = $xml->asXML();
                    break;
                case "jsonp":
                    $callback = isset($_GET['callback'])?$_GET['callback']:"";
                    $data = $callback."(".json_encode($data).")";                            
                    break;
                case "json":
                    $data = json_encode($data);   
                    break;                     
                case "array":
                default:
                	$return = true;
                	   
        }
        if(!$return) {
	        header("Content-type: ".$type);
	        echo($data);
	        return true;
        }
        return $data;            
    }

	private function get_url($url) {
	   $ch = curl_init();
	    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
	    $data = curl_exec($ch);
	    curl_close($ch);
	    return $data;
    	}

	public function getStations($params = null) {
		return $this->OuputData($this->stations,$params);		
	}

    public function getForecast($stationcode, $params = null) {
    	$url = str_replace("{stationcode}",$stationcode,$this->data_url);
    	$req = $this->get_url($url);    	
    	$xml = simplexml_load_string($req);
    	$forecast = array();
    	$now = time();
    	foreach ($xml->direction as $journey) {
    		$jattrib = $journey->attributes();
    		$direction = ((string) $jattrib['name'])=="Inbound"?"in":"out";    		
    		foreach($journey->tram as $xmltram) {
    			$tram = array();
    			$attrTram = $xmltram->attributes();
    			$due = (int) $attrTram['dueMins'];
    			$tram = array(
    				"dir" => $direction,
    				"due" => $due,
    				"dest" => (string) $attrTram['destination'],
    				"eta" => date("h:i",$now + ($due*60))
    			);    			
    			$forecast[] = $tram;
    		}
    	}    	
    	return $this->OuputData($forecast,$params);
    }

    public function getStationInfo($stationcode,$params = null) {
    	$data = array();
    	$code = strtolower($stationcode);
    	if(isset($this->stations[$code])) $data = $this->stations[$code];
    	return $this->OuputData($data,$params);
    }
}
