<?php
require 'config.php';

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];

    // Use prepared statements to prevent SQL injection
    $duplicate = mysqli_prepare($conn, "SELECT * FROM pengguna WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($duplicate, "ss", $username, $email);
    mysqli_stmt_execute($duplicate);
    mysqli_stmt_store_result($duplicate);

    if (mysqli_stmt_num_rows($duplicate) > 0) {
        echo "<script> alert('Username or Email Has Already Been Taken'); </script>";
    } else {
        if ($password == $confirmpassword) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use prepared statement to insert user data
            $query = "INSERT INTO pengguna (nama, email, username, password, role) VALUES (?, ?, ?, ?, 'pembeli')";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPassword);
            mysqli_stmt_execute($stmt);

            echo "<script> alert('Registration Successful'); </script>";
        } else {
            echo "<script> alert('Password Does Not Match'); </script>";
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register form</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="form-container">

        <form action="" method="post">
            <h3>CHATTERBOX</h3>
            <input type="text" name="name" required placeholder="masukkan nama">
            <input type="username" name="username" required placeholder="masukkan username">
            <input type="email" name="email" required placeholder="masukkan email">
            <input type="password" name="password" required placeholder="masukkan password">
            <input type="password" name="confirmpassword" required placeholder="konfirmasi password">

            <input type="submit" name="submit" value="daftar sekarang" class="form-btn">
            <p>sudah punya akun? <a href="login.php">masuk sekarang</a></p>
        </form>

    </div>


    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600&display=swap');

        * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 20;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;

        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            padding-bottom: 60px;
        }

        .container .content {
            text-align: center;
        }

        .container .content h3 {
            font-size: 30px;
            color: #333;
        }

        .container .content h3 span {
            background: crimson;
            color: #fff;
            border-radius: 5px;
            padding: 0 15px;
        }

        .container .content h1 {
            font-size: 50px;
            color: #333;
        }

        .container .content h1 span {
            color: crimson;
        }

        .container .content p {
            font-size: 25px;
            margin-bottom: 20px;
        }

        .container .content .btn {
            display: inline-block;
            padding: 10px 30px;
            font-size: 20px;
            background: #333;
            color: #fff;
            margin: 0 5px;
            text-transform: capitalize;
        }

        .container .content .btn:hover {
            background: crimson;
        }

        .form-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            padding-bottom: 60px;
            background: url("../assets/img/dashboard/omen.jpeg") no-repeat;
            background-size: cover;
            background-position: top;
        }

        .form-container form {
            background: transparent;
            backdrop-filter: blur(50px);
            border: 0px;
            border-bottom: 0px;
            border-radius: 10px 10px 0px 0px;
            padding: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 5);
            border-bottom: none;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            width: 500px;
        }

        .form-container form h3 {
            font-size: 30px;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: crimson;
        }

        .form-container form input,
        .form-container form select {
            background: transparent;
            backdrop-filter: blur(50px);
            width: 100%;
            padding: 10 px 15px;
            font-size: 17px;
            margin: 8px 0;
            border-radius: 5px;
            margin: 10px 0px 10px 0px;
            color: #BD3944;
        }

        .form-container form select option {
            background-color: #fff;
        }

        .form-container form .form-btn {
            padding: 10px;
            font-size: 15px;
            color: white;
            background: #BD3944;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .form-container form .form-btn:hover {
            background: crimson;
            color: #fff;
        }

        .form-container form p {
            margin-top: 10px;
            font-size: 15px;
            color: white;
        }

        .form-container form p a {
            color: crimson;
        }

        .form-container form .error-msg {
            margin: 10px 0;
            display: block;
            background: crimson;
            color: #fff;
            border-radius: 5px;
            font-size: 20px;
            padding: 10px;
        }
    </style>
</body>

</html>