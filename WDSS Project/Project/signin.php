<?php 
    include("DBconfig.php");
    include("layout/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Login</h2>
        
        Username: <br>
        <input type="text" name="username" required><br>

        Password: <br>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get and sanitize user input
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST["password"]; 

        // Corrected SQL query using the correct column name 'username'
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);

        // Check if we found exactly one user with the username
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            // Verify if the entered password matches the stored hashed password
            if (password_verify($password, $user["password"])) {
                echo "Login successful. Redirecting to home page...";
                header("refresh:2;url=index.php"); // Redirect to home after 2 seconds
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User not found.";
        }
    }

    // Close the connection
    mysqli_close($conn);
?>
