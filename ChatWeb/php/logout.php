<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){                                                                                          //logout id not null
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");   //nastav status na offline
            if($sql){                                                                                                   //pokud byl změněn záznam
                session_unset();                                                                                        //ukonči session a redirectni na login
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>