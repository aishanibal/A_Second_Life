
<?php
/*  Use google geolocator api to get the latitude and longitude 
*/
function getGeoCode($address)
{ 
    try{
    // geocoding api url
    $url = "https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyC0vzFpV1tYDYo5cE0RNXO1MxbcPMlf8cQ"; 
    //echo $url;
    $data = array(
    "lat" => "",
    "lng" => "",
    );
    // send api request
    $geocode = file_get_contents($url);
    $json = json_decode($geocode);
    //echo 'json: ' . $json.to;
    $data['lat'] = $json->results[0]->geometry->location->lat;
    $data['lng'] = $json->results[0]->geometry->location->lng;
    }
    catch(exception $e) {
        echo 'function fail';
    echo 'lat'.  $data['lat'] ;
    echo 'lang'.  $data['lng'] ;
    }
    return $data;
}



