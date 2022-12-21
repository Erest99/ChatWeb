<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password))
    {
       // check if email is valid
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        { //if it is
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");//search email in DB
            if(mysqli_num_rows($sql) > 0)
            { //email already used
                echo "$email - This email already exist!";
            }
            else
            {
                //check if image is uploaded
                if(isset($_FILES['image']))
                {  //if yes
                    $img_name = $_FILES['image']['name']; //getting user uploaded img name
                    $img_type = $_FILES['image']['type']; //getting user uploaded img type
                    $tmp_name = $_FILES['image']['tmp_name']; //temporary name to save/move file in folder
                    
                    //getting extension of image
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode); //this is an extension
    
                    //allowed image extensions
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($img_ext, $extensions) === true) // if image has allowed extension
                    {
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true)
                        {
                            $time = time(); //getting current time -> creating unique name for file
                            $new_img_name = $time.$img_name; //adding time before name of the image
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)) //if succesfuly moved file to folder
                            {
                                $ran_id = rand(time(), 100000000); //creating random user id
                                $status = "Active now"; //status after loging in
                                $encrypt_pass = md5($password);
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                if($insert_query) //if data is inserted
                                {
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0)
                                    {
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>