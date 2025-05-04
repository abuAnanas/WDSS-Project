<?php require 'layout/header.php'; ?>
    <?php require 'layout/navbar.php';?>

    <ul>
        <li><a href="crud/read.php"><strong>Read</strong></a> - find a user</li>
        <li><a href="crud/update.php"><strong>Update</strong></a> - edit a user</li>
        <li><a href="crud/delete.php"><strong>Delete</strong></a> - delete a user</li>
    </ul>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    
    <?php
        include 'DBconfig.php';
    ?>

</body>
</html>
