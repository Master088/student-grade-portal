<?php
session_start();
include 'mysql_connect.php';

// prevent unauthenticated user and not student user to access this page
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
if (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $sql = "SELECT * FROM  subject WHERE subject_id=" . $subject_id;
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {

        $subject_details = mysqli_fetch_assoc($res);
    }
}


if (isset($_POST['add_class'])) {

    $school_year = $_POST['date_from'] . "-" . $_POST['date_to'];
    $schedule = $_POST['schedule'];



    $sql = "SELECT * FROM  class where subject_id='$subject_id' AND school_year='$school_year'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        echo '<script>';
        echo "alert('Already have a class for this school year!(change this later)');";
        echo '</script>';
    } else {
        $sql = "INSERT INTO class 
        SET 
        class_id=null,
        school_year='$school_year',
        schedule='$schedule',
        subject_id='$subject_id'
        ";

        if (mysqli_query($conn, $sql)) {
            echo '<script>';
            echo "alert('Add Sucessfully!');";
            echo '</script>';
            header("Refresh:1; url=subject.php?subject_id=" . $subject_id, true, 1);
        } else {
            echo mysqli_error($conn);
            echo '<script>';
            echo "alert('Error !');";
            echo '</script>';
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
        /* background-image: url("img/background.png"); */
        height: 100%;
        font-size: 1em;
        overflow-x: hidden;
        overflow-y: visible;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: #F8FAFB;
    }
</style>

<link rel="stylesheet" href="style.css">

<body>

    <nav class="navbar navbar-light bg-dark">
        <a href="index.php" class="navbar-brand text-white">Student Record System</a>
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
                            <!-- <h4 class=" mx-2">School Year </h4> <button class="btn btn-primary rounded-circle btn-sm" data-bs-toggle="modal" data-bs-target="#addClass"><i class="bi bi-plus-circle-fill"></i></button> -->
                            <h4 class=" mx-2">School Year </h4>
                            <button class="btn btn-info " data-bs-toggle="modal" data-bs-target="#addClass"><i class="bi bi-plus-circle-fill"></i> Add School Year</button>
                            
                        </div>
                        <div class=" mt-2 ">
                            <select class=" form-select" onchange="getStudent()" name="school_year" id="school_year" required aria-label="Default select example">
                                <?php

                                $sql = "SELECT * FROM class WHERE subject_id=" . $subject_id;

                                $res = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_assoc($res)) {  ?>

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
                    <button class="btn btn-info rounded-button mx-2" data-bs-toggle="modal" data-bs-target="#addStudent"><i class="bi bi-person-plus"></i> Add Student</button>
                    <button class="btn btn-info rounded-button mx-2" data-bs-toggle="modal" data-bs-target="#addAttendance" onclick="getAttendanceList()"><i class="bi bi-card-checklist"></i> Add attendance</button>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-3">
        <h2 class="text-center">My Students</h2>
        <div id="table" class="text-dark mx-2"></div>

    </div>
    <div class="container mt-5" >
        <div class="card card-body">
            <h2 class="text-center">Attedance</h2>
            <div id="attendance_table" class="text-dark mx-2"></div>
        </div>
    </div>


    <!-- add class -->
    <div class="modal fade" id="addClass">
        <div class="modal-dialog">
            <form method="POST" action="" >
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Class</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class="" for="date_from">Date from:</label>
                                    <div class=" mt-2">
                                        <select class="form-select" name="date_from" aria-label="Default select example" required>
                                            <option selected disabled>Please Select year</option>
                                            <?php
                                            for ($i = date('Y'); $i > 1950; $i--) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <!-- <div class="invalid-feedback">Please Select Date From.</div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class=" " for="date_to">Date to:</label>
                                    <div class=" mt-2">
                                        <select class=" form-select" name="date_to" aria-label="Default select example" required>
                                            <option selected disabled>Please Select year</option>
                                            <?php
                                            for ($i = date('Y') + 1; $i > 1950; $i--) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                        <!-- <div class="invalid-feedback">Please Select Date To.</div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 py-1">
                                <div class="form-group row">
                                    <label class="" for="schedule">Schedule:</label>
                                    <div class="mt-2">
                                        <input class=" form-control" type="text" name="schedule" id="schedule" required>
                                        <!-- <div class="invalid-feedback">Please Enter Schedule.</div> -->
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add_class" >Submit</button>
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
                    <button type="submit" class="btn btn-primary" name="add_student" onclick="addStudent()">Add Student</button>
                </div>

            </div>

        </div>
    </div>

    <!--remove student -->
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

                <!-- Modal footer -->
                <!-- <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="add_student" id="btn_remove_student">Remove</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div> -->
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
                        <label class="" for="date">Date</label>
                        <input class=" form-control" type="date" name="date" id="date" require>
                    </div>
                    
                    <div class="row">
                        <div class="col" >
                             <label class="" for="attendance_list">Student Names</label>
                            <div class="row" id="attendance_list" >
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="add_attendance" onclick="addAttendance()">Add Attendance</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>

        </div>
    </div>
</body>



<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    };


    var loadFile2 = function(event) {
        var image = document.getElementById('output2');
        image.src = URL.createObjectURL(event.target.files[0]);
        image.setAttribute("class", "out");
    }



    $(document).ready(function() {
        getStudent()
        delete_record()
        attendance()
        getAttendanceTable()
    });

    function addStudent() {

        // add validation here for lrn
        let lrn = $("#lrn").val();
        let school_year = $("#school_year").val()

        
        if(lrn == ""){
            $("#message").html("Please fill in the Blank!");
        }else{
            $.ajax({
            url: "add_student.php",
            method: "post",
            data: {
                lrn,
                class_id: school_year
            },
            success: function(data) {
                console.log("here", data)
                data = $.parseJSON(data);
                if (data.status == "success") {
                    getStudent()
                    $('#addStudent').modal('toggle');
                } else {
                    alert(data.message)
                }
            },
        });
        }


    }

    function getStudent() {

        let school_year = $("#school_year").val()

        $.ajax({
            url: "get_class_member.php",
            method: "post",
            data: {
                class_id: school_year
            },
            success: function(data) {
                console.log(data);
                data = $.parseJSON(data);
                if (data.status == "success") {
                    // console.log(data.html);
                    $("#table").html(data.html);
                }
            },
        });


    }

    ///delete record
    function delete_record() {
        $(document).on("click", "#btn_del", function() {
            var student_id = $(this).attr("data-id1");
            $("#removeStudent").modal("show");
            $(document).on("click", "#btn_remove_student", function() {

                $.ajax({
                    url: "remove_student.php",
                    method: "post",
                    data: {
                        student_id
                    },
                    success: function(data) {
                        data = $.parseJSON(data);
                        if (data.status == "success") {
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
    var attendance_list = []

    function addAttendance() {
        let school_year = $("#school_year").val()
        let date = $("#date").val()

        let absent = JSON.stringify(attendance_list)

        $.ajax({
            url: "add_attendance.php",
            method: "POST",
            data: {
                class_id: school_year,
                absent,
                date
            },
            success: function(data) {
                getAttendanceTable()
                $("#addAttendance").modal("hide");
            },
        });

    }
    ///delete record
    function attendance() {
        $(document).on("click", "#student", function() {
            var student_id = $(this).val();
            console.log(student_id)
            // check if id is in the list
            // if yes remove if not add

            if (attendance_list.includes(student_id)) {
                attendance_list = attendance_list.filter((item) => {
                    return item != student_id;
                });
            } else {
                attendance_list.push(student_id)
            }
            console.log(attendance_list)
        });
    }

    function getAttendanceList() {

        let school_year = $("#school_year").val()

        $.ajax({
            url: "get_attendance_list.php",
            method: "GET",
            data: {
                class_id: school_year
            },
            success: function(data) {
                console.log(data);
                data = $.parseJSON(data);
                if (data.status == "success") {
                    $("#attendance_list").html(data.html);
                }
            },
        });


    }

    function getAttendanceTable() {
        let school_year = $("#school_year").val()

        $.ajax({
            url: "get_attendance_table.php",
            method: "GET",
            data: {
                class_id: school_year
            },
            success: function(data) {
                console.log(data);
                data = $.parseJSON(data);
                if (data.status == "success") {
                    $("#attendance_table").html(data.html);
                }
            },
        });


    }
</script>

 <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict';

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            }, false);
        });
        })();
    </script>

</html>