<?php
    while($row = mysqli_fetch_assoc($query)){                                                           //pro každý řádek query uživatele
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);                                                           //najdi zprávy mezi lognutým uživatelem a uživatelem vybraným z query 
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No message available";      //pokud je víc jak 0 záznamů nahraj zprávu do proměné result
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;               //pokud je message delší jak 28 znaků tak ji zkrať na 28 (pro last seen message)
        if(isset($row2['outgoing_msg_id'])){                                                            //pokud row2 není null
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";                    //pokud je poslední zpráva od lognutého usera -> přidej "you:"
        }else{
            $you = "";
        }
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";                       //nastavení statusu
        ($outgoing_id == $row['unique_id']) ? $hid_me = "hide" : $hid_me = "";                          //aby si nepsal lognutý uživatel sám se sebou

                                                                                                        //vytvoření grafického objektu pro daná data pro přechod na chat
        $output .= '<a href="chat.php?user_id='. $row['unique_id'] .'">                                
                    <div class="content">
                    <img src="php/images/'. $row['img'] .'" alt="">
                    <div class="details">
                        <span>'. $row['fname']. " " . $row['lname'] .'</span>
                        <p>'. $you . $msg .'</p>
                    </div>
                    </div>
                    <div class="status-dot '. $offline .'"><i class="fas fa-circle"></i></div>
                </a>';                                                                                   
    }

?>