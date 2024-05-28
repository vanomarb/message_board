<?php
if (
    array_key_exists('username', $_POST) &&
    array_key_exists('password', $_POST)
) {
    if ($_POST["username"] == "admin" && $_POST["password"] == "admin123") {
        // set login to true
        $_SESSION["is_logged_in"] = true;
        $_SESSION["first_name"] = "John";
        $_SESSION["last_name"] = "Doe";
        $_SESSION["last_login_time"] = time();
        
        // redirect to another page
        echo "<script>
            window.location.href = '?page=home';
        </script>";
        die();

    } else {
        echo "Invalid username or password";
    }
}
?>
<div class="container">
    <h2>Login Form</h2>
    <form action="?page=login" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>