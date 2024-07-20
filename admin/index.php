<?php include('partials/menu.php'); ?>

        <div class="main-content">
            <h1>DASHBOARD</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
            ?>
            <br><br>

            <div class="container">
                <div class="box1">
                    <h1>5</h1>
                    <br />
                    Categories
                </div>
                <div class="box1">
                    <h1>5</h1>
                    <br />
                    Categories
                </div>
                <div class="box1">
                    <h1>5</h1>
                    <br />
                    Categories
                </div>
                <div class="box1">
                    <h1>5</h1>
                    <br />
                    Categories
                </div>                                                
            </div>
        </div>
<?php include('partials/footer.php'); ?>