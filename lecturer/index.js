function changeView(element) {
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        var disply = document.getElementById('display');
        if (this.readyState == this.DONE && this.status == 200) {
            display.innerHTML = this.responseText;
        }
    }
    request.send(element + "=" + element);
}
function results(student, year, semester, unit_code, unit_name, result_type, cat_marks, exam_marks) {
    var total_marks = parseInt(cat_marks) + parseInt(exam_marks);
    var grade = "";
    var comment = "";
    if (total_marks > 69 && total_marks < 101) {
        grade = "A";
        comment = "Excellent";
    }
    if (total_marks > 59 && total_marks < 70) {
        grade = "B";
        comment = "Good";
    }
    if (total_marks > 49 && total_marks < 60) {
        grade = "C";
        comment = "Satisfactory";
    }
    if (total_marks > 39 && total_marks < 50) {
        grade = "D";
        comment = "Pass"
    }
    if (total_marks < 40 && total_marks > 0) {
        grade = "F";
        comment = "Fail"
    }
    var request = new XMLHttpRequest();
    request.open("POST", "functions.php", true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.onreadystatechange = function () {
        if (this.readyState == this.DONE && this.status == 200) {
            alert(this.responseText);
        }
    }
    request.send("setResults=" + "setResults" + "&student=" + student + "&year=" + year + "&semester=" + semester + "&unit_code=" + unit_code + "&unit_name=" + unit_name + "&result_type=" + result_type + "&cat_marks=" + cat_marks + "&exam_marks=" + exam_marks + "&grade=" + grade + "&comment=" + comment + "&time=" + new Date());
}
/*
 THIS FUNCTION IS UNNECESSARY IF THE FUNCTION ABOVE IS KEENLY IMPLEMENTED
 */
function gradeStudent(cat_marks, exam_marks) {
    if (cat_marks == "" || exam_marks == "") {
        alert("Please enter both CAT marks and Exam marks");
    }
    else {
        var total_marks = parseInt(cat_marks) + parseInt(exam_marks);
        var grade = "";
        var comment = "";
        if (total_marks > 69 && total_marks < 101) {
            grade = "A";
            comment = "Excellent";
        }
        if (total_marks > 59 && total_marks < 70) {
            grade = "B";
            comment = "Good";
        }
        if (total_marks > 49 && total_marks < 60) {
            grade = "C";
            comment = "Satisfactory";
        }
        if (total_marks > 39 && total_marks < 50) {
            grade = "D";
            comment = "Pass"
        }
        if (total_marks < 40 && total_marks > 0) {
            grade = "F";
            comment = "Fail"
        }
        if (total_marks > 100 || total_marks < 0) {
            grade = "Invalid marks"
        }
        document.getElementById('grade').value = grade;

    }
}

