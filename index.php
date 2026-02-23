<?php include("partials.front\menu.php"); ?>

    <section id="home" class="hero_section section">
        <div class="container">
            <div class="heroleft">
                <h1>Are <span class="red">you</span> starving?</h1>
                <p><span class="cursive">Don't wait!</span> Within a few clicks, find meals that are accessible near you</p>
                <a href="order.php" class="button">Order Now</a>    
            </div>
        </div>
    </section>

    <section class="about_us section">
        <div class="container">
            <h2>Why Choose Us</h2>
            <p>Fresh ingredients, fast delivery, and flavors you will remember.</p>
            <p>We focus on quality meals, friendly service, and a menu that fits every craving.</p>
            <a href="menu.php" class="button">Explore Menu</a>
        </div>
    </section>
    
    <section id="speciality" class="food_items section">
        <div class="container">
            <h2>Our Specialities</h2>
            <a href="categories.php">
            <div class="items">
                <div class="item">
                    <img src="images\chicken-biryani.jpg" alt="Chicken Biryani"/>
                    <h3>Chicken Biryani</h3>
                    <button class="whitebtn">Order</button>
                </div>
                <div class="item">
                    <img src="images\food3.jpg" alt="Paneer"/>
                    <h3>Kadai Paneer</h3>
                    <button class="whitebtn">Order</button>
                </div>
                <div class="item">
                    <img src="images\food4.jpg" alt="Paneer Biryani"/>
                    <h3>Paneer Biryani</h3>
                    <button class="whitebtn">Order</button>
                </div>
            </div>
            </a>
        </div>
    </section>

    <section id="menubtn" class="see-menu">
        <div class="menubtn">
            <a href="menu.php" class="button foodiebtn">See Menu</a>
        </div>
    </section>

    <section id="app" class="testimonials section">
        <div class="container">
            <h2>What Our Customers Say</h2>
            <div class="testimonial">
                <p>"The food is amazing and the service is outstanding. Highly recommend!"</p>
                <span>- John Doe</span>
            </div>
            <div class="testimonial">
                <p>"A wonderful dining experience with a great variety of dishes."</p>
                <span>- Jane Smith</span>
            </div>
        </div>
    </section>

<?php include('partials.front\footer.php'); ?>
