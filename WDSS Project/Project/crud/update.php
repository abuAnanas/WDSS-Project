<?php
/**
 * Display users for updating
 */

require_once '../DBconfig.php'; // Uses $conn from MySQLi config

function escape($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

// Fetch users from database
$sql = "SELECT * FROM user";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<?php require_once '../layout/header.php'; ?>
<?php require_once '../layout/navbar.php'; ?>

<h2>Update Users</h2>

<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Update</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?php echo escape($row["id"]); ?></td>
            <td><?php echo escape($row["username"]); ?></td>
            <td><?php echo escape($row["password"]); ?></td>
            <td><?php echo escape($row["email"]); ?></td>
            <td><a href="update-single.php?id=<?php echo escape($row["id"]);?>">Edit</a></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="../index.php">Back to home</a>

<?php require_once "../layout/footer.php"; ?>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
