
<?php

$json_events_path = './json/events/events_' . $_GET['id'] . '.json'; 

if (!file_exists($json_events_path)) { 

    $curl_event = curl_init();
    
    curl_setopt_array($curl_event, array(
      CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures/events?fixture=' . $_GET['id'], 
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
    
    //$num_events = $response_event['results'];
    
    $home_team_events = array();
    $away_team_events = array();
    
    $home_team_goals = array();
    $away_team_goals = array();
    
     for ($i = 0; $i < $num_events; $i++) {
          
        if (($response_event['response'][$i]['team']['name'] === $homeTeam) && 
            ($response_event['response'][$i]['type'] === 'Goal' || $response_event['response'][$i]['type'] === 'Card')) {
            array_push($home_team_events, [ $response_event['response'][$i]['type'], $response_event['response'][$i]['detail'],
            $response_event['response'][$i]['time']['elapsed'], $response_event['response'][$i]['player']['name']] );
        }
    
         if (($response_event['response'][$i]['team']['name'] === $awayTeam ) && 
            ($response_event['response'][$i]['type'] === 'Goal' || $response_event['response'][$i]['type'] === 'Card')) {
            array_push($away_team_events, [ $response_event['response'][$i]['type'], $response_event['response'][$i]['detail'],
            $response_event['response'][$i]['time']['elapsed'], $response_event['response'][$i]['player']['name']] );
        }
      }
    
    for ($i = 0; $i < sizeof($home_team_events); $i++) {
      if (($home_team_events[$i][0] === 'Goal') && ($home_team_events[$i][1] !== 'Missed Penalty')) {
        array_push($home_team_goals, $home_team_events[$i][1]);
      } 
    }
    
    for ($i = 0; $i < sizeof($away_team_events); $i++) {
      if (($away_team_events[$i][0] === 'Goal') && ($away_team_events[$i][1] !== 'Missed Penalty')) {
        array_push($away_team_goals, $away_team_events[$i][1]);
      } 
    }
    
if ( ($_GET['date'] < date('Y-m-d', strtotime('today')))) {

  $json_file_ev = fopen($json_events_path, "w");
  
  fwrite($json_file_ev, $response_event);
  
  fclose($json_file_ev);
  }
  
  $response_event = json_decode($response_event, true);
  
  }
  
  else {
    $response_json = file_get_contents($json_events_path, true);
  
    $response_event= json_decode($response_json, true);
  
  }

/*

$response_json = file_get_contents('./nlos.json', true);

$response_event= json_decode($response_json, true);

*/

$num_events = $response_event['results'];

$array_type = array('Goal' => '⚽', 'Yellow Card' => '🟨', 'Red Card' => '🟥');

$array_goal = array('Own Goal' => 'eigen goal', 'Penalty' => 'strafschop', 'Missed Penalty' => 'strafschop gemist');

$home_team_events = array();
$away_team_events = array();
$all_team_events = array();

$home_team_goals = array();
$away_team_goals = array();

 for ($i = 0; $i < $num_events; $i++) {
      
    if (($response_event['response'][$i]['team']['name'] === $homeTeam) && 
        ($response_event['response'][$i]['type'] === 'Goal' || $response_event['response'][$i]['type'] === 'Card')) {
        array_push($home_team_events, [ 'type' => $response_event['response'][$i]['type'], 'detail' => $response_event['response'][$i]['detail'],
        'elapsed' => $response_event['response'][$i]['time']['elapsed'], 'name' => $response_event['response'][$i]['player']['name']] );
    }

     if (($response_event['response'][$i]['team']['name'] === $awayTeam) && 
        ($response_event['response'][$i]['type'] === 'Goal' || $response_event['response'][$i]['type'] === 'Card')) {
        array_push($away_team_events, [ 'type' => $response_event['response'][$i]['type'], 'detail' => $response_event['response'][$i]['detail'],
        'elapsed' => $response_event['response'][$i]['time']['elapsed'], 'name' => $response_event['response'][$i]['player']['name']] );
    }
  }

  /*
    for ($i = 0; $i < sizeof($home_team_events); $i++) {
    if (($home_team_events[$i][0] === 'Goal') && ($home_team_events[$i][1] !== 'Missed Penalty')) {
      array_push($home_team_goals, $home_team_events[$i]['detail']);
    } 
  }

  for ($i = 0; $i < sizeof($away_team_events); $i++) {
    if (($away_team_events[$i][0] === 'Goal') && ($away_team_events[$i][1] !== 'Missed Penalty')) {
      array_push($away_team_goals, $away_team_events[$i]['detail']);
    } 
  }
*/

for ($i = 0; $i < sizeof($home_team_events); $i++) {
  array_unshift($home_team_events[$i], 'home');
}

for ($i = 0; $i < sizeof($away_team_events); $i++) {
  array_unshift($away_team_events[$i], 'away');
}

$all_team_events = array_merge($home_team_events, $away_team_events);

//print_r($all_team_events);

/*
$sortArray = array();

foreach($all_team_events as $event_sort){

  foreach($event_sort as $key=>$value){

      if(!isset($sortArray[$key])){

          $sortArray[$key] = array();

      }

      $sortArray[$key][] = $value;

  }

}

$orderby = "elapsed"; //change this to whatever key you want from the array


array_multisort($sortArray[0][$orderby],SORT_DESC,$all_team_events);

var_dump($all_team_events);

//print_r($all_team_events);
*/


   $prevent_loop = true;
              
        echo '<div class="main_container_event">
        <div class= "event_container_home">'; 
       
        for($i=0; $i < sizeof($home_team_events); $i++) {

            if (array_key_exists($home_team_events[$i]['type'], $array_type) ||
            array_key_exists($home_team_events[$i]['detail'], $array_type)
            ) 
            {
                echo
               
               $array_type[$home_team_events[$i]['type']] . 
               $array_type[$home_team_events[$i]['detail']] . ' ' .     
            
               $home_team_events[$i]['elapsed'] . "' " .
               $home_team_events[$i]['name'];
            };

            if (array_key_exists($home_team_events[$i]['detail'], $array_goal))
                 { echo ' (' . $array_goal[$home_team_events[$i]['detail']] . ')'; 
               }
               echo '<br>';
         };

         echo '</div>

         <div class="event_container_away">';  

         for($i=0; $i < sizeof($away_team_events); $i++) {

            if (array_key_exists($away_team_events[$i]['type'], $array_type) ||
            array_key_exists($away_team_events[$i]['detail'], $array_type)
            ) 
            {
                echo
                $array_type[$away_team_events[$i]['type']] . 
                $array_type[$away_team_events[$i]['detail']] . ' ' .     
            
               $away_team_events[$i]['elapsed'] . "' " .
               $away_team_events[$i]['name'];
            };

            if (array_key_exists($away_team_events[$i][1], $array_goal))
                 { echo ' (' . $array_goal[$away_team_events[$i][1]] . ')'; 
               }
              echo '<br>';

         };
      
     echo '
     </div>
     </div>';
    
         
?>