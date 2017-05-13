<?php
session_start();
if (isset($_POST['vars'])) {
    $year = $_POST['year'];
    $sem = $_POST['sem'];
    $course = $_POST['course'];
    $_SESSION['year'] = $year;
    $_SESSION['sem'] = $sem;
    $_SESSION['course'] = $course;
    $_SESSION['tt'] = "";
    die($_SESSION['year'] . "," . $_SESSION['sem'] . "," . $_SESSION['course']);
}
if (isset($_POST['finish'])) {
    $file = fopen($_SERVER["DOCUMENT_ROOT"] . '/uploads/timetables/timetableY' . $_SESSION["year"] . 'S' . $_SESSION["sem"] . 'C' . $_SESSION["course"] . '.txt', 'w');
    fwrite($file, $_SESSION['tt']);
    fclose($file);
    die("success");
}
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<select id="year">
    <option>Select Year</option>
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
</select>
<select id="semester">
    <option>Select Semester</option>
    <option>1</option>
    <option>2</option>
</select>
<?php
/**
 * Created by PhpStorm.
 * User: itcyb
 * Date: 4/27/2017
 * Time: 5:35 PM
 */

/**
 * assign each day slots
 * a slot is a duration of time
 */
$sql = "SELECT * FROM courses";
require "system/newdb.php";
$db = new newdb();
$result = $db->get($sql)->fetchAll(PDO::FETCH_OBJ);
?>
<select id="course">
    <option>Select Course</option>
    <?php
    foreach ($result as $res) {
        echo "<option>$res->CourseCode . $res->CourseName</option>";
    }
    ?>
</select>
<button id="save">Save</button>
<hr>
<?php
$days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');
$periods = array('7-9AM', '8-9AM', '9-10AM', '9-11AM', '11-1PM', '2-3PM', '2-5PM', '3-4PM', '3-5PM');
$slots = array();
foreach ($days as $day) {
    foreach ($periods as $period) {
        $slots[] = array($day => $period);
    }
}
$columns = "";
$data = "";
$a = "";
foreach ($days as $day) {
    $a = "";
    foreach ($periods as $period) {
        $a .= "<td id='$day|$period'><select onchange='timetable(this)'>
                    <option value=''>Select Slot</option>
                    <option value='$day|$period'>Click to select</option>
               </select></td>";
    }
    $data .= "<tr><td>" . strtoupper($day) . "</td>$a</tr>";
}
foreach ($periods as $period) {
    $columns .= "<th>$period</th>";
}
echo "<table border='1'><thead><tr><th></th>$columns</tr></thead><tbody>$data</tbody></table><hr>";

?>
<button id="finish">Finish</button>
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript">
    function timetable(th) {
        var unit = prompt("Enter Course code");
        var slot = th['value'];
        var s = document.getElementById(slot);
        $.ajax({
            url: 'functions/constructor.php',
            type: 'POST',
            data: {
                'timetable': 1,
                'slot': slot,
                'unit': unit
            },
            success: function (data) {
                s.innerHTML = unit;
            }
        });
    }
    $('#save').click(function () {
        var year = $('#year').val();
        var sem = $('#semester').val();
        var course = $('#course').val();
        $.ajax({
            url: 'timetable.php',
            type: 'POST',
            data: {
                'vars': 1,
                'year': year,
                'sem': sem,
                'course': course
            },
            success: function (data) {
                alert(data);
            }
        });
    });
    $('#finish').click(function () {
        $.ajax({
            url: 'timetable.php',
            type: 'POST',
            data: {
                'finish': 1
            },
            success: function (data) {
                alert(data);
            }
        });
    });
</script>

</body>
</html>