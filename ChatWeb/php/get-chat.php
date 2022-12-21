<?php 
    session_start();
    if(isset($_SESSION['unique_id'])){                                                                                          //kontrola loginu
        include_once "config.php";
        $outgoing_id = $_SESSION['unique_id'];                                                                                  //id lognutého uživatele
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);                                                 //id uživatele se kterým lognutý konverzuje
        $output = "";
                                                                                                                                //vyber všechny údaje o zprávách a dostupné údaje o recipientovi, kde 
                                                                                                                                //psal lognutý recipientovi nebo "recipient" lognutému
        $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id                            
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){                                                                           //Pro každou zprávu vygeneruj html zobrazení
                if($row['outgoing_msg_id'] === $outgoing_id){
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }else{
                    $output .= '<div class="chat incoming">
                                <img src="php/images/'.$row['img'].'" alt="">
                                <div class="details">
                                    <p>'. $row['msg'] .'</p>
                                </div>
                                </div>';
                }
            }
        }else{
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
        }
        echo $output;
    }else{
        header("location: ../login.php");
    }

?>