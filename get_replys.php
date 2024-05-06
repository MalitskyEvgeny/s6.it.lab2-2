<?php
if (empty($_REQUEST['str'])) die('Не задана подстрока');
$str = trim(filter_var($_REQUEST['str']));

$filename = __dir__ . '/news/' . $str . '.csv';
$f = fopen($filename, 'r');
flock($f, LOCK_EX);
$s = fgetcsv($f, 10000, ";");
$author = $s[0];
$time_news = $s[1];
$s = fgetcsv($f, 10000, ";");
$text = $s[0];
$i = 0;
echo '<div class="div_replys">';
while(!feof($f)){
    $s = fgetcsv($f, 2000, ";");
    $i++;

    if ($i > 0){
        echo $s[0] . '<br>' . $s[1] . '<br>' . '<br>';
    }
}

echo '<button onclick="foo4()">cansel</button></div>';
flock($f, LOCK_UN);
fclose($f);
?>