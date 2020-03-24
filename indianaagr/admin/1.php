<?php
    $size_arr           =   array();
    $size_arr[1]        =   8;
    $size_arr[2]        =   11;
    $size_arr[3]        =   14;
    $size_arr[4]        =   17;
    $size_arr[5]        =   18;
    $size_arr[6]        =   21;
    $size_arr[7]        =   25;
    
    //Insert Variants in Product Variants
    if(!empty($size_arr)) {
        foreach($size_arr as $size_id => $quantity) {
            //foreach($size as $size_id => $quantity) {
                echo $size_id." - ".$quantity."<br/>";    
            //}    
        }
    }
    
?>