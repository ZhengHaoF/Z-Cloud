<?php
    $have_time  = 1600617600; //在一起的时间戳
    $now_time = time(); //当然时间戳
    $after_time = $now_time - $have_time;
    $d_all = $after_time / (60 * 60 * 24);
    $d = intval($d_all);
    $s = $d_all - $d *60 * 60 * 24;
    echo $d ."d".$s; 