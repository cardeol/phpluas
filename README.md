phpluas
=======

Public PHP Tram API for Dublim Luas Trams.

##usage

Method <b>getStations( <a href="#parameters">$params</a> (optional))</b>
  

Method <b>getStationsInfo( <b>$stationcode<b>, <a href="#parameters">$params</a> (optional))</b>
  
##parameters
<ul>
  <li><b>format</b>: Create an specific format for the information. Accepted values are "array", "xml", "json" (default) or "jsonp".</li>
  <li><b>return</b>: If you would like to capture the output data use the return parameter. When this parameter is set to TRUE, it will return the information rather than print it. (true by default)</li>
  <li><b>dir</b>: used as filter for Inbound or Outbound trams. Accepted values are "in" or "out".</li>
  <li><b>dest</b>: set this parameter to filter destination by Name. I.E.  "dest" => "The Point"</li>
  <li>Any key value could be used to filter output data</li>
</ul>


##Examples

<pre>
<code>
&lt;?php
  #include "";
  $luas = new LuasApi();
  
  // get all Stations as array
  $stations = $luas->getStations();
  
  
  // Output Times of Busaras station (inbound) with destination "The Point" (abv "tpt") in json.
  $luas->getForecast('bus', array("dir" => "in", "dest" => "tpt", "format" => "json"));
  // Response:
  // <b>[{"dir":"in","due":4,"dest":"The Point","eta":"03:07"},{"dir":"in","due":18,"dest":"The Point","eta":"03:21"}]</b>
  
  
  // get Times of Busaras station with destination "The Point" in xml.
  $forecast = $luas->getForecast('bus', array("dir" => "in", "dest" => "The Point", "format" => "xml", "return" => false));
  
  // output forecast of busaras station in json with padding
  $luas->getForecast('bus', array( "format" => "jsonp" ));
  
?&gt;
</code>
</pre>

