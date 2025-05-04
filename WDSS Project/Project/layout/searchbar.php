<?php include("header.php"); ?>

<form action="Product.php" method="get" class="navbar-form navbar-right">
    <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Search..." 
               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    </div>
    <input type="submit" value="Search" class="btn btn-success">
</form>

<?php
// Check if there is a search term provided in the URL
if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    // If the search term is 'Custom PC Build 1', display the item
    if (strcasecmp($searchTerm, 'Custom PC Build 1') == 0) {
    } else {
        
    }
}
?>
