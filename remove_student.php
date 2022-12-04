
<?php
include 'mysql_connect.php';

if (
    isset($_POST["student_id"])
) {
    // get data from post
    $student_id = $_POST["student_id"];

    $sql = "SELECT * FROM  class_member where class_member_id=" . $student_id;
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);



    $sql = "delete  from class_member  WHERE class_member_id=" . $student_id;
    $res = mysqli_query($conn, $sql);

    if ($res) {
        // $value = "";
        // $value = '
        //         <table class="table ">
        //         <thead>
        //             <tr>
        //                 <th>LRN</th>
        //                 <th>Fullname</th>
        //                 <th>Gender</th>
        //                 <th>View</th>
        //                 <th>Remove</th>
        //             </tr>
        //         </thead>';

        // $query =  "SELECT *
        //     FROM class_member
        //     INNER JOIN student ON class_member.student_id=student.id 
        //     INNER JOIN class ON class_member.class_id=class.class_id 
        //     WHERE class_member.class_id = " . $row["class_id"];

        // $result = mysqli_query($conn, $query);
        // while ($row = mysqli_fetch_assoc($result)) {
        //     $value .= ' <tr>
        //                 <td>' . $row['lrn'] . '</td>
        //                 <td>' . $row['fullname'] . '</td>
        //                 <td>' . $row['gender'] . '</td>
        //                 <td><a class="btn btn-success" id="btn_view" href= "student_grade.php?class_member_id=' . $row['class_member_id'] . '">View</a></td>
        //                 <td><button class="btn btn-danger" id="btn_del" data-id1=' . $row['class_member_id'] . '><span class="fa fa-trash"></td>
        //             </tr> ';
        // }
        // $value .= '</table>';

        echo json_encode(['status' => 'success',]);
    } else {
        $message = "Remove student failed";
        echo json_encode(['status' => 'failed', 'message' => $message]);
    }
}
