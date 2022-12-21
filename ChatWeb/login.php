<?php include_once "header.php";?>
    <body>
        <div class = "wrapper">                                                                                    <!--přihlašovací formulář-->
            <section class ="form login">
                <header>RT Chat App</header>
                <form action="#">
                    <div class="error-txt">This is an error message!</div>
                    <div class="field input">
                        <label>Email address</label>
                        <input type="text" name = "email" placeholder="Enter your email">
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name = "password" placeholder="Enter new password" required>
                        <i class ="fas fa-eye"></i>
                    </div>
                    <div class="button">
                        <input type="submit" value = "Login">
                    </div>

                </form>
                <div class ="link">Dont have account? <a href="index.php">Sign up!</a></div>


            </section>
        </div>
        <script src = "javascript/pass-show-hide.js"></script>
        <script src = "javascript/login.js"></script>
    </body>
</html>