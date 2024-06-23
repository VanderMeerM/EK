
<?php 

echo '
<div class="title_container"> 
<div id="logo">
 <img src="'.$response['response'][0]['league']['logo'] . '"/> 
</div>
<div id="matches_today"> '. 
$todaysmatches . '

<div class= "btn_container"> 

<a href="' . $_SERVER['PHP_SELF'] . '?date=' . date('Y-m-d', strtotime('yesterday')) . '" 
' . (date('Y-m-d', strtotime('yesterday')) === $_GET['date'] ?  'class="txt-underline"' : null). '> 
'. $yesterday . '</a> 

<a href="' . $_SERVER['PHP_SELF'] . '"
' . ((date('Y-m-d') === $_GET['date'] || !$_GET['date']) ?  'class="txt-underline"' : null). '> 
'. $today . '</a> 

<a href="' . $_SERVER['PHP_SELF'] . '?date=' . date('Y-m-d', strtotime('tomorrow')) . '"
' . (date('Y-m-d', strtotime('tomorrow')) === $_GET['date'] ?  'class="txt-underline"' : null). '>
'. $tomorrow . '</a> 
 
</div>
</div>
</div>';

?>