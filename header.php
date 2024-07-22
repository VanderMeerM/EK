
<?php 

$league_id = 4;
$path= './EK';
$current_euro_season = 2024;

if (!$_COOKIE['selected_league_season'] && $_GET['season']) {
  setcookie('selected_league_season', $_GET['season'], time() + 3600, "/");
}

?>

<script> 
let leagueId = <?php echo json_encode($league_id) ?>; 
let path = <?php echo json_encode($path) ?>; 


</script>

<?php 
echo '
<div class="title_container"> 
<div id="logo">
 <img src= "https://media.api-sports.io/football/leagues/' . $league_id . '.png"/> 
 
</div>

<div class= "btn_container"> ' . '

<div id="header_info">'. 
$headerinfo . '
</div>
<p>
<form action=" " method="post">
<select name="season_selection" onchange="this.form.submit()">'; 

foreach ($euro_seasons as $key=>$value) {

 echo '<option ' . (($key == intval($_COOKIE['selected_league_season']) || $key == $_GET['season']) ? 'selected ' : null) . 'value='. $key . '> ' . $key . '</option>';
}

echo '
</select>
</form>';

echo '
<input type="text" id="datepicker" value = ' . (!$_GET['date'] ? date($selectedSeason . '-m-d') : $_GET['date']) . '>
</div>
</div>
</div>
</div>';


$day = $_GET['date'];

if (!$_GET['date']) { 

  setcookie('selected_league_season', $current_euro_season, time() + 3600, "/");
  $end_date_last_euro_season = $euro_seasons[$current_euro_season]['end'];
  ?>
  <script>
  let currentEuroSeason = <?php echo json_encode($current_euro_season) ?>;
  let endDateLastEuroSeason = <?php echo json_encode($end_date_last_euro_season) ?>;

  window.open(`${path}.php?season=${currentEuroSeason}&league=${leagueId}&date=${endDateLastEuroSeason}`, '_self');
  </script>
  <?php
}

?>

<script>
let selectedSeason;
let startSeason;
let endSeason;

</script>

<?

if(isset($_POST["season_selection"])){
  $selectedSeason = $_POST['season_selection'];
  setcookie('selected_league_season', $selectedSeason, time() + 3600, "/");
  $startSeason = $euro_seasons[$selectedSeason]['start'];
  $endSeason = $euro_seasons[$selectedSeason]['end'];
  ?>

  <script>
    selectedSeason =  <?php echo json_encode($selectedSeason) ?>;
    startSeason = <?php echo json_encode($startSeason) ?>;
    endSeason =  <?php echo json_encode($endSeason) ?>;
    sessionStorage.setItem('selectedLeagueSeason', selectedSeason);
    sessionStorage.setItem('startLeagueSeason', startSeason);
    sessionStorage.setItem('endLeagueSeason', endSeason);

  window.open(`${path}.php?season=${selectedSeason}&league=${leagueId}&date=${endSeason}`, '_self');

  </script>
  <?php

   }
     
 ?>

 <script>

$( "#datepicker" ).datepicker({
  monthNames: [ "Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December" ],
  dayNamesMin: [ "Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za" ],
   dateFormat: "yy-mm-dd",
   minDate: new Date(sessionStorage.getItem('startLeagueSeason', startSeason)),
   maxDate: new Date(sessionStorage.getItem('endLeagueSeason', endSeason))
    
 });

  
  $( "#datepicker" ).on('change', function() {

    let selectedDateInPicker = document.getElementById('datepicker').value;
   window.open(`${path}.php?season=${sessionStorage.getItem('selectedLeagueSeason', selectedSeason)}&league=${leagueId}&date=${selectedDateInPicker}`, '_self')
 });
  </script>
  




