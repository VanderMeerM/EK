<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EK-wedstrijden</title>   
    <link rel="stylesheet" type="text/css" href="./euro.css" />    
    <link rel="shortcut icon" href="https://www.api-football.com/public/img/favicon.ico">
</head>
<body>

<?php 

include('./translations.php');

$day = $_GET['date'];

if (!$_GET['date']) { 
  $day= date('Y-m-d');
}

$json_matches_path = './json/matches/matches_date_' . $day . '_.json'; 

if (!file_exists($json_matches_path)) { 

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures?season=2024&league=4&date='.$day,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'x-rapidapi-key: f7e1aa54fd70dd93a3c920f503282930',
    'x-rapidapi-host: v3.football.api-sports.io',
    
  ),
));


$response = curl_exec($curl);

curl_close($curl);

//$response = json_encode($response, true);

if ($day < date('Y-m-d', strtotime('today'))) {

$json_file_mt = fopen($json_matches_path, "w");

fwrite($json_file_mt, $response);

fclose($json_file_mt);
}

$response= json_decode($response, true);

}

else {
  $response_json = file_get_contents($json_matches_path, true);

  $response= json_decode($response_json, true);

}

$numGames= $response['results'];
$todaysmatches = 'Speelschema';
$today = 'Vandaag';
$yesterday = 'Gisteren';
$tomorrow = 'Morgen';

$prevent_loop = false;


$statusInPlay = array('1H', 'HT', '2H','ET', 'BT', 'P', 'SUSP', 'INT');

include('./header.php');

if ($numGames > 0 ) {

//for ($i= ($numGames-1); $i >=0 ; $i--) {
for ($i=0; $i < $numGames; $i++) {


  if (!$prevent_loop) {

  $homeTeam = $response['response'][$i]['teams']['home']['name'];
  $awayTeam = $response['response'][$i]['teams']['away']['name'];
  $matchId = $response['response'][$i]['fixture']['id'];

  if ((!$_GET['id']) || ($_GET['id'] && $_GET['id'] == $matchId)) {

  echo '
  <div class="main_container">'; 
  
  if (!$_GET['id']) {

    if (!$_GET['date']) {
      $_GET['date'] = date('Y-m-d', strtotime('today'));
    }

    echo '<a href="' . $_SERVER['PHP_SELF'] . '?date='. $_GET['date'] . '&id=' . $matchId . '">';
  }
  echo '
  <div class="country_container">
  <div class="flag_container">
  <img src="'.$response['response'][$i]['teams']['home']['logo'] . '"/></div>' . 
  (array_key_exists($homeTeam, $countries) ? $countries[$homeTeam] : $homeTeam) . 
  
         '</div>
          <div class="stscore_container">';
                     
         if ($_GET['id']) { echo $response['response'][$i]['fixture']['venue']['name'] . '<br>'; }

         if (!$_GET['id'])  { echo $response['response'][$i]['fixture']['venue']['city'] . '<br>'; }
         
         echo date('H:i', $response['response'][$i]['fixture']['timestamp'])  . '<br>';

         echo 
         '<div class=' . (in_array($response['response'][$i]['fixture']['status']['short'], $statusInPlay)? '"score red"' : "score") . '>' . 
         $response['response'][$i]['goals']['home'] . '-' . 
         $response['response'][$i]['goals']['away'];
          
         echo '<div style="font-size:15pt">'. (array_key_exists($response['response'][$i]['fixture']['status']['short'], $status)? 
           $status[$response['response'][$i]['fixture']['status']['short']] : null) . 
          '</div>
          </div>'; 
         

          if ($_GET['id']) { 
            echo '<p><div class="stscore_ref">
            <img id="ref" src="../ref.png">' . '<br> ' . explode(',', $response['response'][$i]['fixture']['referee'])[0] . 
           '<br>(' . (array_key_exists(explode(', ', $response['response'][$i]['fixture']['referee'])[1], $countries) ? 
           $countries[explode(', ', $response['response'][$i]['fixture']['referee'])[1]] : 
           explode(', ', $response['response'][$i]['fixture']['referee'])[1]) . ')
           <br></div>'; 
          
           }

          echo '</div>';
         
   echo '<div class="country_container">
   <div class="flag_container">
   <img src="'.$response['response'][$i]['teams']['away']['logo'] . '"/></div>' . 
   (array_key_exists($awayTeam, $countries) ? $countries[$awayTeam] : $awayTeam) . 
   
   '</div>
   </div>';
   if (!$_GET['id']) {
    echo '</a>';
   }

   if ($_GET['id']) {
   include ('./events.php');
   }      
 
  }
 }
  }}

else {
  $day = date_create($day);
echo '<div class="nomatches"> Geen wedstrijden op ' . date_format($day, 'd-m') . '</div>';
};


?>

</body>
</html>
