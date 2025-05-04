<?php
/**
 * Delete a user
 */

require_once '../DBconfig.php'; // Uses $conn from DBconfig.php

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

$success = "";

// Handle delete request
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM user WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $success = "User " . escape($id) . " successfully deleted.";
        } else {
            echo "Error executing delete: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing delete statement: " . mysqli_error($conn);
    }
}

// Retrieve all users
$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<?php require_once '../layout/header.php'; ?>
<?php include '../layout/navbar.php';?>

<h2>Delete users</h2>
<?php if ($success) echo "<p>$success</p>"; ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo escape($row["username"]); ?></td>
            <td><?php echo escape($row["password"]); ?></td>
            <td><?php echo escape($row["email"]); ?></td>
            <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>">Delete</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="../index.php">Back to home</a>
<?php require_once "../layout/footer.php"; ?>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
