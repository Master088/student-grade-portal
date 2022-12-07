
<?php
include 'mysql_connect.php';

// check if the student id is present in the request
if (
    isset($_POST["student_id"])
) {
    // get data from post
    $student_id = $_POST["student_id"];

    $sql = "SELECT * FROM  class_member where class_member_id=" . $student_id;
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);


    // remove student in the class
    $sql = "delete  from class_member  WHERE class_member_id=" . $student_id;
    $res = mysqli_query($conn, $sql);

    if ($res) {
        echo json_encode(['status' => 'success',]);
    } else {
        $message = "Remove student failed";
        echo json_encode(['status' => 'failed', 'message' => $message]);
    }
}
