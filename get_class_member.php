<?php
include 'mysql_connect.php';
// reservation_time movie_title


if (
    isset($_POST["class_id"])
) {
    $class_id = $_POST["class_id"];

    $value = "";
    $value = '
    <table class="table ">
    <thead>
        <tr>
            <th>LRN</th>
            <th>Fullname</th>
            <th>Gender</th>
            <th>View</th>
            <th>Remove</th>
        </tr>
    </thead>';

    $query =  "SELECT *
    FROM class_member
    INNER JOIN student ON class_member.student_id=student.id 
    INNER JOIN class ON class_member.class_id=class.class_id 
    WHERE class_member.class_id = " . $class_id;

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
                        <td>' . $row['lrn'] . '</td>
                        <td>' . $row['fullname'] . '</td>
                        <td>' . $row['gender'] . '</td>
                        <td><a class="btn btn-success" id="btn_view" href= "student_grade.php?class_member_id=' . $row['class_member_id'] . '"><i class="bi bi-eye-fill"></i> View</a></td>
                        <td><button class="btn btn-danger" id="btn_del" data-id1=' . $row['class_member_id'] . '><i class="bi bi-trash-fill"></i> Remove</td>
                    </tr> ';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
