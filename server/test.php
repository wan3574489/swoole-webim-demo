<?php


 function createSmallPacket($roomid,$packet_id,$packet_number){
    $time = time();
     $residue_number = $packet_number*100;
    $max_number = 4;
    $result = array();
    for($i =1;$i<=$max_number;$i++){
        if($i == 4){
            $rand_number =  $residue_number;
        }else{
            $rand_number = rand(1,$residue_number);
            if(rand(0,4) > 1){
                $rand_number = rand(1,$rand_number);
            }
        }
        //
         $residue_number = $residue_number - $rand_number;
        $result[] = $rand_number;
    }
    rsort($result);

     print_r($result);
}

createSmallPacket(1,1,10);

exit;
