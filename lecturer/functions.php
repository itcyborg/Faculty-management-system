<?php
session_start();
$db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
if (isset($_POST['details'])) {
    $value1 = "phone number";
    $value2 = "email address";
    echo '<table border="1px">
			<tr>
				<th width="48%">Property</th>
				<th width="48%"">Value</th>
				<th width="50%">Action</th>
			</tr>
			<tr>
				<td>Staff Number</td>
				<td>' . $_SESSION['staffno'] . '</td>
				<td>None</td>
			</tr>
			<tr>
				<td>ID Number</td>
				<td>' . $_SESSION['idnumber'] . '</td>
				<td>None</td>
			</tr>
			<tr>
				<td>Name</td>
				<td>' . $_SESSION['name'] . '</td>
				<td>None</td>
			</tr>
			<tr>
				<td>Contact</td>
				<td>' . $_SESSION['phone'] . '</td>
				<td><button onclick=' . "changeInfo()" . '>Change</button></td>
			</tr>
			<tr>
				<td>Email</td>
				<td>' . $_SESSION['email'] . '</td>
				<td><button onclick=' . "changeInfo()" . '>Change</button></td>
			</tr>
			<tr>
				<td>Department</td>
				<td>' . $_SESSION['department'] . '</td>
				<td>None</td>
			</tr>
			<tr>
				<td>Term of Service</td>
				<td>' . $_SESSION['service_type'] . '</td>
				<td>None</td>
			</tr>
		</table>';
}
if (isset($_POST['payslip'])) {
}
if (isset($_POST['units'])) {
    $units = $_SESSION['units'];
    echo "<table border='1px' style='width:100%'>
			<tr>
				<th>Unit Code</th>
				<th>Unit Name</th>
			</tr>
		";
    foreach ($units as $key => $value) {
        echo "<tr>";
        echo "<td style='width:40%;font-size:140%'>", $key, "</td>";
        echo "<td style='font-size:140%;'>", $value, "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
if (isset($_POST['lectures'])) {
    $units = $_SESSION['units'];
    echo "<table border='1px' style='width:100%'>
			<tr>
				<th>Unit Code</th>
				<th>Unit Name</th>
				<th>Day</th>
				<th>Time</th>
				<th>Venue</th>
			</tr>
		";
    foreach ($units as $key => $value) {
        echo "<tr>";
        echo "<td style='width:15%;font-size:100%'>", $key, "</td>";
        echo "<td style='font-size:100%;width:30%;'>", $value, "</td>";
        echo "<th>Monday</th>";
        echo "<th>7.00-9.00AM</th>";
        echo "<th>TB II</th>";
        echo "</tr>";
    }
    echo "</table>";
}
if (isset($_POST['results'])) {
    $units = $_SESSION['units'];
    echo "<strong style='position:fixed;color:blue;z-index:17;'>Please note that if you make an error while adding the results,repeat the procedure with correct values<br> and the error will be fixed automatically.</strong>", "<br><br>";
    echo '
		<label for="student_num">Student Number..............</label>
		<input type="text" id="student_num" placeholder="Admission number" name="student_num"><br><br>
		<label for="year">Academic year................</label>
		  <select id="year" name="year">
		  	  <option>2014/2015</option>
		  	  <option>2015/2016</option>
		  	  <option>2016/2017</option>
		  	  <option>2017/2018</option>
		  </select><br><br>
		  <label for="semester">Semester.........................</label>
		  <select id="semester" name="semester">
		  	  <option>Semester I</option>
		  	  <option>Semester II</option>
		  </select><br><br>';
    echo '<label for="unit_code">Unit code........................</label>
		  <select id="unit_code" name="unit_code">';
    $code = "";
    foreach ($units as $key => $value) {
        $code = $key;
        echo '<option>', $key, '</option>';
    }
    echo '</select><br><br>
		  <label for="unit_name">Unit name.......................</label>
		  <select id="unit_name" name="unit_name">';
    foreach ($units as $key => $value) {
        echo "<option>", $value, "</option>";
    }
    echo '</select><br><br>
		  <label for="result_type">Type of Exam.................</label>
		  <select id="result_type" name="result_type">
		  	  <option>Original</option>
		  	  <option>Resit</option>
		  </select><br><br>
		  <label for="cat_marks">CAT marks......................</label>
		  <input type="text" id="cat_marks" placeholder="CAT"><br><br>
		  <label for="exam_marks">Exam marks....................</label>
		  <input type="text" id="exam_marks" placeholder="Exam" name="exam_marks"><br><br>
		  <label for="grade">Grade..............................</label>
		  <input type="text" readonly id="grade" name="grade" onfocus=' . "gradeStudent(document.getElementById('cat_marks').value,document.getElementById('exam_marks').value)" . '>
		  <button onclick=' . "results(document.getElementById('student_num').value,document.getElementById('year').value,document.getElementById('semester').value,document.getElementById('unit_code').value,document.getElementById('unit_name').value,document.getElementById('result_type').value,document.getElementById('cat_marks').value,document.getElementById('exam_marks').value,document.getElementById('grade'))" . '>Submit</button>
		';
}
if (isset($_POST['setResults'])) {
    $student = $_POST['student'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $unit_code = $_POST['unit_code'];
    $unit_name = $_POST['unit_name'];
    $result_type = $_POST['result_type'];
    $cat_marks = $_POST['cat_marks'];
    $exam_marks = $_POST['exam_marks'];
    $total_marks = $cat_marks + $exam_marks;
    $grade = $_POST['grade'];
    $comment = $_POST['comment'];
    $time = $_POST['time'];
    $lecturer_num = $_SESSION['staffno'];
    $lecturer_name = $_SESSION['name'];
    $lecturer_contact = $_SESSION['phone'] . " or " . $_SESSION['email'];
    $resultArray = array(
        "$unit_code" => array(
            "unit_name" => "$unit_name",
            "lecturer_num" => "$lecturer_num",
            "lecturer_name" => "$lecturer_name",
            "lecturer_contact" => "$lecturer_contact",
            "academic_year" => "$year",
            "semester" => "$semester",
            "result_type" => "$result_type",
            "cat_marks" => "$cat_marks",
            "exam_marks" => "$exam_marks",
            "total_marks" => "$total_marks",
            "grade" => "$grade",
            "comment" => "$comment",
            "time" => "$time"
        )
    );
    $packResults = json_encode($resultArray);
    //check whether  the student has any results
    $query = $db->query("SELECT * FROM results WHERE `student_id`='$student'");
    $results = $query->fetch();
    if ($results['student_id'] != null) {
        $existingResults = json_decode($results['grade'], true);
        $existingResults[$unit_code] = array(
            "unit_name" => "$unit_name",
            "lecturer_num" => "$lecturer_num",
            "lecturer_name" => "$lecturer_name",
            "lecturer_contact" => "$lecturer_contact",
            "academic_year" => "$year",
            "semester" => "$semester",
            "result_type" => "$result_type",
            "cat_marks" => "$cat_marks",
            "exam_marks" => "$exam_marks",
            "total_marks" => "$total_marks",
            "grade" => "$grade",
            "comment" => "$comment",
            "time" => "$time"
        );
        $pack = json_encode($existingResults);
        $update = $db->query("UPDATE `results` SET `grade`='$pack' WHERE `student_id`='$student'");
        if ($update == true) {
            echo "Result added successfully";
        } else {
            echo "There was a problem updating student records.Try again in a while";
        }
    } else {
        $query2 = $db->query("SELECT * FROM students WHERE `adm_number`='$student'");
        $results2 = $query2->fetch();
        if ($results2['adm_number'] != null) {
            $course = $results2['course'];
            $year = $results2['year'];
            $query3 = $db->query("INSERT INTO `results`(`course_id`, `student_id`, `sem`, `year`, `id`, `grade`, `time`) VALUES ('$course', '$student', 'II','$year',null, '$packResults',NOW())");
            if ($query3 == true) {
                echo "Operation successful";
            } else {
                echo "Failed";
            }
        } else {
            echo "No student with that admission number found.Operation failed.";
        }
    }
}
if (isset($_POST['resources'])) {
    ?>
    <form method="POST" enctype="multipart/form-data" action="functions.php">
        <label for="learning_material">Choose a file from your computer(To choose multiple files,hold down the ctrl-key
            as you select the files)</label><br>
        <input type="file" name="learning_material" required>
        <select name="group">
            <option name="group">Year I</option>
            <option name="group">Year II</option>
            <option name="group">Year III</option>
            <option name="group">Year IV</option>
        </select>
        <select name="course">
            <?php
            $units = $_SESSION['units'];
            foreach ($units as $key => $value) {
                echo "<option name='course'>", $key . " " . $value, "</option>";
            }
            ?>
        </select>
        <input type="submit" name="send_material" value="Upload">
    </form>
    <?php
    $user = $_SESSION['idnumber'];
    $check = $db->query("SELECT * FROM `lecturer_material` WHERE `lec_id`='$user'");
    $testResult = $check->fetch();
    if ($testResult['lec_id'] != null && $testResult['resources']) {
        $allResource = json_decode($testResult['resources'], true);
        foreach ($allResource as $key => $value) {
            echo "<a style='color:blue;' href='", $key, "'target='_blank'>", $value['course'], "</a><br>";
        }
    }
}
if (isset($_POST['settings'])) {
    echo "Settings";
}
if (isset($_POST['send_material'])) {
    if ($_FILES) {
        $file = $_FILES['learning_material']['name'];
        $group = $_POST['group'];
        $course = $_POST['course'];
        $folder = "../unit_materials";
        $storeas = $folder . "/" . $file;
        move_uploaded_file($_FILES['learning_material']['tmp_name'], $storeas) or die("Upload failed");
        $fileInfo = array(
            "$storeas" => array(
                "course" => $course,
                "group" => $group
            )
        );
        $packFileInfor = json_encode($fileInfo);
        $user = $_SESSION['idnumber'];
        $check = $db->query("SELECT * FROM `lecturer_material` WHERE `lec_id`='$user'");
        $testResult = $check->fetch();
        if ($testResult['lec_id'] != null) {
            $newResource = json_decode($testResult['resources'], true);
            $newResource[$storeas] = array(
                "course" => $course,
                "group" => $group
            );
            $repack = json_encode($newResource);
            $updateInfo = $db->query("UPDATE `lecturer_material` SET `resources`='$repack' WHERE `lec_id`='$user'");
        } else {
            $insertnew = $db->query("INSERT INTO `lecturer_material`(`lec_id`,`resources`) VALUES('$user','$packFileInfor')");
        }
        header("Location: index.php");
    } else {
        echo "No file uploaded";
    }
}
?>