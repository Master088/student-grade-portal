<?php
session_start();
include 'mysql_connect.php';

// check is school year id is present in the post request
if (
    isset($_GET["school_year"])
) {

    $student_id = $_SESSION["id"];
    $school_year = $_GET["school_year"];

    // get class of student in the active school year
    $query =  "SELECT *
    FROM class_member
    INNER JOIN student ON class_member.student_id=student.id 
    INNER JOIN class ON class_member.class_id=class.class_id 
    WHERE student.id = " . $student_id . " AND class.school_year='" . $school_year . "'";

    $result = mysqli_query($conn, $query);
    // convert the data into table structure
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

    $finalAverage = 0;

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

        // for final grade
        $final = 0;
        $value .= ' <tr>
        <td>' .   $subject['subject_title'] . '</td>';
        if (mysqli_num_rows($resultQuarter1) > 0) {
            $value .=  '<td>' . $quarter1['total'] . '</td>';
            $final += floatval($quarter1['total']);
        } else {
            $value .=  '<td>0</td>';
        }

        if (mysqli_num_rows($resultQuarter2) > 0) {
            $value .=  '<td>' . $quarter2['total'] . '</td>';
            $final += floatval($quarter2['total']);
        } else {
            $value .=  '<td>0</td>';
        }

        if (mysqli_num_rows($resultQuarter3) > 0) {
            $value .=  '<td>' . $quarter3['total'] . '</td>';
            $final += floatval($quarter3['total']);
        } else {
            $value .=  '<td>0</td>';
        }

        if (mysqli_num_rows($resultQuarter4) > 0) {
            $value .=  '<td>' . $quarter4['total'] . '</td>';
            $final += floatval($quarter4['total']);
        } else {
            $value .=  '<td>0</td>';
        }
        if (!$final == 0) {
            $final = $final / 4;
        }

        $finalAverage += $final;


        $value .=  '<td>' .  $final . '</td>';
        $value .= '</tr> ';
    }
    $finalAverage = $finalAverage / mysqli_num_rows($result);
    $value .= '<tr> 
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Final Average: 
    ' .
        $finalAverage
        . '</td> </tr>';

    $value .= '</table>';
    echo json_encode(['status' => 'success', 'html' => $value]);
}
