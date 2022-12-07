<?php
include 'mysql_connect.php';

// check if the class id is present in the post request
if (
    isset($_GET["class_id"])
) {
    $class_id = $_GET["class_id"];

    $value = "";
    // get all class members
    $query =  "SELECT *
    FROM class_member
    INNER JOIN student ON class_member.student_id=student.id 
    INNER JOIN class ON class_member.class_id=class.class_id 
    WHERE class_member.class_id = " . $class_id;
    $result = mysqli_query($conn, $query);
    // for attendance checklist
    while ($row = mysqli_fetch_assoc($result)) {
        $value .= ' 
        <div class="col-md-3 border mx-2 mb-2">
            <div class="form-check">
                <input class="form-check-input me-2" type="checkbox" value="' . $row['id'] . '" name="student" id="student" checked />
                <label class="form-check-label" for="isTeacher">
              ' . $row['fullname'] . '
                 </label>
            </div>
        </div>
        ';
    }
    // return response
    echo json_encode(['status' => 'success', 'html' => $value]);
}
