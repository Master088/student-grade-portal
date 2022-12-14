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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="icon" href ="img/logo.png" class="icon">
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
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
        <a class="navbar-brand text-white">Classroom Management System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class=" mt-3">
        <h2 class="text-center">My Subject</h2>
    </div>
    <div class="container-fluid" style="margin-top: 8vh">
        <div class="row row-cols-1 row-cols-md-4">
            <!-- get all subject of the teacher using teacher id -->
            <?php
            $sql = "SELECT *
                FROM subject
                INNER JOIN teacher ON subject.teacher_id=teacher.teacher_id 
                WHERE subject.teacher_id = " . $_SESSION['id'];

            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                // loop to display all subject of teacher
                while ($row = mysqli_fetch_assoc($res)) { ?>
                    <div class="col mb-4">
                        <div class="card h-100">
                            <?php
                            if($row['subject_title'] == "Math"){?>
                                <img src="img/math_img.png" class="card-img-top" alt="math_img" style="height: 25vh; object-fit: cover;">
                           <?php }?>
                           <?php
                           if($row['subject_title'] == "English"){?>
                                <img src="img/english_img.png" class="card-img-top" alt="english_img" style="height: 25vh; object-fit: cover;">
                           <?php }?>
                           <?php
                           if($row['subject_title'] == "Science"){?>
                                <img src="img/science_img.png" class="card-img-top" alt="science_img" style="height: 25vh; object-fit: cover;">
                           <?php }?>
                           <?php
                           if($row['subject_title'] == "Filipino"){?>
                                <img src="img/filipino_img.png" class="card-img-top" alt="filipino_img" style="height: 25vh; object-fit: cover;">
                           <?php }?>
                           <?php
                           if($row['subject_title'] == "Mapeh"){?>
                                <img src="img/mapeh_img.png" class="card-img-top" alt="mapeh_img" style="height: 25vh; object-fit: cover;">
                           <?php }?>
                            <div class="card-body">
                                <b>
                                    <p class="card-title"> <?php echo $row['subject_title']; ?></p>
                                </b>
                                <p class="card-text">Teacher: <?php echo $row['fullname']; ?></p>
                                <p class="card-text"></i> <?php echo $row['grade_lvl']; ?></b> </p>
                                <a href="<?php echo 'subject.php?subject_id=' . $row['subject_id'] ?>" class="btn btn-primary">View Details</a>

                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</body>

</html>