
<?php 

echo '
<div class="title_container"> 
<div id="logo">
 <img src="https://media.api-sports.io/football/leagues/4.png"/> 
</div>
<div id="matches_today"> '. 
strtoupper($todaysmatches) . '

<div class= "btn_container"> ' .

'<div>
<form>
<select name="season_selection">'; 

foreach ($euro_seasons as $es) {
  echo ' 
  <option value='. $es . '> ' . $es . '</option>';
}

echo '
</select>
</form>';

$startYear = explode('-', $response['response'][0]['fixture']['date'])[0];
$startMonth = explode('-', $response['response'][0]['fixture']['date'])[1];

$startDay = explode('-', $response['response'][0]['fixture']['date'])[2];
$startDay = explode('T', $startDay)[0];

$endMonth = explode('-', $response['response'][$numGames-1]['fixture']['date'])[1];

$endDay = explode('-', $response['response'][$numGames-1]['fixture']['date'])[2];
$endDay = explode('T', $endDay)[0];

sizeof(explode('0', $startMonth)) > 1 ? 
$startMonth = explode('0', $startMonth)[1] : null;

sizeof(explode('0', $endMonth)) > 1 ? 
$endMonth = explode('0', $endMonth)[1] : null;


echo '
<input type="text" id="datepicker" value = ' . (!$_GET['date'] ? date($startYear . '-m-d') : $_GET['date']) . '>
</div>
</div> 
</div>
</div>
</div>';

 ?>

 <script>

  let startYear = <?php echo json_encode($startYear) ?>;

  let startMonth = <?php echo json_encode($startMonth) ?>;
  let endMonth = <?php echo json_encode($endMonth) ?>;

  let startDay = <?php echo json_encode($startDay); ?>;
  let endDay = <?php echo json_encode($endDay); ?>;

 $( "#datepicker" ).datepicker({
   dateFormat: "yy-mm-dd",
   minDate: new Date(2024, 5, 14),
   maxDate: new Date(2024, 6, 14)
   //minDate: new Date(startYear, startMonth-1, startDay),
  // maxDate: new Date(startYear, endMonth-1, endDay)
  
 });

 $( "#datepicker" ).on('change', function() {
    window.open('./EK2024.php?date='+$('#datepicker')[0].value, '_self')
 });
 
 </script>



