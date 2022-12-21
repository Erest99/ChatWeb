<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password))
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))                                                           //kontrola validity emailu
        { //if it is
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");                         //najdi email v DB
            if(mysqli_num_rows($sql) > 0)
            {                                                                                            
                echo "$email - This email already exist!";                                                      //email je již zaregistrován
            }
            else
            {
                if(isset($_FILES['image']))                                                                     //byl uploudnut obrázek?
                {  
                    $img_name = $_FILES['image']['name'];                                                       //název obrázku
                    $img_type = $_FILES['image']['type'];                                                       //typ obrázku
                    $tmp_name = $_FILES['image']['tmp_name'];                                                   //dočasné jmémo pro přesun a operace
                    
                    
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);                                                               //získání koncovky obrázku
    
                    
                    $extensions = ["jpeg", "png", "jpg"];
                    if(in_array($img_ext, $extensions) === true)                                                //kontrola koncovky obrázku
                    {
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true)
                        {
                            $time = time(); 
                            $new_img_name = $time.$img_name;                                                    //tvorba unikátního jména přidáním času
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)) 
                            {
                                $ran_id = rand(time(), 100000000);                                              //tvorba náhodného user id
                                $status = "Active now"; 
                                $encrypt_pass = md5($password);                                                 //vložení dat
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)      
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                if($insert_query)                                                               //pokud se data vložila
                                {
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");     //najdi právě registrovaný řádek podle mailu
                                    if(mysqli_num_rows($select_sql2) > 0)
                                    {
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        $_SESSION['unique_id'] = $result['unique_id'];                           //logni id do session
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