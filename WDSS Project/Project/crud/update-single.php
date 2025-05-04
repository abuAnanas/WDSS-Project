<?php
require_once '../DBconfig.php'; // MySQLi connection ($conn)

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$success = false;

// Handle form submission
if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE user SET 
                username = '$username', 
                password = '$password', 
                email = '$email' 
            WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        $success = true;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Fetch user data for editing
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM user WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "Invalid user ID.";
    exit;
}
?>

<?php require_once '../layout/header.php'; ?>
<?php require_once '../layout/navbar.php'; ?>

<h2>Edit User</h2>

<?php if ($success) : ?>
    <p><?php echo escape($user['username']); ?> successfully updated.</p>
<?php endif; ?>

<form method="post">
    <label for="id">ID</label>
    <input type="text" name="id" id="id" value="<?php echo escape($user['id']); ?>" readonly>

    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="<?php echo escape($user['username']); ?>">

    <label for="password">Password</label>
    <input type="text" name="password" id="password" value="<?php echo escape($user['password']); ?>">

    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="<?php echo escape($user['email']); ?>">

    <input type="submit" name="submit" value="Submit">
</form>

<a href="update.php">Back to update list</a>

<?php require_once '../layout/footer.php'; ?>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
