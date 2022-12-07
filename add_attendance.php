<?php
include 'mysql_connect.php';

// chec if class id, absent and date is present in the post request
if (
    isset($_POST["class_id"]) &&  isset($_POST["absent"]) &&  isset($_POST["date"])
) {
    // get value from the post request and set it to variable
    $date = $_POST["date"];
    $absent = json_decode(stripslashes($_POST['absent']));
    $class_id = $_POST["class_id"];

    // get all student
    $query =  "SELECT *
    FROM class_member
    INNER JOIN student ON class_member.student_id=student.id 
    INNER JOIN class ON class_member.class_id=class.class_id 
    WHERE class_member.class_id = " . $class_id;
    $result = mysqli_query($conn, $query);

    $isSuccess = true;
    $sql = "";
    // loop all member of the class
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        // if the id of student is in absent array the student is absent otherwise present
        if (val_in_arr($row["id"], $absent)) {
            $sql = "INSERT INTO class_attendance 
            SET 
            attendance_id=null,
            class_id='$class_id',
            student_id='$id',
            date='$date',
            status='absent';
            ";
        } else {
            $sql = "INSERT INTO class_attendance 
            SET 
            attendance_id=null,
            class_id='$class_id',
            student_id='$id',
            date='$date',
            status='present';
            ";
        }

        if (mysqli_query($conn, $sql)) {
        } else {
            $isSuccess = false;
        }
    }
    // check if theres no error. if no error return success message and status
    if ($isSuccess) {
        $message = "Add success";
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
        $message = "Add failed";
        echo json_encode(['status' => 'failed', 'message' => $message]);
    }
}
//check if id is in the absent array id
function val_in_arr($val, $arr)
{
    foreach ($arr as $arr_val) {
        if ($arr_val == $val) {
            return true;
        }
    }
    return false;
}
