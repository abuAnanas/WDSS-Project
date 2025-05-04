    <?php require 'layout/header.php'; ?>
    <?php require 'layout/navbar.php';?>

    <div class="jumbotron">
        <div class="container">
            <?php 
                $welcomeMessage = 'PC Build Experience Simplified For All.';
                $webInfo = 'Whether you are a beginner or a veteran looking to build a PC, look no further.
                Here at CustomBuilt. we aim to provide a memorable experience for all when it comes to building 
                their PC.';
            ?>

            <h1><?php echo $welcomeMessage ?></h1>

            <p><?php echo $webInfo ?></p>

            <p><a class="btn btn-primary btn-lg">Learn more &raquo;</a></p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h2>Trending Builds</h2>

                <p> </p>

                <p><a class="btn btn-default" href="#">View details &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Completed Builds</h2>

                <p></p>

                <p><a class="btn btn-default" href="#">View details &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Budget Builds</h2>

                <p></p>

                <p><a class="btn btn-default" href="#">View details &raquo;</a></p>
            </div>
        </div>

        <?php require 'layout/footer.php';?>
    <!-- /container -->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    
    <?php
        include 'DBconfig.php';
    ?>



</body>
</html>
