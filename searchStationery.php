<?php
/*
plugin name: Stationery Input Information
*/

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . '/wp-load.php');

function stationeryInputInformation()
{
 global $wpdb;  
     // geocoding api url
    $url = "https://maps.google.com/maps/api/geocode/json?address=Brooklyn,+NY,+USA&key=AIzaSyC0vzFpV1tYDYo5cE0RNXO1MxbcPMlf8cQ"; 
    //echo $url;
    // send api request
    $geocode = file_get_contents($url);
    $json = json_decode($geocode);
    //echo 'json: ' . $json.to;
    $data['lat'] = $json->results[0]->geometry->location->lat;
    $data['lng'] = $json->results[0]->geometry->location->lng;
    //echo 'lat'. $json->results[0]->geometry->location->lat;
?>

<!--Enter Search Criteria-->
<style>
    <meta name="viewport"content="width=device-width, initial-scale=1.0>
<?php include "CSS/searchBooks.css"?>
</style>
<!-- <h1> Enter Book Search Info</h1> -->
<br/>
<br/>
<center>
  <div class="container">
            <form action="https://asecondlife.me/wp-content/plugins/custom/stationerySearchResult.php" method="get">
                <div>
                <!-- <fieldset> -->
                
                   
                    <p>

                        <label for="stationeryType">Stationery Category:</label>
                        <select  name="stationeryType" id="category" required>
                            <option value="">Select Stationery Category </option>
                            <?php
                                $result = $wpdb->get_results("SELECT stationeryType FROM stationeryTypes");
                                foreach ($result as $row) {
                                $option = $row->stationeryType;
                                echo '<option value = ' . $option . '>' . $option . '</option>';
                               }
                               ?>
                        </select>
     
        </p>
        
        
        <!-- </fieldset> -->
        <input type="submit" id="submitBtn" name="submit" value="Submit" />
        </div>
</center>
</br>
</br>
</form>
 </div>


<?php
}/*function*/
add_shortcode('stationeryInputInformation', 'stationeryInputInformation');
?>