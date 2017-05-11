<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/27/2017
 * Time: 5:35 PM
 */

/**
 * TODO generate slots
 * assign each day slots
 * a slot is a duration of time
 */
$days=array('monday','tuesday','wednesday','thursday','friday');
$periods=array('7-9AM','8-9AM','9-10AM','9-11AM','11-1PM','2-3PM','2-5PM','3-4PM','3-5PM');
$slots=array();
foreach ($days as $day) {
    foreach ($periods as $period) {
        $slots[]=array($day=>$period);
    }
}
$columns="";
$data="";
$a="";
foreach ($days as $day) {
    $a="";
    foreach ($periods as $period) {
        $a.="<td><select onchange='timetable(this)'>
                    <option value=''>Select Slot</option>
                    <option value='$day#$period'>Click to select</option>
               </select></td>";
    }
    $data.="<tr><td>".strtoupper($day)."</td>$a</tr>";
}
foreach ($periods as $period) {
   $columns.="<th>$period</th>";
}
echo "<table border='1'><thead><tr><th></th>$columns</tr></thead><tbody>$data</tbody></table>";

?>
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript">
    function timetable(th){
        var unit=prompt("Enter Course code");
        var slot=th['value'];
        $.ajax({
            url :   'functions/constructor.php',
            type:   'POST',
            data:   {
                'timetable':1,
                'slot'  :   slot,
                'unit'  :   unit
            },
            success:function (data) {
                alert(data);
            }
        });
    }
</script>
