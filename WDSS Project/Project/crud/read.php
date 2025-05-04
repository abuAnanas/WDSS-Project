<?php

if (isset($_POST['submit'])) {
    try {
        require_once '../DBconfig.php';

        // Using ? placeholders for mysqli
        $sql = "SELECT * FROM user WHERE username = ?";
        $location = $_POST['username'];

        // Initialize rows variable
        $rows = [];

        // Prepare the statement
        if ($statement = $conn->prepare($sql)) {
            // Bind the parameter for the location (s = string type)
            $statement->bind_param('s', $location);
            // Execute the statement
            $statement->execute();
            // Get the result
            $result = $statement->get_result();

            // Fetch the data
            if ($result->num_rows > 0) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
            }

            // Close the statement
            $statement->close();

        } else {
            throw new Exception("Statement preparation failed");
        }

    } catch (Exception $error) {
        echo $error->getMessage();
    }
}

?>

<?php include "../layout/header.php"; 
require_once '../layout/navbar.php'; 

if (isset($_POST['submit'])) {
    if ($rows && count($rows) > 0) {?>

        <h2>Results</h2>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"]); ?></td>
                        <td><?php echo htmlspecialchars($row["username"]); ?></td>
                        <td><?php echo htmlspecialchars($row["password"]); ?></td>
                        <td><?php echo htmlspecialchars($row["email"]); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
        > No results found for <?php echo htmlspecialchars($_POST['location']); ?>.
    <?php }
} ?>

<h2>Find user based on location</h2>
<form method="post">
    <label for="location">Username</label>
    <input type="text" id="username" name="username">
    <input type="submit" name="submit" value="View Results">
</form>
<a href="../index.php">Back to home</a>
<?php require_once "../layout/footer.php"; ?>

<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
