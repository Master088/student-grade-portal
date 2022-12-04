<?php
include 'mysql_connect.php';


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

        if (mysqli_num_rows($res) > 0) {
            $message = "Student with this LRN " . $lrn . " is already added in this class!";
            echo json_encode(['status' => 'failed', 'message' => $message]);
        } else {
            //insert
            $id = $row['id'];
            $sql = "INSERT INTO class_member 
            SET 
            class_member_id=null,
            student_id='$id',
            class_id='$class_id';
            ";

            if (mysqli_query($conn, $sql)) {
                // $value = "";
                // $value = '
                //     <table class="table ">
                //     <thead>
                //         <tr>
                //             <th>LRN</th>
                //             <th>Fullname</th>
                //             <th>Gender</th>
                //             <th>View</th>
                //             <th>Remove</th>
                //         </tr>
                //     </thead>';

                // $query =  "SELECT *
                // FROM class_member
                // INNER JOIN student ON class_member.student_id=student.id 
                // INNER JOIN class ON class_member.class_id=class.class_id 
                // WHERE class_member.class_id = " . $class_id;

                // $result = mysqli_query($conn, $query);

                // while ($row = mysqli_fetch_assoc($result)) {
                //     $value .= ' <tr>
                //             <td>' . $row['lrn'] . '</td>
                //             <td>' . $row['fullname'] . '</td>
                //             <td>' . $row['gender'] . '</td>
                //             <td><a class="btn btn-success" id="btn_view" href= "student_grade.php?class_member_id=' . $row['class_member_id'] . '">View</a></td>
                //             <td><button class="btn btn-danger" id="btn_del" data-id1=' . $row['class_member_id'] . '><span class="fa fa-trash"></td>
                //         </tr> ';
                // }
                // $value .= '</table>';
                echo json_encode(['status' => 'success']);
            } else {
                // echo mysqli_error($conn);
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
