<?php
    $r_old = $_REQUEST['r'];
    $r_old = explode(";", substr($r_old, 0, -1));
    $filename = __dir__ . '/news/marks.csv';
    $f = fopen($filename, 'r');
    flock($f, LOCK_EX);
    $r_ = fgetcsv($f, 10000, ';');
    flock($f, LOCK_UN);
    fclose($f);

    $a = [];

    for ($i=0; $i < count($r_); $i++) { 
        if($r_[$i] != $r_old[$i]) {
            $a[$i] = $i+1;
        }else{
            $a[$i] = "";
        }
    }

    foreach ($a as $key => $value) {
        if ($value != "") {
            $filename = __dir__ . '/news/' . $value . '.csv';
            $f = fopen($filename, 'r');
            flock($f, LOCK_EX);
            $s = fgetcsv($f, 10000, ";");
            $s = fgetcsv($f, 10000, ";");
            $i = 0;
            while(!feof($f)){
                $s = fgetcsv($f, 2000, ";");
                $i++;
            }
            flock($f, LOCK_UN);
            fclose($f);
            $a[$key] = [];
            if ($i > 0){
                $a[$key][1] = $s[1];
                $a[$key][0] = $s[0];
            }
        }
    }

    echo json_encode($a);
?>