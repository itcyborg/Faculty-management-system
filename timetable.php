<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/27/2017
 * Time: 5:35 PM
 */
$days=array('monday','tuesday','wednesday','thursday','friday');
$venues=array('tb1','tb2','tb3','tb4','tb5');
$periods=array('7-9','9-11','11-1','2-3','3-5');
$units=array('ccs201','ccs203','ccs205','ccs207','ccs209','ccs211','ccs213');
$slots=array();
foreach ($days as $day) {
    foreach ($venues as $venue) {
        foreach ($periods as $period) {
            if(!in_array($day.",".$venue.",".$period,$slots)){
                $slots[]=$day.",".$venue.",".$period.allocate_classes($slots,$units);;
            }
        }
    }
}
function allocate_classes($slots,$units){
    $allotment=array();
    $count=0;
    foreach ($slots as $slot) {
        $sl=$units[mt_rand(0,sizeof($units)-1)];
        if($count<1) {
            $count++;
            if (!in_array($sl, $allotment)) {
                $allotment[$slot] = $sl;
            }else{
                $allotment[$slot] = $sl;
            }
        }else{
            $count=0;
        }
    }
    return $allotment;
}

var_dump($slots);

