<?php
session_start();
//==============================================================
// Logout()
//==============================================================
logout();

function logout()
{

    if ($_SESSION['username'] == TRUE) {
        session_unset();
        session_destroy();
        header("Location: ../forms/login.html");
    } else {

        echo "<h1>There is Problem Logging out </h1>";
    }
}
