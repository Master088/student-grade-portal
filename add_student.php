<?php
include 'mysql_connect.php';

// check if the lrn and class id is present in the post request
if (
    isset($_POST["lrn"]) && isset($_POST["class_id"])
) {
    // get data from post
    $class_id = $_POST["class_id"];
    $lrn = $_POST["lrn"];

    // find student
    $sql = "SELECT * FROM  student where lrn='$lrn'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if (mysqli_num_rows($res) > 0) {
        $sql = "SELECT * FROM  class_member where student_id='" . $row['id'] . "' AND class_id='" . $class_id . "'";
        $res = mysqli_query($conn, $sql);
        //check if the student is already added in the class
        if (mysqli_num_rows($res) > 0) {
            $message = "Student with this LRN " . $lrn . " is already added in this class!";
            echo json_encode(['status' => 'failed', 'message' => $message]);
        } else {
            // if no add student to the class
            //insert
            $id = $row['id'];
            $sql = "INSERT INTO class_member 
            SET 
            class_member_id=null,
            student_id='$id',
            class_id='$class_id';
            ";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['status' => 'success']);
            } else {
                $message = "Add failed";
                echo json_encode(['status' => 'failed', 'message' => $message]);
            }
        }
    } else {
        $message = "Student with this LRN " . $lrn . "  is not exist!";
        echo json_encode(['status' => 'failed', 'message' => $message]);
    }
} else {
    $message = "error";
    echo json_encode(['status' => 'failed', 'message' => $message]);
}
