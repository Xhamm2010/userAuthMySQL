<?php
session_start();
require_once "../config.php";

//========================================================================
//register user
//========================================================================                
function registerUser($fullnames, $email, $password, $gender, $country)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    //check if user with this email already exist in the database
    $sql = "INSERT INTO Students(`full_names`, `country`, `email`, `gender`, `password`) 
   VALUES(?,?,?,?,?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $fullnames, $country,  $email, $gender, $password);

    //set parameter
    $fullnames = $_POST['fullnames'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];

    $stmt->execute();
    echo "<script> alert('New Record Successfully Created') </script>";
    $stmt->close();
    $conn->close();
}
//=============================================================================
//login users
//=============================================================================


function loginUser($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();

    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM students
                WHERE email = '$email' AND password = '$password' LIMIT 1 ";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
        }
    }
    //if it does, check if the password is the same with what is given
    if ($data['email'] === $email && $data['password'] === $password) {
        $_SESSION['username'] = $data['full_names'];
        echo "<script> alert('Login Successful') </script>";
        header("Location: ../dashboard.php");
        die();
    } else {
        header("Location: ../forms/login.html");
        echo "<script> alert('Could Not Login') </script>";
    }
    $conn->close();
}
//==========================================================================
//Reset Password
//==========================================================================


function resetPassword($email, $password)
{
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    $sql = "SELECT * FROM students
    WHERE email = '$email' LIMIT 1 ";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        //if it does, replace the password with $password given
        if ($data) {
            if ($data['email'] === $email) {
                $update_sql = "UPDATE students 
                                SET password = '$password'
                                WHERE email = '$email'";
                mysqli_query($conn, $update_sql);
                echo "<script> alert('Password Reset Successful') </script>";
                die();
            }
        }
    }

    echo "<script> alert('User Does Not Exist') </script>";
    $conn->close();
}
//=========================================================================
//Get All User
//=========================================================================

function getusers()
{
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo "<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if (mysqli_num_rows($result) > 0) {
        while ($data = mysqli_fetch_assoc($result)) {
            //show data
            echo "<tr style='height: 30px'>" .
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] .
                "</td> <td style='width: 150px'>" . $data['country'] .
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                "value=" . $data['id'] . ">" .
                "<td style='width: 150px'> <button type='submit', name='delete'><a href='delete.php?all=".$data['id']."'> DELETE </a></button>" .
                "</tr>";
        }
        echo "</table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

function deleteaccount($id)
{
    $conn = db();
    //delete user with the given id from the database
    $conn = db();

if (isset($_GET['all'])) {
    $all = $_GET['all'];
    $sql = "DELETE FROM students
            WHERE id = '$all' ";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo "<script> alert('Delete Successful') </script>";
    }else{
        die(mysqli_error($conn));
    }
}

    
}




