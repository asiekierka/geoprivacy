<?php
  header("Content-type: application/json");
  if(!function_exists('geoip_country_code_by_name') || strlen($_GET["country"])==2) $country = $_GET["country"];
  else $country = geoip_country_code_by_name($_SERVER["REMOTE_ADDR"]);
  $eu_countries = array("AT","BE","BG","CY","CZ","DE","DK","EE","ES","FI","FR","GB","GR",
                     "HU","IE","IT","LT","LU","LV","MT","NL","PL","PT","RO",
                     "SI","SK","SE");
  if(strlen($country)!=2) {
    print("{ error: 'Invalid country name!' }"); // Did you install GeoIP or specify ?country=?
    return;
  }
  // Cookie law state:
  // 2 - Ask To Allow (button mandatory, opt-in/opt-out type determined by other variable)
  // 1 - Information, no button mandatory
  // 0 - No need to confirm
  // + opt_out - user must opt-out and not opt-in
  // + session_allowed - non-intrusive cookies allowed
  // + detailed - information about cookies has to be detailed
  // Unsure about: Belgium, Denmark (opt-out with caution!), Germany (unclear, but german sites DGAF), Italy?, Malta
  // , Portugal
  $country_2 = array("AT","CY","FR","GR","IT","LT","LV","LU","NL","PT","ES","SE");
  $country_1 = array("CZ","DK","EE","FI","PL","BE","BG","HU","IE","PL","SK","MT","RO");
  $country_0 = array("DE","MT","SI");
  $country_di = array("BE","BG","FR","HU","PL","RO","SK");
  $country_oo = array("CZ","EE","FI","IT");
  $country_sa = array("BE","DE","IT","NL","PL");
  $country_val = 2;
  if(!in_array($country,$eu_countries)) $country_val = 0;
  else {
    if(in_array($country,$country_1)) $country_val = 1;
    if(in_array($country,$country_0)) $country_val = 0;
  }
  print("{ 'country': '".$country."', 'mode': ".$country_val.", ");
  print("'detailed_information': ".(in_array($country,$country_di)?"true":"false").", ");
  print("'opt_out': ".(in_array($country,$country_oo)?"true":"false").", ");
  print("'session_allowed': ".(in_array($country,$country_sa)?"true":"false")." }");
?>
