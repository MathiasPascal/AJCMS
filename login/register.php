<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../fontawesome/css/all.css">
    <script src="../js/sweetalert.min.js"></script>

    <style type="text/css">
        .login-form {
            width: 390px;
            margin: 50px auto;
        }

        .login-form form {
            margin-bottom: 15px;
            background: #f7f7f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .login-form h2 {
            margin: 0 0 15px;
        }

        .form-control,
        .btn {
            min-height: 38px;
            border-radius: 2px;
        }

        .btn {
            font-size: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <h1>Register</h1>
        <form action="../actions/register.php" method="post" autocomplete="off">
            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i></label>
                <input type="text" name="username" placeholder="Full name" id="username" required autofocus pattern="[A-Za-z\s\\-\\']{3,}" title="Name should contain only letters, spaces, hyphens, and apostrophes and be at least 3 characters long">
            </div>
            <div class="form-group">
                <label for="email"><i class="fas fa-envelope"></i></label>
                <input type="email" name="email" placeholder="Email" id="email" required pattern="^[a-z0-9\\-\\']+@ashesi\.edu\.gh$" title="Email should be in the format: FirstNameInitialLastName@ashesi.edu.gh">
            </div>
            <div class="form-group">
                <label for="id_number"><i class="fas fa-id-card"></i></label>
                <input type="text" name="id_number" placeholder="ID Number" id="id_number" required pattern="[A-Za-z0-9]+" title="ID Number should contain only letters and numbers">
            </div>
            <div class="form-group">
                <label for="role"><i class="fas fa-user-tag"></i></label>
                <select class="form-control" name="role_id" id="role" required>
                    <option value="0">Select Role</option>
                    <?php
                    include '../actions/get_all_roles.php';
                    foreach ($roles as $role) {
                        echo "<option value='" . $role['id'] . "'>" . $role['role_name'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="password"><i class="fas fa-lock"></i></label>
                <input type="password" name="password" placeholder="Password" id="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
            </div>
            <div class="form-group">
                <label for="confirm_password"><i class="fas fa-lock"></i></label>
                <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block" id="submit" style="background-color: #57923d; color: white;">Register</button>
            </div>
        </form>
        <p class="text-center"><a href="login.php">Already have an account? Login</a></p>
    </div>

    <script>
        document.getElementById("submit").addEventListener("click", function(event) {
            event.preventDefault();
            var password = document.getElementById("password").value;
            var confirm_password = document.getElementById("confirm_password").value;

            if (password != confirm_password) {
                swal("Passwords do not match", {
                    icon: "error",
                });
                return;
            }
            if (checkEmail() == "false") {
                swal("Only Ashesi email addresses are allowed", {
                    icon: "error",
                });
                return;
            }
            var form = document.querySelector('form');
            var formData = new FormData(form);
            $.ajax({
                url: '../actions/register.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    if (data["register"] === "success") {
                        swal("Registration Successful", {
                            icon: "success",
                        }).then(() => {
                            window.location.href = '../login/login.php';
                        });
                    } else {
                        swal(data["message"], {
                            icon: "error",
                        });
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        function checkEmail() {
            var email = document.getElementById("email").value;
            if (email.endsWith("@ashesi.edu.gh")) {
                var atIndex = email.indexOf("@");
                var localPart = email.substring(0, atIndex);
                if (localPart.includes(".")) {
                    return "success";
                } else {
                    return "false";
                }
            }
            return "false";
        };
    </script>
</body>

</html>
