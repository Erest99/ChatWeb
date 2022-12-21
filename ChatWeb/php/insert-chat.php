<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){                                                                          //kontrola loginu
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];                                                                  //id lognutého
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);                                 //id recipienta
        $message = mysqli_real_escape_string($conn, $_POST['message']);                                         //obsah zprávy
        if(!empty($message)){                                                                                   //pokud není prázdná, zapiš ji do DB
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }else{
        header("location: ../login.php");
    }


    
?>