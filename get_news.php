<?php 
    if (empty($_REQUEST['str'])) die('Не задана подстрока');
    $str = trim(filter_var($_REQUEST['str']));
    
    if ($str == -1) {
        $c_ = 3;
    } else {
        $c_ = $str;
    }
    
    for ($j=1; $j <= $c_; $j++) { 
        $filename = __dir__ . '/news/' . $j . '.csv';
        $f = fopen($filename, 'r');
        flock($f, LOCK_EX);
        $s = fgetcsv($f, 10000, ";");
        $author = $s[0];
        $time_news = $s[1];
        $s = fgetcsv($f, 10000, ";");
        $text = $s[0];
        $i = 0;
        while(!feof($f)){
            $s = fgetcsv($f, 2000, ";");
            $i++;
        }
        flock($f, LOCK_UN);
        fclose($f);
        $last_reply_text = '';
        $last_reply_time = '';
        if ($i > 0){
            $last_reply_text = $s[1];
            $last_reply_time = $s[0];
        }
    
        echo '
        <div class="Post" id="'.$j.'">
            <div class="PostHeader">
                <div class="PostHeader_text">
                    <div>' . $author .'</div>
                    <div class="PostHeaderTime">' . $time_news . '</div>
                </div>
                <button class="btn_lock" >
                    >
                </button>
            </div>
            <div class="PostContent"> 
                <div class="Wall_text">'. $text .'</div>
                <div class="foot">
                    <button class="footComments" onclick="foo3(this)">'.$i.'</button>
                </div>
                <div class="replies">
                    <div>'. $last_reply_text .'</div>
                    <div class="PostHeaderTime">' . $last_reply_time .'</div>
                </div>
                <div class="reply_wrap">
                    <input type="text" class="reply_text" placeholder="Написать комментарий...">
                    <button class="reply_send_button" onclick="foo2(this)">></button>
                </div>
            </div>
        </div>';    
    }
    
?>
