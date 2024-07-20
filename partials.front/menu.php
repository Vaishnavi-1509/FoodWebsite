<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="images\V (2).png" alt="Logo">
        </div>
        <nav class="nav">
            <ul>
                <li><a href="<?php echo SITEURL; ?>index.php">Home</a></li>
                <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a></li>
                <li><a href="<?php echo SITEURL; ?>menu.php">Menu</a></li>
                <li><a href="<?php echo SITEURL; ?>order.php">Order</a></li>
                <li><a href="<?php echo SITEURL; ?>">App</a></li>
            </ul>
        </nav>
        <div class="mobilemenu">
            <i class="fa-solid fa-bars"></i>
        </div>
    </header>

    <nav class="mobilenav">
        <ul>
            <li><a href="index.html#home">Home</a></li>
            <li><a href="index.html#speciality">Speciality</a></li>
            <li><a href="order.html">Order</a></li>
            <li><a href="index.html#app">App</a></li>
        </ul>
    </nav>