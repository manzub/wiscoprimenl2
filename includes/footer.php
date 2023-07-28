<?php $page = basename($_SERVER['REQUEST_URI'], '?'.$_SERVER['QUERY_STRING']);  ?>

<?php if (!in_array($page, array('projects', 'project-info')) && $page != 'wiscoprimenl') { ?>
<section class="get_quote_area yellow_get_quote">
    <div class="container">
        <div class="pull-left">
            <h4>Looking for a quality and affordable constructor for your next project?</h4>
        </div>
        <div class="pull-right">
            <a class="get_btn_black" href="contactus">GET A QUOTE</a>
        </div>
    </div>
</section>

<?php } else if ($page != 'wiscoprimenl') { ?>

<section class="get_quote_area project_contact">
    <div class="container">
        <div class="pull-left">
            <h3>Save Your Money </h3>
            <h4>Call us today or Contact us to get started your project.. </h4>
        </div>
        <div class="pull-right">
            <a class="get_btn_black" href="contactus">Contact Us</a>
        </div>
    </div>
</section>

<?php } ?>

<footer class="footer_area">
    <div class="footer_widgets_area">
        <div class="container">
            <div class="row footer_widgets_inner">
                <div class="col-md-3 col-sm-6">
                    <aside class="f_widget about_widget">
                        <h3 href="#"><strong><b class="text-theme">WISCO</b>PRIME</strong></h3>
                        <p><?php echo substr(mysqli_fetch_assoc(selectQuery("SELECT * FROM settings WHERE name = 'aboutus'"))['value'], 0, 150).'...' ?></p>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </aside>
                </div>
                <div class="col-md-3 col-sm-6">
                    <aside class="f_widget recent_widget">
                        <div class="f_w_title">
                            <h3>Recent Posts</h3>
                        </div>
                        <div class="recent_w_inner">
                            <?php
                            $query = selectQuery("SELECT * FROM blogposts ORDER BY date_posted DESC LIMIT 2");
                            while ($row=mysqli_fetch_assoc($query)) { ?>
                                <div class="media">
                                    <div class="media-left">
                                        <img src="<?php echo $GLOBALS['path'].$row['cover'] ?>" width="95px" alt="">
                                    </div>
                                    <div class="media-body">
                                        <a href="blogpost?m=<?php echo $row['slug'] ?>"><p><?php echo $row['title'] ?></p></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </aside>
                </div>
                <div class="col-md-3 col-sm-6">
                    <aside class="f_widget address_widget">
                        <div class="f_w_title">
                            <h3>Office Address</h3>
                        </div>
                        <div class="address_w_inner">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="media-body">
                                    <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'address'");
                                    while ($row = mysqli_fetch_assoc($query)) { ?>
                                        <p><?php echo $row['value'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="media-body">
                                    <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'phone' ");
                                    while ($row = mysqli_fetch_assoc($query)) { ?>
                                        <p><?php echo $row['value'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="media-body">
                                    <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'mailto'");
                                    while ($row = mysqli_fetch_assoc($query)) { ?>
                                        <p><?php echo $row['value'] ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="col-md-3 col-sm-6">
                    <aside class="f_widget give_us_widget">
                        <h5>Give Us A Call</h5>
                        <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'phone' LIMIT 1");
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <h4><?php echo $row['value'] ?></h4>
                        <?php } ?>
                        <h5>or</h5>
                        <a class="get_bg_btn" href="#">GET A QUOTE</a>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_copy_right">
        <div class="container">
            <h4>
                Copyright ©<script>document.write(new Date().getFullYear());</script> All rights reserved
            </h4>
        </div>
    </div>
</footer>

<a href="<?php echo $GLOBALS['path'] ?>assets/WISCOPRIME.pdf" target="_blank" rel="noreferrer" id="scroll-top" title="Back to Top" class="show">
    <i class="fa fa-arrow-down"></i>Download Profile
</a>