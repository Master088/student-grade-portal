<?php
session_start();
include 'mysql_connect.php';
// reservation_time movie_title


if (
    isset($_GET["school_year"])
) {

    $student_id = $_SESSION["id"];
    $school_year = $_GET["school_year"];


    $query =  "SELECT *
    FROM class_member
    INNER JOIN student ON class_member.student_id=student.id 
    INNER JOIN class ON class_member.class_id=class.class_id 
    WHERE student.id = " . $student_id . " AND class.class_id=" . $school_year;

    $result = mysqli_query($conn, $query);

    $value = "";
    $value = '
    <table class="table ">
    <thead>
        <tr>
            <th>Subject</th>
            <th>1st Quarter</th>
            <th>2nd Quarter</th>
            <th>3rd Quarter</th>
            <th>4th Quarter</th>
            <th>Final</th>
        </tr>
    </thead>';

    while ($row = mysqli_fetch_assoc($result)) {

        // get subject name
        $query =  "SELECT subject_title
        FROM subject
        WHERE subject_id = " . $row['subject_id'];

        $resultSubject = mysqli_query($conn, $query);
        $subject = mysqli_fetch_assoc($resultSubject);

        // get 1st quarter grade  
        $query =  "SELECT * 
        FROM class_grade 
        WHERE class_id = " . $row['class_id'] . " AND student_id = " . $student_id . " AND quarter = '1st Quarter'";

        $resultQuarter1 = mysqli_query($conn, $query);
        $quarter1 = mysqli_fetch_assoc($resultQuarter1);

        // get 2nd quarter grade  
        $query =  "SELECT * 
            FROM class_grade 
            WHERE class_id = " . $row['class_id'] . " AND student_id = " . $student_id . " AND quarter = '2nd Quarter'";

        $resultQuarter2 = mysqli_query($conn, $query);
        $quarter2 = mysqli_fetch_assoc($resultQuarter2);
        // get 3rd quarter grade  
        $query =  "SELECT * 
        FROM class_grade 
        WHERE class_id = " . $row['class_id'] . " AND student_id = " . $student_id . " AND quarter = '3rd Quarter'";

        $resultQuarter3 = mysqli_query($conn, $query);
        $quarter3 = mysqli_fetch_assoc($resultQuarter3);

        // get 4th quarter grade  
        $query =  "SELECT * 
            FROM class_grade 
            WHERE class_id = " . $row['class_id'] . " AND student_id = " . $student_id . " AND quarter = '4th Quarter'";

        $resultQuarter4 = mysqli_query($conn, $query);
        $quarter4 = mysqli_fetch_assoc($resultQuarter4);



        $value .= ' <tr>
        <td>' .   $subject['subject_title'] . '</td>
        <td>' . $quarter1['total'] . '</td>
        <td>' . $quarter2['total'] . '</td>
        <td>' . $quarter3['total'] . '</td>
        <td>' . $quarter4['total'] . '</td>
    </tr> ';
    }
    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
