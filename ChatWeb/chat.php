<?php 
  session_start();                                                //zapni session
  include_once "php/config.php";                                  //includni nastavení 
  if(!isset($_SESSION['unique_id'])){                             //pokud session nemá id (není přihlášený uživatel) -> redirect na login
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php                                                                                 //ZÍSKEJ ÚDAJE UŽIVATELE Z DB
          $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);                      //získej z $conn user-id bez speciálních znaků
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");     //vyber z DB všechny záznamy, kde sloupec unique_id = user_id
          if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);                                                  //pokud byl nález, vyber první řádek
          }else{
            header("location: users.php");                                                    //jinak redirect na user menu
          }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>           <!-- zpět button-->
        <img src="php/images/<?php echo $row['img']; ?>" alt="">                              <!--zobraz obrázek, jméno a status uživatele-->
        <div class="details">
          <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">                                                                  <!-- připravená oblast pro zobrazování zprávy-->

      </div>
      <form action="#" class="typing-area">                                                   <!-- textbox pro psaní správ a button pro odeslání-->
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>
