<?php
include 'mysql_connect.php';
// reservation_time movie_title


if (
    isset($_GET["class_id"])
) {

    $class_id = $_GET["class_id"];


    $query =  "SELECT *
    FROM class_attendance
    INNER JOIN student ON class_attendance.student_id=student.id 
    INNER JOIN class ON class_attendance.class_id=class.class_id 
    WHERE class_attendance.class_id = " . $class_id . " ORDER BY class_attendance.attendance_id DESC";

    $result = mysqli_query($conn, $query);

    $value = "";
    $value = '
    <table class="table ">
    <thead>
        <tr>
            <th>Attendance ID</th>
            <th>LRN</th>
            <th>Fullname</th>
            <th>Gender</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>';
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' <tr>
        <td>' . $row['attendance_id'] . '</td>
        <td>' . $row['lrn'] . '</td>
        <td>' . $row['fullname'] . '</td>
        <td>' . $row['gender'] . '</td>
        <td>' . $row['date'] . '</td>
        <td>' . $row['status'] . '</td>
    </tr> ';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
