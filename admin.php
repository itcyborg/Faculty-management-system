<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/30/2017
 * Time: 8:14 PM
 */
require "system/newdb.php";
$db=new newdb();
if(isset($_GET['guests'])){
    try{
        $sql="SELECT * FROM guests";
        $result=$db->get($sql)->fetchAll(PDO::FETCH_OBJ);
        foreach ($result as $item) {
            echo $item->ID.".\t".$item->IP_Address.",\t",$item->Client_agent.",\t"  .$item->TimeStamp;
            echo "<br>";
        }
    }catch (DBException $e){
        echo $e;
    }
}
if(isset($_GET[''])){

}