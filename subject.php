<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and  student user to access this page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location:login.php');
    } else {
        if ($_SESSION['account_type'] == "student") {
            header('Location:studentDashboard.php');
        }
    }
} else {
    echo '<script>';
    echo 'alert("Please Login your Account!")';
    echo '</script>';
    header('Location:login.php');
}

$subject_id = "";
// get subject id; use subject id to get subject details
if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $sql = "SELECT * FROM  subject WHERE subject_id=" . $subject_id;
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {

        $subject_details = mysqli_fetch_assoc($res);
    }
}

// fires when add class button click
if (isset($_POST['add_class'])) {
    // get data from post request
    // combine date_from and date_to to create school year 
    $school_year = $_POST['date_from'] . "-" . $_POST['date_to'];
    $schedule = $_POST['schedule'];

    // check if theres class for this school year!
    $sql = "SELECT * FROM  class where subject_id='$subject_id' AND school_year='$school_year'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $_SESSION['status'] = "error";
    } else {
        //insert into class table query
        $sql = "INSERT INTO class 
        SET 
        class_id=null,
        school_year='$school_year',
        schedule='$schedule',
        subject_id='$subject_id'
        ";
        // if the insert is success
        if (mysqli_query($conn, $sql)) {
            $_SESSION['status_success'] = "success";
            header("Refresh:1; url=subject.php?subject_id=" . $subject_id, true, 1);
        } else {
            // if insert failed
            echo mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css">
<style>
    * {
        box-sizing: border-box;
    }

    html,
    body {
        padding: 0;
        margin: 0;
        font-family: Poppins;
        font-weight: 300;
        height: 100%;
        font-size: 1em;
        overflow-x: hidden;
        overflow-y: visible;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: #F8FAFB;
    }

    .card {
        max-height: 500px;
        padding: .75rem;
        margin-bottom: 2rem;
        border: 0;
        flex-basis: 33.333%;
        flex-grow: 0;
        flex-shrink: 0;
        display: flex;
        overflow-x: scroll;
    }
</style>

<body>
    <nav class="navbar navbar-light bg-dark">
        <a href="index.php" class="navbar-brand text-white">Classroom Management System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class=" mt-3 mb-5">
        <h1 class="text-center"> <?php echo $subject_details['subject_title']; ?></h1>
    </div>

    <div class="container ">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4  ">
                <div class="d-flex">
                    <div class="form-group  ">
                        <div class="d-flex">
                            <h4 class=" mx-2">School Year </h4>
                            <button class="btn btn-info " data-bs-toggle="modal" data-bs-target="#addClass"><i class="bi bi-plus-circle-fill"></i> Add School Year</button>
                        </div>
                        <div class=" mt-2 ">
                            <!-- call get studeStudent function when the value is change -->
                            <select class=" form-select" onchange="getStudent()" name="school_year" id="school_year" required aria-label="Default select example">
                                <!-- display all school year in the dropdown/select -->
                                <?php
                                $sql = "SELECT * FROM class WHERE subject_id=" . $subject_id;
                                $res = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {  ?>
                                        <!-- set class id as value and school year as display text -->
                                        <option value="<?php echo $row['class_id']; ?>"><?php echo $row['school_year']; ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7  ">
                <div class="d-flex justify-content-end">
                    <!-- open add student modal -->
                    <button class="btn btn-info rounded-button mx-2" data-bs-toggle="modal" data-bs-target="#addStudent"><i class="bi bi-person-plus"></i> Add Student</button>
                    <!-- open add attendance modal -->
                    <button class="btn btn-info rounded-button mx-2" data-bs-toggle="modal" data-bs-target="#addAttendance" onclick="getAttendanceList()"><i class="bi bi-card-checklist"></i> Add attendance</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <h2 class="text-center">My Students</h2>
        <!-- the student table will be display here using javascript -->
        <div id="table" class="text-dark mx-2"></div>
    </div>
    <div class="container mt-5">
        <h2 class="text-center">Attedance</h2>
        <div class="card card-body">
            <!-- the attendance table will be display here using javascript -->
            <div id="attendance_table" class="text-dark mx-2"></div>
        </div>
    </div>

    <!-- add class modal -->
    <div class="modal fade" id="addClass">
        <div class="modal-dialog">
            <form method="POST" action="">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Class</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <p id='class_validate_message' class="text-danger"></p>

                        <div class="row">
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class="" for="date_from">Date from:</label>
                                    <div class=" mt-2">
                                        <!-- display all year from 1950 to current year     -->
                                        <select class="form-select" name="date_from" id="date_from" aria-label="Default select example" required>
                                            <option selected disabled>Please Select year</option>
                                            <?php
                                            for ($i = date('Y'); $i > 1950; $i--) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class=" " for="date_to">Date to:</label>
                                    <div class=" mt-2">
                                        <!-- display all year from 1950 to current year     -->
                                        <select class=" form-select" name="date_to" id="date_to" aria-label="Default select example" required>
                                            <option selected disabled>Please Select year</option>
                                            <?php
                                            for ($i = date('Y') + 1; $i > 1950; $i--) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class="" for="schedule">Schedule:</label>
                                    <div class="mt-2">
                                        <input class=" form-control" type="text" name="schedule" id="schedule" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- fires validate function once the button is clicked -->
                        <button type="submit" class="btn btn-primary" name="add_class" onclick="validate();">Submit</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- add student -->
    <div class="modal fade" id="addStudent">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Student</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 py-1">
                            <div class="form-group row">
                                <p id='message' class="text-danger"></p>
                                <label class="" for="lrn">Learner Reference Number:</label>
                                <div class="mt-2">
                                    <input class=" form-control" type="text" name="lrn" id="lrn" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- fires add student function once the button is clicked -->
                    <button type="submit" class="btn btn-primary" name="add_student" onclick="addStudent()">Add Student</button>
                </div>
            </div>
        </div>
    </div>

    <!--remove student the class -->
    <div class="modal fade" id="removeStudent">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Remove Student</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p>Are you sure you want to delete this record?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="deleteRecord" class="btn btn-danger" name="add_student" id="btn_remove_student">Remove</button>
                </div>

            </div>

        </div>
    </div>

    <!--add attendance -->
    <div class="modal fade" id="addAttendance">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Attendance</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row py-2">
                        <div class="card-body">
                            <div class="form-check ">
                                <input class="form-check-input me-2" type="checkbox" value="yes" name="isTeacher" id="isTeacher" checked disabled />
                                <label class="form-check-label" for="isTeacher">
                                    Check if (Present)
                                </label>
                            </div>
                            <div class="form-check ">
                                <input class="form-check-input me-2" type="checkbox" value="yes" name="isTeacher" id="isTeacher" disabled />
                                <label class="form-check-label" for="isTeacher">
                                    Un-Check if (Absent)
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <p id='attendance_validate_message' class="text-danger"></p>
                        <label class="" for="date">Date</label>
                        <input class=" form-control" type="date" name="date" id="date" require>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="" for="attendance_list">Student Names</label>
                            <div class="row" id="attendance_list">
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <!-- fires add attendance when the button is clicked -->
                        <button type="submit" class="btn btn-primary" name="add_attendance" onclick="addAttendance()">Add Attendance</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
</body>

<script>
    // run all of this function once finish loading
    $(document).ready(function() {
        getStudent()
        delete_record()
        attendance()
        getAttendanceTable()
    });

    // add student function
    function addStudent() {
        // get value using id
        let lrn = $("#lrn").val();
        let school_year = $("#school_year").val()

        // check if the lrn is blank or empty
        if (lrn == "") {
            $("#message").html("Please fill in the Blank!");
        } else {
            // sent ajax post request to add_student.php with lrn and class id
            $.ajax({
                url: "add_student.php",
                method: "post",
                data: {
                    lrn,
                    class_id: school_year
                },
                success: function(data) {
                    //convert the response to json
                    data = $.parseJSON(data);
                    // is  status is succes display the data(table) to div using id
                    if (data.status == "success") {
                        getStudent()
                        $('#addStudent').modal('toggle');
                    } else {
                        // else display error
                        alert(data.message)
                    }
                },
            });
        }
    }

    //class members
    function getStudent() {
        // call get attendance function
        getAttendanceTable();
        // get active school year
        let school_year = $("#school_year").val()
        // send ajax request to get_class_member.php with class id
        $.ajax({
            url: "get_class_member.php",
            method: "post",
            data: {
                class_id: school_year
            },
            success: function(data) {
                // convert response to json
                data = $.parseJSON(data);
                if (data.status == "success") {
                    // append the data(table) to the div the id of table
                    $("#table").html(data.html);
                }
            },
        });
    }

    // Remove student from the class
    function delete_record() {
        $(document).on("click", "#btn_del", function() {
            // get the id in the active(this) button
            var student_id = $(this).attr("data-id1");
            // show modal
            $("#removeStudent").modal("show");
            // fires when ths user confirm the deletion of record
            $(document).on("click", "#btn_remove_student", function() {
                // send ajax request to remove_student.php with student id 
                $.ajax({
                    url: "remove_student.php",
                    method: "post",
                    data: {
                        student_id
                    },
                    success: function(data) {
                        data = $.parseJSON(data);
                        if (data.status == "success") {
                            // if request is success call the get student function to refresh the table
                            getStudent()
                            $("#removeStudent").modal("hide");
                        } else {
                            alert(data.message)
                        }
                    },
                });

            });
        });
    }
    // declare an array for holding id of absent student
    var attendance_list = []

    function addAttendance() {
        // get current school year
        let school_year = $("#school_year").val()
        // get date of attendance
        let date = $("#date").val()
        // / convert array of absent student(id) to string
        let absent = JSON.stringify(attendance_list)
        // check if the date is empty
        if (date == "") {
            $("#attendance_validate_message").html("Please Insert Date!");
        } else {
            // send ajax request to add_attendance.php with class id array of absent student and date
            $.ajax({
                url: "add_attendance.php",
                method: "POST",
                data: {
                    class_id: school_year,
                    absent,
                    date
                },
                success: function(data) {
                    //call getAttendanceTable() to refresh the table
                    getAttendanceTable()
                    $("#addAttendance").modal("hide");
                },
            });
        }
    }


    function attendance() {
        // fires when check box in attendance modal is click
        $(document).on("click", "#student", function() {
            // get student id for this(current instance)
            var student_id = $(this).val();

            // check if id is in the list
            // if yes remove if not add
            if (attendance_list.includes(student_id)) {
                attendance_list = attendance_list.filter((item) => {
                    return item != student_id;
                });
            } else {
                attendance_list.push(student_id)
            }
        });
    }

    // get attendance list(checkbox and name)
    function getAttendanceList() {
        let school_year = $("#school_year").val()
        // send ajax request to  get_attendance_list.php with class id to get all member of the class
        $.ajax({
            url: "get_attendance_list.php",
            method: "GET",
            data: {
                class_id: school_year
            },
            success: function(data) {
                //convert the response to json
                data = $.parseJSON(data);
                if (data.status == "success") {
                    // append the response to div with id of #attendance_list
                    $("#attendance_list").html(data.html);
                }
            },
        });
    }

    // get attendance table
    function getAttendanceTable() {
        // get current school year
        let school_year = $("#school_year").val()
        // send ajax request to get_attendance_table.php with class id
        $.ajax({
            url: "get_attendance_table.php",
            method: "GET",
            data: {
                class_id: school_year
            },
            success: function(data) {
                // convert the response to json
                data = $.parseJSON(data);
                if (data.status == "success") {
                    // append the response to div with id of attendance_table
                    $("#attendance_table").html(data.html);
                }
            },
        });
    }
</script>

<script>
    // add class validation
    function validate() {
        let dateFrom = document.getElementById("date_from");
        let txtValue1 = dateFrom.value;
        let dateTo = document.getElementById("date_to");
        let txtValue2 = dateTo.value;
        let sched = document.getElementById("schedule");
        let txtValue3 = sched.value;
        if (txtValue1 == "" || txtValue2 == "" || txtValue3 == "") {
            $("#class_validate_message").html("All The Field are Required!");
        }
    }
</script>
<script src="js/sweetalert2.js"></script>
<?php
if (isset($_SESSION['status_success'])) {
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'success',
            title: 'Record Successfuly Added!'
        })
    </script>
<?php
    unset($_SESSION['status_success']);
}
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        Toast.fire({
            icon: 'error',
            title: 'Already have a class for this school year!(change this later)'
        })
    </script>
<?php
    unset($_SESSION['status']);
}

?>

</html>