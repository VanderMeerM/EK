
<?php 

$curl_event = curl_init();

global $matchId;

curl_setopt_array($curl_event, array(
  CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures/events?fixture=' . $matchId, 
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

$response_event = curl_exec($curl_event);

curl_close($curl_event);

$response_event = json_decode($response_event, true);

echo $response_event;

?>