<?php require_once "core/init.php" ?>

    <!-- html starts here -->
<?php require_once "includes/styles.php" ?>
<?php require_once "includes/navbar.php" ?>

<section class="who_we_are_area" style="margin-bottom: 100px">
    <div class="container">
        <div class="row who_we_inner">
            <div class="col-md-5">
                <div class="who_we_left_content">
                    <div class="main_w_title">
                        <h2>Who <br class="title_br"> We Are?</h2>
                        <h6>All About Us</h6>
                    </div>
                    <?php
//                    $query = selectQuery("SELECT * FROM settings WHERE name = 'aboutus'");
//                    while ($row = mysqli_fetch_assoc($query)) {
//                        $str = nl2br($row['value']);
//                        echo "<p style='margin-bottom: 50px'>$str</p>";
//                    }
                    ?>
                    <div class="d-block">
                        <p style="font-size: 17px;margin-bottom: 20px">
                            <strong>WISCO PRIME NIGERIA LIMITED</strong> was formed by a young Nigerian professional who have various experiences and was fully registered at corporate Affairs Commission in 2009 under the Companies and allied Matter Decree No. 1 of 1990 out of a keen desire of making positive contributions to the development of our country.
                        </p>
                        <p style="font-size: 17px;margin-bottom: 20px">Though the Company is young or newly established, we have complement of personnel who are professionals and experts in their various field of engineering who will bring their well of experience to bear in the way and manner of our job execution.</p>
                        <p style="font-size: 17px;margin-bottom: 20px">We have over the years gathered technical know-how in this field of designing, Civil, Structure, rural electrification, solar products, borehole drilling is to base our efforts in the following directions.</p>
                        <p style="font-size: 17px;margin-bottom: 20px">To enhance the quality of our service to meet the professional need of our customers or clients at the best cost possible.</p>
                        <p style="font-size: 17px;margin-bottom: 20px">The reinforcement of our maintenance support and expertise all along the contract life plan.</p>
                        <p style="font-size: 17px;margin-bottom: 20px">The range of our capabilities are extended internally and partnership to offer more complex services among which are our core services and logistics.</p>
                        <p style="font-size: 17px;margin-bottom: 20px">Our field of activities is established developmentally to operate in Nigeria and confidently with our effort to lift our services to the evolving needs of our clients.</p>
                    </div>
                    <div class="border_bar"></div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="who_we_image">
                    <img src="<?php echo $GLOBALS['path'] ?>assets/img/who-we-x.png" width="100%" alt="">
                </div>
            </div>
        </div>
        <section style="margin: 20vh 0px">
            <div class="our_mission">
                <div class="main_w_title">
                    <h2>Our Mission</h2>
                </div>
                <div class="d-block">
                    <p style="font-size: 17px;margin-bottom: 20px">Is to discover access, evaluate and develop world class growth and procedure of construction and maintenance services required in the public and private sectors.</p>
                    <p style="font-size: 17px;margin-bottom: 20px">To continuously improved in our quality and open communication in the conduct of our activities to meet and conform to the desire ethical, safety and environmental standards.</p>
                    <p style="font-size: 17px;margin-bottom: 20px">Effective management of available resources and assets.</p>
                    <p style="font-size: 17px;margin-bottom: 20px">Continuous effort to improve work process by utilizing efficient technical organizational skills.</p>
                    <p style="font-size: 17px;margin-bottom: 20px">Optimizing relationships with governments and organized private sector.</p>
                    <p style="font-size: 17px;margin-bottom: 20px">Equitable sharing of economic benefits.</p>
                </div>
                <div class="border_bar"></div>
            </div>

            <div style="margin-top: 10vh" class="our_aim">
                <div class="main_w_title">
                    <h2>Our Aim</h2>
                </div>
                <div class="d-block">
                    <p style="font-size: 17px;margin-bottom: 20px">Is to be among the world best in the year 2025 through quality job execution, staff motivation and economic stimulatioon.</p>
                </div>
                <div class="border_bar"></div>
            </div>

        </section>
    </div>
</section>

<?php require_once "includes/footer.php" ?>
<?php require_once "includes/scripts.php" ?>