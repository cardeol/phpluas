phpluas
=======

Public PHP Tram API for Dublim Luas Trams. It is a proxy implementation to create endpoints and reduce the original schema provided by the Luas API.

##usage

Method <b>getStations( <a href="#parameters">$params</a> (optional))</b><br>
  <b>Parameters:</b><br>
    <ul>
      <li><b>line:</b> ["G" for Green line, "R" for Red Line]</li>
    </ul>

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
  include("class.luasapi.php");
  $luas = new LuasApi();
  
  <b>// get all Stations as array in json (default)
  $stations = $luas->getStations();</b>
  
    // Response:
    [{"name":"St. Stephen's Green","line":"G","cycle":0,"car":0,"lat":53.339072,"lon":-6.261333}, ...]
  
  
  <b>// Get all Stations of the Red Line
  $stations = $luas->getStations( array( "line" => "R" ));</b>
  
    // Response:
    // [{"name":"The Point","line":"R","cycle":0,"car":0,"lat":53.34835,"lon":-6.229258}, ... ]
    
  <b>// Output Times of Busaras station (inbound) with destination "The Point" (abv "tpt") in json.
  $forecast = $luas->getForecast('bus', array("dir" => "in", "dest" => "tpt", "format" => "json"));</b>
  
    // Response:
    // <b>[{"dir":"in","due":4,"dest":"The Point","eta":"03:07"},{"dir":"in","due":18,"dest":"The Point","eta":"03:21"}]</b>
  
  
  <b>// get Times of Busaras station with destination "The Point" in xml.
  $luas->getForecast('bus', array("dir" => "in", "dest" => "The Point", "format" => "xml", "return" => false));</b>
    
    // Response:
    &lt;?xml version=&quot;1.0&quot;?&gt; 
    &lt;trams&gt; 
        &lt;tram dir=&quot;in&quot; due=&quot;1&quot; dest=&quot;The Point&quot; eta=&quot;03:07&quot;/&gt; 
        &lt;tram dir=&quot;in&quot; due=&quot;15&quot; dest=&quot;The Point&quot; eta=&quot;03:21&quot;/&gt;
    &lt;/trams&gt;

  
  <b>// output forecast of busaras station in json with padding
  $luas->getForecast('bus', array( "format" => "json" ));</b>
  
    // Response:
    // [{"dir":"in","due":0,"dest":"No trams forecast","eta":"03:13"},{"dir":"out","due":1,"dest":"Saggart","eta":"03:14"},{"dir":"out","due":8,"dest":"Saggart","eta":"03:21"}]
  
  
?&gt;
</code>
</pre>

