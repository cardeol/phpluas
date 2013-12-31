phpluas
=======

Public PHP Tram API for Dublim Luas Trams.

##usage

Method <b>getStations( <a href="#parameters">$params</a> (optional))</b>
  

Method <b>getStationsInfo( <b>$stationcode<b>, <a href="#parameters">$params</a> (optional))</b>
  
##parameters
<ul>
  <li><b>format</b>: Create an specific format for the information. Accepted values are "array", "xml", "json" or "jsonp".</li>
  <li><b>return</b>: If you would like to capture the output data use the return parameter. When this parameter is set to TRUE, it will return the information rather than print it. (false as default)</li>
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
  
  // get Stations in json format
  $stations = $luas->getStations( array( "format" => "json", "return" => true ) );
  
  
  
?&gt;
</code>
</pre>

