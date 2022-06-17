<?php
include_once "../config.php";
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
