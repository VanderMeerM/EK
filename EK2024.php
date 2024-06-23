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


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures?season=2024&league=4&date='. $day,
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

$response = json_decode($response, true);

$numGames= $response['results'];
$todaysmatches = 'Speelschema';
$today = 'Vandaag';
$yesterday = 'Gisteren';
$tomorrow = 'Morgen';

$statusInPlay = array('1H', 'HT', '2H','ET', 'BT', 'P', 'SUSP', 'INT');

include('./header.php');

if ($numGames > 0) {

for ($i= ($numGames-1); $i >=0 ; $i--) {

  $homeTeam = $response['response'][$i]['teams']['home']['name'];
  $awayTeam = $response['response'][$i]['teams']['away']['name'];
  $matchId = $response['response'][$i]['fixture']['id'];

  if ((!$_GET['id']) || ($_GET['id'] && $_GET['id'] == $matchId)) {

  echo '
 
  <div class="main_container">  
  <a href="' . $_SERVER['PHP_SELF'] . '?date='. $_GET['date'] . '&id=' . $matchId . '">
  <div class="country_container">
  <div class="flag_container">
  <img src="'.$response['response'][$i]['teams']['home']['logo'] . '"/></div>' . 
  (array_key_exists($homeTeam, $countries) ? $countries[$homeTeam] : $homeTeam) . 
  
         '</div>
          <div class="stscore_container">';
               
         if ($_GET['id']) { echo $response['response'][$i]['fixture']['venue']['name'] . '<br>'; }

         echo $response['response'][$i]['fixture']['venue']['city'] . '<br>' .
          date('H:i', $response['response'][$i]['fixture']['timestamp'])  . '<br>' .  

          '<div class=' . (in_array($response['response'][$i]['fixture']['status']['short'], $statusInPlay)? '"score red"' : "score") . '>' . 
          $response['response'][$i]['goals']['home'] . '-' . 
          $response['response'][$i]['goals']['away'] . '<br>
           </div>'; 

          if ($_GET['id']) { 
            echo '<p><div class="stscore_container">
            Scheidsrechter: ' . $response['response'][$i]['fixture']['referee'] . '<br>'
           . (array_key_exists($response['response'][$i]['fixture']['status']['short'], $status)? 
           $status[$response['response'][$i]['fixture']['status']['short']] : null). '</div>'; 

          // include ('./events.php');       
           }

         /*
         if (in_array($response['response'][$i]['fixture']['status']['short'], $statusInPlay)) {
          echo $response['response'][$i]['fixture']['periods']['first'];
          };
          */
          echo '</div>
         
   <div class="country_container">
   <div class="flag_container">
   <img src="'.$response['response'][$i]['teams']['away']['logo'] . '"/></div>' . 
   (array_key_exists($awayTeam, $countries) ? $countries[$awayTeam] : $awayTeam) . 
   
   '</div>
   </div></a>';

    echo '<p>';
 
}
}
}
else {
  $day = date_create($day);
echo '<div class="nomatches"> Geen wedstrijden op ' . date_format($day, 'd-m') . '</div>';
};

?>

</body>
</html>
