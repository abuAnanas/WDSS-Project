<?php 
    include("DBconfig.php");  
    include("layout/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>Registration</h2>
        
        Username: <br>
        <input type="text" name="username" required><br>

        Password: <br>
        <input type="password" name="password" required><br>

        Email: <br>
        <input type="email" name="email" required><br><br>

        <input type="submit" name="submit" value="Submit">
    </form>
</body>
</html>

<?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize input data
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST["password"];
        $email    = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

        // Check if any field is empty
        if (empty($username) || empty($password) || empty($email)) {
            echo "Please fill in all fields.";
        } else {
            // Check if username already exists using prepared statements
            $check_sql = "SELECT * FROM user WHERE username = ?";
            $stmt = mysqli_prepare($conn, $check_sql);
            mysqli_stmt_bind_param($stmt, "s", $username);  // 's' means string
            mysqli_stmt_execute($stmt);
            $check_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($check_result) > 0) {
                echo "Username already taken. Please choose another.";
            } else {
                // Hash the password
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert the new user into the database using prepared statements
                $sql = "INSERT INTO user (username, password, email) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $username, $hash, $email);

                if (mysqli_stmt_execute($stmt)) {
                    echo "You have successfully been registered. Redirecting to Home page...";
                    header("refresh:3;url=index.php");
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close the connection
    mysqli_close($conn);
?>
