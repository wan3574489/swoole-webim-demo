<?php

function a(){
    $randMaxNumber = 633;
    $residue_number = 10*100;
    $max_number = 4;
    $result = array();
    
    for($i =1;$i<=$max_number;$i++){
        $currentRandMaxNumber = $residue_number>$randMaxNumber?$randMaxNumber:$residue_number;

        if($i == 4){
            $rand_number = $residue_number;
        }else{
            $rand_number = rand(1,$currentRandMaxNumber);
        }

        if($rand_number == 0){
            $rand_number = 1;
            $result[0] = $result[0] -1;
        }

        //
        $residue_number = $residue_number - $rand_number;
        $result[] = $rand_number;
    }
    rsort($result);

    return $result;
}
for($i =0;$i<=10000;$i++){
    $result = a();
    $o = 0;
    foreach($result as $i){
        $o = $i+$o;
    }
    if($o != 1000){
        echo 'NO';
    }
}
exit;
