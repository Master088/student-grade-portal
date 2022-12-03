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

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

<style>

</style>

<link rel="stylesheet" href="style.css">

<body>

    <nav class="navbar navbar-light bg-dark">
        <a class="navbar-brand text-white">Student Record System</a>
        <form action="logout.php" method="POST">
            <button type="submit" name='logout' class="btn btn-danger  "> <i class="bi bi-person-dash-fill"></i> Logout</button>
        </form>
    </nav>

    <div class=" mt-3">
        <h2 class="text-center">My Subject</h2>
    </div>
    <div class="container-fluid" style="margin-top: 8vh">
        <div class="row row-cols-1 row-cols-md-4">

            <?php
            $sql = "SELECT *
                FROM subject
                INNER JOIN teacher ON subject.teacher_id=teacher.teacher_id 
                WHERE subject.teacher_id = " . $_SESSION['id'];

            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_assoc($res)) { ?>
                    <div class="col mb-4">
                        <div class="card h-100">
                            <img src="img/2.png" class="card-img-top" alt="..." style="height: 25vh; object-fit: cover;">
                            <div class="card-body">
                                <b>
                                    <p class="card-title"> <?php echo $row['subject_title']; ?></p>
                                </b>


                                <p class="card-text">Teacher <?php echo $row['fullname']; ?></p>
                                <p class="card-text"></i> <?php echo $row['grade_lvl']; ?></b> </p>
                                <!-- <a href="location_details.php" class="btn btn-primary">Book Now</a> -->
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
</script>

</html>