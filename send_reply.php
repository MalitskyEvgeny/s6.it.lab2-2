<?php
    if (empty($_REQUEST['reply'])) die();
    if (empty($_REQUEST['time'])) die();
    if (empty($_REQUEST['i_new'])) die();
    $reply_ = htmlspecialchars($_REQUEST['reply']);
    $time_ = htmlspecialchars($_REQUEST['time']);
    $i_new = htmlspecialchars($_REQUEST['i_new']);

    $a = array( $time_, htmlspecialchars_decode($reply_));

    $filename = __dir__ . '/news/' . $i_new . '.csv';
    $f = fopen($filename, 'a');
    flock($f, LOCK_EX);
    fwrite($f, "\n");
    fputcsv($f, $a, ';', eol:'');
    flock($f, LOCK_UN);
    fclose($f);

    $filename = __dir__ . '/news/marks.csv';
    $f = fopen($filename, 'r');
    flock($f, LOCK_EX);
    $r_ = fgetcsv($f, 10000, ';');
    fclose($f);
    $f = fopen($filename, 'w');
    $r_[$i_new-1] = $time_;
    fputcsv($f, $r_, ';', eol:'');
    flock($f, LOCK_UN);
    fclose($f);
?>