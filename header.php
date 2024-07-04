
<?php 

echo '
<div class="title_container"> 
<div id="logo">
 <img src="https://media.api-sports.io/football/leagues/4.png"/> 
</div>
<div id="matches_today"> '. 
strtoupper($todaysmatches) . '

<div class= "btn_container"> ' .

/*
<a href="' . $_SERVER['PHP_SELF'] . '?date=' . date('Y-m-d', strtotime('yesterday')) . '" 
' . (date('Y-m-d', strtotime('yesterday')) === $_GET['date'] ?  'class="txt-underline"' : null). '> 
'. $yesterday . '</a> 

<a href="' . $_SERVER['PHP_SELF'] . '"
' . ((date('Y-m-d') === $_GET['date'] || !$_GET['date']) ?  'class="txt-underline"' : null). '> 
'. $today . '</a> 

<a href="' . $_SERVER['PHP_SELF'] . '?date=' . date('Y-m-d', strtotime('tomorrow')) . '"
' . (date('Y-m-d', strtotime('tomorrow')) === $_GET['date'] ?  'class="txt-underline"' : null). '>
'. $tomorrow . '</a>
*/
'
<div>
  <input type="text" id="datepicker" value = ' . (!$_GET['date'] ? date('Y-m-d') : $_GET['date']) . '>
</div>
</div> 
</div>
</div>
</div>';

 ?>

 <script>

 $( "#datepicker" ).datepicker({
   dateFormat: "yy-mm-dd",
   minDate: new Date(2024, 5, 14),
   maxDate: new Date(2024, 6, 14)
  
 });

 $( "#datepicker" ).on('change', function() {
    window.open('./EK2024.php?date='+$('#datepicker')[0].value, '_self')
 });
 
 </script>



