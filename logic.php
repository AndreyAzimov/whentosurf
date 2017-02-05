<?php


// _________________________________________________________________________
//                          COOKIE AND MINI OTHER SHIT

$latitude = "";
$longitude = "";
$location = "";
$city_name_z = "";
$street = "";



 if ($_GET['city'] != "") {

  $city_name_z = $_GET['city'];
  
  $location_print = ucwords(str_replace('-',' ',$_GET['city']));

  $url_3 ='https://maps.googleapis.com/maps/api/geocode/json?address=' . $location_print . '&key=' . $key_google_dev;
  $json_3 = file_get_contents($url_3);

  $data_3 = json_decode($json_3);


  //$city = $data_2->results[0]->address_components[4]->short_name;


  $latitude= $data_3->results[0]->geometry->location->lat;
  $longitude = $data_3->results[0]->geometry->location->lng;

  $location = $latitude . "," . $longitude;
  //$location_print = ucwords(str_replace('-',' ',$_GET['city']));


}

//echo basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

else {

  $latitude = $_COOKIE["latitude"];
  $longitude = $_COOKIE["longitude"];



  $location = $latitude . "," . $longitude;

  //$location = "52.372433,4.893801";

  $key_google_dev = "AIzaSyDLyA12LK1g5WQmpHm63LHd0tepWGpOERc";

  $url_2 ='https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $location . '&key=' . $key_google_dev;

  $json_2 = file_get_contents($url_2);

  $data_2 = json_decode($json_2);

  $street = $data_2->results[0]->address_components[1]->short_name;
  $city = $data_2->results[0]->address_components[4]->short_name;

  //$city = "Kyiv"

  $location_print = $street . ", " . $city;

  $lat = $data_2->results[0]->geometry->location->lat;
  $lng = $data_2->results[0]->geometry->location->lng;

  $location = $lat . "," . $lng;


  //$redirect_url = "https://whentosurf.co/?city=" . $city; // PRODUCTIOD

   $redirect_url = "http://localhost:8888/?city=" . $city; // TEST


  if (isset($city)) {
    echo "<p>Success!!!</p>";
        header('Location: ' . $redirect_url);
       die();  
    exit;
  } else {
    echo "<p>Can't get your location. Please enanable it in the browser settings</p>";
  }

  

}

if ($location == "," ) {
  $location_print = "Can't get your location :(";
}


$responseStyle = 'short'; // the length of the response
$citySize = 'cities15000'; // the minimal number of citizens a city must have
$radius = 30; // the radius in KM
$maxRows = 5; // the maximum number of rows to retrieve
$username = 'whentos'; // the username of your GeoNames account

// get nearby cities based on range as array from The GeoNames API

$url = 'http://api.geonames.org/findNearbyPlaceNameJSON?lat='.$latitude.'&lng='.$longitude.'&style='.$responseStyle.'&cities='.$citySize.'&radius='.$radius.'&maxRows='.$maxRows.'&username='. $username;

$nearbyCities = json_decode(file_get_contents($url, true));

$geonames = $nearbyCities->geonames;

$nearest_cities = [];

foreach($geonames as $geoname)
{
    $city_name = $geoname->name;
    array_push($nearest_cities,$city_name);

}


//echo $url;



$google_maps_link = "https://www.google.com/maps/place/" . $location;

date_default_timezone_set('Asia/Singapore');
$tomorrow = new DateTime('tomorrow');

$tomorrow_for_json = $tomorrow->format('Y-m-d');
$tomorrow_formated = $tomorrow->format('l, F jS');





// _________________________________________________________________________
//                             GET DATA FROM API AND DECODE JSON

// GET WEATHER INFO

//$key_world_weather = "add8f9d830d34b52ac3181839170102";
$key_world_weather = "7492d7b146cb429887f204111170202";

$apiUrl='http://api.worldweatheronline.com/premium/v1/marine.ashx?key=' . $key_world_weather . '&q=' . $location .'&format=json&tide=yes&tp=1&date='. $tomorrow_for_json;







//------------ MR CACHE!

$cacheFileName=__DIR__.'/cache/'. $city_name_z . '.json'; //md5($city)
  
  if(@filemtime($cacheFileName) > strtotime("-12 hours")) {
    // cache exists, use that!
    $apiData=file_get_contents($cacheFileName);
    
    // echo '<hr>';
    // echo 'READ FROM CACHE: ' . $cacheFileName;
    // echo '<hr>';
  }
  else {
    // cache does not exist, open page and save
    $apiData=file_get_contents($apiUrl);
    file_put_contents($cacheFileName,$apiData);

    // echo '<hr>';
    // echo 'CACHED TO:' . $cacheFileName;
    // echo '<hr>';
  }

$data = json_decode($apiData);






// _________________________________________________________________________
//            PUT DATA TO FUCKING ARRAYS WITH 23 ELEMENTS (0 - 23 HOURS)

// SUNRISE & SUNSET
$sunrise = $data->data->weather[0]->astronomy[0]->sunrise;
$sunset = $data->data->weather[0]->astronomy[0]->sunset;

$sunrise_h = date("G", strtotime($sunrise));
$sunset_h = date("G", strtotime($sunset));

$sunrise = date("G:i", strtotime($sunrise));
$sunset = date("G:i", strtotime($sunset));

// FROM HOUR TO HOUR

$from = $sunrise_h ;
$to = $sunset_h - 1;

// HOURS ARRAY

$hours = [];

for ($i = $from ; $i <= $to; $i++) {
  $hours[$i] = "$i" . ":00";
}

// TEMPERATURE

$temperatures = [];

for ($i=$from; $i < $to ; $i++) { 
  $temp = $data->data->weather[0]->hourly[$i]->tempC;
  $temperatures[$i] =  $temp;
}

// WAVE HEIGHTS ARRAY

$wave_heights = [];

for ($i = $from ; $i <= $to; $i++) {
  $wave_height = $data->data->weather[0]->hourly[$i]->sigHeight_m;
  $wave_heights[$i] = $wave_height;
}

// SWELL PERIOD ARRAY

$swell_periods = [];

for ($i = $from ; $i <= $to; $i++) {
  $swell_period = $data->data->weather[0]->hourly[$i]->swellPeriod_secs;
  $swell_periods[$i] = $swell_period;
}

// SWELL DIRECTION ARRAY

$swell_directions = [];

for ($i = $from ; $i <= $to; $i++) {
  $swell_direction = $data->data->weather[0]->hourly[$i]->swellDir;
  $swell_directions[$i] = $swell_direction;
}

// WIND DIRECTION ARRAY

$wind_directions = [];

for ($i = $from ; $i <= $to; $i++) {
  $wind_direction = $data->data->weather[0]->hourly[$i]->winddirDegree;
  $wind_directions[$i] = $wind_direction;
}

// WIND SPEED ARRAY

$wind_speeds = [];

for ($i = $from ; $i <= $to; $i++) {
  $wind_speed = $data->data->weather[0]->hourly[$i]->windspeedKmph;
  $wind_speeds[$i] = $wind_speed;
}

// TIDE TYPE ARRAY

$tide_types = [];

for ($i = 0; $i <= 3; $i++) {
  $tide_type = $data->data->weather[0]->tides[0]->tide_data[$i]->tide_type;
  $tide_types[$i] = $tide_type;
}

// TIDE TIME ARRAY

$tide_times = [];
$tide_times_h = [];

for ($i = 0; $i <= 3; $i++) {
  $tide_time = $data->data->weather[0]->tides[0]->tide_data[$i]->tideTime;

    $tide_time_formated = date("G:i", strtotime($tide_time)); //
    $tide_time_formated_h = date("G", strtotime($tide_time)); // "G" for only hour
    $tide_time_formated_m = date("i", strtotime($tide_time)); //

    $tide_times[$i] = $tide_time_formated;
    $tide_times_h[$i] = $tide_time_formated_h;
  }

// TIDE HIGHT ARRAY

  $tide_hights = [];

  for ($i = 0; $i <= 3; $i++) {
    $tide_hight = $data->data->weather[0]->tides[0]->tide_data[$i]->tideHeight_mt;
    $tide_hights[$i] = $tide_hight;
  }


// TIDE TYPE BY HOURS


  $tide_types_hours = [];


  for ($i = $from; $i < $tide_times_h[1]; $i++) {
    $tide_types_hours[$i] = $tide_types[0];
  }

  for ($i = $tide_times_h[1]; $i < $tide_times_h[2]; $i++) {
    $tide_types_hours[$i] = $tide_types[1];
  }

  for ($i = $tide_times_h[2]; $i < $tide_times_h[3]; $i++) {
    $tide_types_hours[$i] = $tide_types[2];
  }

  for ($i = $tide_times_h[3]; $i <= $to; $i++) {
    $tide_types_hours[$i] = $tide_types[3];
  }




// _________________________________________________________________________
//                      RATING CALCULATION SHIT


// SWELL AND WIND DIRECTION RATING

  $swell_wind_dir_ratings = [];
  $sw_formula = 0;
  $sw_rating = 0;

  for ($i = $from; $i <= $to; $i++) {

    $sw_formula = 180 - abs(abs($wind_directions[$i] - $swell_directions[$i]) - 180);
    $sw_rating = round(5 - $sw_formula / 180 * 5, 2);

    $swell_wind_dir_ratings[$i] = $sw_rating;

  }


// TIDE RATING

  $tide_rating = [];

  for ($i=$from ; $i <= $to; $i++) { 
    $tide_rating[$i] = 0;
  }

  for ($i=0; $i <= 3; $i++) { 
    if ($tide_types[$i] == "HIGH") {
      $tide_rating[$tide_times_h[$i]] = 4;
    }
  }

// WAVE HIGHT RATING

  $waves_height_rating = [];

  for ($i=$from; $i <= $to ; $i++) { 

    if ($wave_heights[$i] < 0.5) {
      $waves_height_rating[$i] = 0;
    }

    if ($wave_heights[$i] >= 0.5 && $wave_heights[$i] < 1) {
      $waves_height_rating[$i] = 2;
    }

    if ($wave_heights[$i] >= 1 && $wave_heights[$i] < 1.5) {
      $waves_height_rating[$i] = 3;
    }

    if ($wave_heights[$i] >= 1.5) {
      $waves_height_rating[$i] = 4;
    }

  }




// TOTAL RATING

  $total_rating = [];


  for ($i=$from ; $i <= $to ; $i++) {  

    $total_rating[$i] = round((3 * $tide_rating[$i] + 4 * $waves_height_rating[$i] + 1 * $swell_wind_dir_ratings[$i]) / 10, 2);
  }

  function doublemax($mylist){
    $maxvalue=max($mylist);
    while(list($key,$value)=each($mylist)){
      if($value==$maxvalue)$maxindex=$key;
    }
    return array("max"=>$maxvalue,"index"=>$maxindex);
  }

  $supermax = doublemax($total_rating);

// FRONT PAGE DATA


  $best_time = $supermax[index];


  $best_rating = $supermax[max];
  $best_waves = $wave_heights[$best_time];
  $best_wind_speed = $wind_speeds[$best_time];
  $best_wind_direction = $wind_directions[$best_time];
  $best_temperature = $temperatures[$best_time];

  $levels = "";

  if ($best_waves < 0.5) {
    $levels = "Small waves today";
  }

  if ($best_waves >= 0.5 && $best_waves < 1.5) {
    $levels = "Good for beginners";
  }

  if ($best_waves >= 1.5) {
    $levels = "For pro";
  }


  $best_rating_stars = "";

  for ($i=0; $i < round($best_rating, 1) ; $i++) { 
    $best_rating_stars = $best_rating_stars . "&#9733;";
  }



  ?> 