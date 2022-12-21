<?php 
    session_start();
    include_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($email) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");                                             //Vyber řádky kde se schoduje email
        if(mysqli_num_rows($sql) > 0){                                                                                          //pokud alespoň jeden existuje, vezmi první 
            $row = mysqli_fetch_assoc($sql);
            $user_pass = md5($password);                                                                                        //zakóduj heslo
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){                                                                                       //porovnej zadané heslo s heslem v DB
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");     //update status in DB
                if($sql2){                                                                                                      //pokud se našel uživatel podle unique id
                    $_SESSION['unique_id'] = $row['unique_id'];                                                                 //nastav id session (příznak lognutého uživatele)
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";                                                             //jinak -> neplatná data v DB
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$email - This email is not registered!";
        }
    }else{
        echo "All input fields are required!";
    }
?>