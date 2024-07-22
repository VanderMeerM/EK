
<?php 

$league_id = 4;
$path= './EK';
$current_euro_season = 2024;

$seasonInUrl = $_GET['season'];
$startSeasonInUrl = $euro_seasons[$seasonInUrl]['start'];
$endSeasonInUrl = $euro_seasons[$seasonInUrl]['end'];

if (!$_COOKIE['selected_euro_league_season'] && $_GET['season']) {
  setcookie('selected_euro_league_season', $_GET['season'], time() + 3600, "/");
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

 echo '<option ' . (($key == intval($_COOKIE['selected_euro_league_season']) || $key == $_GET['season']) ? 'selected ' : null) . 'value='. $key . '> ' . $key . '</option>';
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

  setcookie('selected_euro_league_season', $current_euro_season, time() + 3600, "/");
  $start_date_last_euro_season = $euro_seasons[$current_euro_season]['start'];
  $end_date_last_euro_season = $euro_seasons[$current_euro_season]['end'];
  ?>
  <script>
  let currentEuroSeason = <?php echo json_encode($current_euro_season) ?>;
  let startDateLastEuroSeason = <?php echo json_encode($start_date_last_euro_season) ?>;
  let endDateLastEuroSeason = <?php echo json_encode($end_date_last_euro_season) ?>;
  
  sessionStorage.setItem('selectedEuroLeagueSeason', currentEuroSeason);
  sessionStorage.setItem('startEuroLeagueSeason', startDateLastEuroSeason);
  sessionStorage.setItem('endEuroLeagueSeason', endDateLastEuroSeason);

  window.open(`${path}.php?season=${currentEuroSeason}&league=${leagueId}&date=${endDateLastEuroSeason}`, '_self');
  </script>
  <?php
}

?>

<script>

let selectedEuroSeason;
let startEuroSeason;
let endEuroSeason;
let seasonInURL;
let startSeasonInUrl;
let endSeasonInUrl;

if ((!sessionStorage.getItem('startEuroLeagueSeason')) || 
(!sessionStorage.getItem('endEuroLeagueSeason'))) {

seasonInURL = <?php echo json_encode($seasonInUrl) ?>;
startSeasonInUrl =  <?php echo json_encode($startSeasonInUrl) ?>;
endSeasonInUrl =  <?php echo json_encode($endSeasonInUrl) ?>;
sessionStorage.setItem('selectedEuroLeagueSeason', seasonInURL);
sessionStorage.setItem('startEuroLeagueSeason', startSeasonInUrl);
sessionStorage.setItem('endEuroLeagueSeason', endSeasonInUrl);
};

</script>

<?

if(isset($_POST["season_selection"])){
  $selectedEuroSeason = $_POST['season_selection'];
  setcookie('selected_euro_league_season', $selectedEuroSeason, time() + 3600, "/");
  $startEuroSeason = $euro_seasons[$selectedEuroSeason]['start'];
  $endEuroSeason = $euro_seasons[$selectedEuroSeason]['end'];
  ?>

  <script>
    selectedEuroSeason =  <?php echo json_encode($selectedEuroSeason) ?>;
    startEuroSeason = <?php echo json_encode($startEuroSeason) ?>;
    endEuroSeason =  <?php echo json_encode($endEuroSeason) ?>;
    sessionStorage.setItem('selectedEuroLeagueSeason', selectedEuroSeason);
    sessionStorage.setItem('startEuroLeagueSeason', startEuroSeason);
    sessionStorage.setItem('endEuroLeagueSeason', endEuroSeason);

  window.open(`${path}.php?season=${selectedEuroSeason}&league=${leagueId}&date=${endEuroSeason}`, '_self');

  </script>
  <?php

   }
     
 ?>

 <script>

$( "#datepicker" ).datepicker({
  monthNames: [ "Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December" ],
  dayNamesMin: [ "Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za" ],
   dateFormat: "yy-mm-dd",
   minDate: new Date(sessionStorage.getItem('startEuroLeagueSeason', startEuroSeason)),
   maxDate: new Date(sessionStorage.getItem('endEuroLeagueSeason', endEuroSeason))
    
 });

  
  $( "#datepicker" ).on('change', function() {

    let selectedDateInPicker = document.getElementById('datepicker').value;
   window.open(`${path}.php?season=${sessionStorage.getItem('selectedEuroLeagueSeason', selectedEuroSeason)}&league=${leagueId}&date=${selectedDateInPicker}`, '_self')
 });
  </script>
  




