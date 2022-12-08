<?php include_once "header.php";?>
    <body>
        <div class = "wrapper">
            <section class ="form signup">
                <header>RT Chat App</header>
                <form action="#" enctype = "multipart/form-data">
                    <div class="error-txt"></div>
                    <div class="name-details">
                        <div class="field input">
                            <label>First name</label>
                            <input type="text" name = "fname" placeholder="First name" required>
                        </div>
                        <div class="field input">
                            <label>Last name</label>
                            <input type="text" name = "lname" placeholder="Last name" required>
                        </div>
                    </div>
                    <div class="field input">
                        <label>Email address</label>
                        <input type="text" name = "email" placeholder="Enter your email" required>
                    </div>
                    <div class="field input">
                        <label>Password</label>
                        <input type="password" name = "password" placeholder="Enter new password" required>
                        <i class ="fas fa-eye"></i>
                    </div>
                    <div class="image">
                        <label>Select Image</label>
                        <input type="file" name = "image" required>
                    </div>
                    <div class="button">
                        <input type="submit" value = "Confirm your signup">
                    </div>

                </form>
                <div class ="link">Already signed up? <a href="login.php">Login now</a></div>


            </section>
        </div>
        <script src="javascript/pass-show-hide.js"></script>
        <script src="javascript/signup.js"></script>
    </body>
</html>