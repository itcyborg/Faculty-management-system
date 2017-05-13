<?php
session_start();
function displayResults($userid)
{
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $queryStudentResults = $db->query("SELECT `grade` FROM results WHERE `student_id`='$userid'");
    $result2 = $queryStudentResults->fetch();
    if ($result2[0] != "") {
        $studentResults = json_decode($result2[0], true);
        foreach ($studentResults as $key => $value) {
            echo "<tr>";
            echo "<td>", $key, "</td>";
            echo "<td>", $value['unit_name'], "</td>";
            echo "<td>", $value['grade'], "</td>";
            echo "</tr>";
        }
    } else {
        echo "No results found";
    }
}

function organisations($userid, $name)
{
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("SELECT * FROM organizations");
    $result = $query->fetchAll();
    foreach ($result as $value) {
        $membersArray = json_decode($value['members'], true);
        $membersCount = count($membersArray);
        echo "<div id='individual_org'>";
        echo "<h3>$value[1]</h3>";
        echo "<i>$value[4]</i><br>";
        echo "<p>$value[5]</p>";
        $currentUser = array('$userid' => $name);
        if (in_array($name, $membersArray)) {
            echo "<button>Leave</button>", "\t";
        } else {
            echo "<button>Join</button>", "\t";
        }
        echo "<button>Members($membersCount)</button>", "\t";
        $postsArray = json_decode($value['posts'], true);
        $postsCount = count($postsArray);
        echo "<button>Posts($postsCount)</button>", "<br>", "<br>";
        foreach ($postsArray as $admission => $post) {
            echo "<div style='background:white;'>$post</div>";
            echo "<i>Posted by:</i>", "\t", "<b style='color:blue'>", $admission, "</b>";
        }
        echo "<textarea cols='70%' rows='3%' placeholder='Your post...'></textarea>", "<br>", "<button>Post</button>";
        echo "</div>";
    }
}

function suggestions($name)
{
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("SELECT * FROM suggestions");
    $results = $query->fetchAll();
    foreach ($results as $key => $value) {
        echo "<script type='text/javascript' src='index.js'></script>";
        echo "<div id='individual_sugg'>";
        echo "<h3>$value[1]</h3>";
        echo "<b>$value[3]</b>", "\t";
        echo "<i>on : $value[4]</i>";
        echo "<p>$value[2]</p>";
        echo "<button id='$value[0]' name='views' onclick='views($value[0])'>Views</button>", "<br>", "<br>";
        $divId = $value[0] * 2;
        echo "<div id='$divId' style='color:white'></div>";
        echo "</div>";
    }
}

if (isset($_POST['profile_pic'])) {
    echo '<div id="profile_pic">
			<form method="POST" action="index.php" enctype="multipart/form-data">
				<input type="file" name="filename">
				<input type="submit" name="upload" value="Upload">
			</form>
		</div>';
}
if (isset($_POST['views'])) {
    $suggestion_id = $_POST['id'];
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("SELECT `views` FROM suggestions WHERE `id`='$suggestion_id'");
    $results = $query->fetch();
    if ($results[0] != null) {
        $viewsArray = json_decode($results[0], true);
        echo "<u style='color:green'>", count($viewsArray), "\t", "Views", "</u>", "<br>";
        foreach ($viewsArray as $key => $value) {
            echo "<div style='border: 1px solid red;border-radius:10px;padding-left:2%;'>";
            $viewer = $value['owner'];
            echo "<strong style='color:blue;'>$viewer</strong>";
            $view = $value['view'];
            echo "<p>$view</p>";
            echo "</div>", "<br>";
        }
        echo "<textarea cols='70%' rows='4%' placeholder='Add your view here...'></textarea>", "<br>";
        echo "<button onclick='alert('I would work');'>Add View</button>";
    } else {
        echo "No views yet";
    }

}
if (isset($_POST['logout'])) {
    session_destroy();
}
if (isset($_POST['personal_info'])) {
    echo '<div id="personal_info">
			<h2>Your Personal information</h2>
			<div id="operation_on_info">
				<button onclick=' . "toggle('fixed')" . '>Change Information</button><br><br>
			</div>
			 <div id="fixed" style="display:none">
			    <button style="left:15%;position:absolute;" onclick=' . "toggle('fixed')" . ' >Hide</button><br><br> 
			    <form action="functions.php" method="POST">
                  <input type="text" name="contact" placeholder="new contact"><br><br>
                  <input type="text" name="email" placeholder="new email"><br><br>
				  <button name="change" onclick=' . "toggle('fixed')" . '>change</button>
			    </form>	
			 </div>
			<table>
				<tr>
					<td width="50%" id="key">Institution Identification Number:</td>
					<td width="50%" id="value">' . $_SESSION["userid"] . '</td>
				</tr>
				<tr>
					<td id="key">Your name:</td>
					<td id="value">' . $_SESSION["name"] . '</td>
				</tr>
				<tr>
					<td id="key">Photo</td>
					<td id="value">Coming Soon</td>
				</tr>
				<tr>
					<td id="key">School admitted to:</td>
					<td id="value">School of Computing and Informatics</td>
				</tr>
				<tr>
					<td id="key">Current School:</td>
					<td id="value">School of Computing and Informatics</td>
				</tr>
				<tr>
					<td id="key">Course admitted for:</td>
					<td id="value">' . $_SESSION["course"] . '</td>
				</tr>
				<tr>
					<td id="key">Current Course:</td>
					<td id="value">' . $_SESSION["course"] . '</td>
				</tr>
				<tr>
					<td id="key">Year of admission:</td>
					<td id="value">2015</td>
				</tr>
				<tr>
					<td id="key">Current Year of study:</td>
					<td id="value">' . $_SESSION["year"] . '</td>
				</tr>
				<tr>
					<td id="key">Expected Year of Graduation:</td>
					<td id="value">2019</td>
				</tr>
				<tr>
					<td id="key">Personal Phone Number:</td>
					<td id="value">' . $_SESSION["contact"] . '</td>
				</tr>
				<tr>
					<td id="key">Personal Email Address:</td>
					<td id="value">' . $_SESSION["email"] . '</td>
				</tr>
			</table>
		</div>';
}
if (isset($_POST['results'])) {
    echo '<div id="results">
			<div id="operation_on_info">
			</div>
			<table border="1">
				<tr>
					<th width="30%">COURSE CODE</th>
					<th width="50%">COURSE NAME</th>
					<th width="30%">GRADE</th>
				</tr>
				' . displayResults($_SESSION["userid"]) . '
			</table>
		</div>';
}
if (isset($_POST['ils'])) {
    echo '<div id="ils">
			<div id="operation_on_info">
				<input type="text" name="materials" placeholder="Keyword here..."><button>Search</button><br><br>
				<button>Request Materials</button><br><br>
				<button>Upload Material</button><br><br>
				<button>Report Material</button>
			</div>
		</div>';
}
if (isset($_POST['orgs'])) {
    echo '<div id="orgs">
			<div id="operation_on_info">
				<button>Create New</button><br><br>
				<button>My organizations</button><br><br>
			</div>
			' . organisations($_SESSION['userid'], $_SESSION['name']) . '
		</div>';
}
if (isset($_POST['forums'])) {
    echo '<div id="forums">
			<div id="operation_on_info">
				<button>Post Question</button><br><br>
				<button>Delete Post</button>
			</div>
		</div>';
}
if (isset($_POST['suggestions'])) {
    echo '<div id="suggestions">
			<div id="response"></div>
			<div id="operation_on_info">
				<button onclick=' . "toggle('new')" . '>New</button><br><br>
			</div>
			<div id="new" style="display:none">
				<input type="text" id="title" placeholder="Enter a title"><button style="left:90%;position:absolute;" onclick=' . "toggle('new')" . '>Hide</button><br><br>
				<textarea id="suggestion_body" cols="75%" rows="5%"></textarea><br><br>
				<button onclick=' . "newSuggestion(document.getElementById('title').value,document.getElementById('suggestion_body').value)" . '>Suggest</button>
			</div><br><br>
			' . suggestions($_SESSION['name']) . '
		</div>';
}
if (isset($_POST['candidature'])) {
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("SELECT * FROM aspirants WHERE `aspirant`='" . $_SESSION['name'] . "'");
    $results = $query->fetch();
    if ($query != null && $results[0] != null) {
        echo '<div id="candidature" style="background:rgb(4,5,100);color:white;">
					<h1>You are enrolled as a contestant for the position of <i style="color:orange">' . $results['position'] . '.</i>Goodluck!!</h1>
			</div>';
    } else {
        echo '<div id="candidature">
			<label for="adm_num">Registration Number:</label>
			<input type="text" id="adm_num" value=' . $_SESSION['userid'] . ' readonly>
			<label for="name">Name:</label>
			<input type="text" id="name" value=' . $_SESSION['name'] . ' readonly>
			<label for="position">Position:</label>
			<select id="position">
				<option>School Representative</option>
				<option>Class Representative Year I</option>
				<option>Class Representative Year II</option>
				<option>Class Representative Year III</option>
				<option>Class Representative Year IV</option>
			</select><br><br>
			<strong>Kindly note that your current average grade and year of study will be send along your request.</strong>
			<button onclick=' . "candidature(document.getElementById('adm_num').value,document.getElementById('name').value,document.getElementById('position').value)" . '>Send Request</button>
		</div>';
    }
}
if (isset($_POST['requestCandidature'])) {
    $position = $_POST['position'];
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("INSERT INTO `aspirants` (`id`, `aspirant`, `photo_url`, `position`) VALUES (NULL,'" . $_SESSION['name'] . "','', '$position') ");
    if ($query == true) {
        echo "True";
    } else {
        echo "False";
    }
}
if (isset($_POST['voting'])) {
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("SELECT * FROM aspirants");
    $user = $_SESSION['userid'];
    if ($query != null) {
        $results = $query->fetchAll();
        echo '<div id="vote">
			<table border="1px">
				<tr>
					<th id="aspirant">POSITION</th>
					<th id="aspirant">ASPIRANT</th>
					<th id="aspirant">ASPIRANT YEAR OF STUDY</th>
					<th id="aspirant">PHOTO</th>
					<th id="aspirant">ACTION</th>
				</tr>';
        foreach ($results as $value) {
            $position_id = $value[0] * 2;
            $aspirant_id = $value[0] * 3;
            $but_id = $value[0] * 4;
            echo '<tr>
					<td id=' . $position_id . '>' . $value[3] . '</td>
					<td id=' . $aspirant_id . '>' . $value[1] . '</td>
					<td>II</td>';
            if ($value[2] == null && $value[1] == $_SESSION['name']) {
                echo "<td><form method='POST' action='#' enctype='multipart/form-data'>
						<input type='file' name='public_profile' required>
						<input type='submit' name='upload_photo'>
					</form></td>
				";
            } else {
                if ($value[2] != null) {
                    echo '<td>' . $value[2] . '</td>';
                } else {
                    echo '<td>Coming Soon!!!</td>';
                }
            }
            $query2 = $db->query("SELECT * FROM votes WHERE `voter`='$user' AND `aspirant`='$value[1]'");
            $testquery = $query2->fetch();
            if ($testquery[0] == null) {
                echo '<td><button id=' . $but_id . ' onclick=' . "vote(" . $but_id . ",document.getElementById(" . $aspirant_id . ").innerHTML,document.getElementById(" . $position_id . ").innerHTML)" . '>Vote</button></td>';
            } else {
                echo '<td>Voted</td>';
            }
            echo '</tr>';
        }
        echo '</table>
		</div>';
    }
}
if (isset($_POST['vote'])) {
    $aspirant = $_POST['aspirant'];
    $user = $_SESSION['userid'];
    $position = $_POST['position'];
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("INSERT INTO `votes`(`vote_id`, `aspirant`, `voter`, `position`) VALUES (null, '$aspirant', '$user', '$position') ");
    if ($query != null) {
        echo "Voted";
    }

}
if (isset($_POST['problem'])) {
    echo '<div id="problem">
			<input type="text" id="title" placeholder="Give a title..."><br><br>
			<textarea cols="60%" rows="20%" id="complain"></textarea><button onclick=' . "check(document.getElementById('complain').value,document.getElementById('title').value)" . '>Send</button>
		</div>';
}
if (isset($_POST['sendComplain'])) {
    $title = $_POST['title'];
    $complain = $_POST['complain'];
    $user = $_SESSION['userid'];
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("INSERT INTO `reportedproblems` (`id`, `problem_title`, `problem`, `by`, `time`) VALUES (null,'$title', '$complain','$user', CURRENT_TIMESTAMP) ");
    if ($query == true) {
        echo "Your query has been received successfully.You will be notified of any actions taken.";
    } else {
        echo "There was a problem while submitting your request. Please try again later.";
    }
}
if (isset($_POST['newSuggestion'])) {
    $title = $_POST['title'];
    $suggestion = $_POST['suggestion'];
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("INSERT INTO `suggestions` (`id`, `title`, `suggestion`, `owner`, `time`, `views`) VALUES (null, '$title', '$suggestion','" . $_SESSION['userid'] . "',NOW(), NULL) ");
    if ($query == true) {
        echo "Your request was successful.";
    }
}
if (isset($_POST['change'])) {
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $userid = $userid = $_SESSION['userid'];
    $db = new PDO("mysql:host=localhost;dbname=fine", "root", "");
    $query = $db->query("UPDATE `students` SET `contact`=$contact ,`email`='$email' WHERE `adm_number`='$userid'");
    header("location: index.php");
}
?>