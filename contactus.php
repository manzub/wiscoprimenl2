<?php
require_once "core/init.php";

if (isset($_POST['contact_btn'])) {
    $name = htmlspecialchars(htmlentities($_POST['name']));
    $from = $_POST['email'];
    $message = htmlspecialchars(htmlentities($_POST['message']));

    $subject = "Message from <strong>wiscoprimenl.com</strong>";
    $body = "<h4>From: $from</h4><br><h6>Hi i have a query</h6><br><br>$message";

    $query = selectQuery("SELECT * FROM settings WHERE name = 'mailto' LIMIT 1");
    $mailto = mysqli_fetch_assoc($query)['value'];
    sendEmail($mailto, $subject, $body);

    $alert = "Message sent successfully";
    header("refresh:3;url={$GLOBALS['path']}contactus");
}
?>

    <!-- html starts here -->
<?php require_once "includes/styles.php" ?>
<?php require_once "includes/navbar.php" ?>

    <section class="container" style="margin: 200px 0px 100px 0px">
        <div class="row">
            <div class="col-md-8">
                <h1 style="margin-bottom: 20px"><strong>Contact Us</strong></h1>
                <?php if (isset($alert)) { ?>
                <div class="alert alert-info"><?php echo $alert ?></div>
                <?php } ?>
                <form class="row" method="post">
                    <div class="form-group col-md-6">
                        <label for="name">Your name:</label>
                        <input required type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email Address:</label>
                        <input required type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <textarea required rows="8" placeholder="Message" name="message" class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <button name="contact_btn" type="submit" value="submit" class="btn submit_btn form-control">Post Comment</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="sidebar_area">
                    <aside class="right_widget r_post_widget">
                        <div class="r_w_title">
                            <h3>Recent Post</h3>
                        </div>
                        <div class="r_post_inner">
                            <?php
                            $query = selectQuery("SELECT * FROM blogposts ORDER BY date_posted DESC LIMIT 1");
                            if (mysqli_num_rows($query)==0) { echo "Loading... "; }
                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                <div class="r_post_item">
                                    <img src="<?php echo $GLOBALS['path'].$row['cover'] ?>" alt="">
                                    <a href="?m=<?php echo $row['slug'] ?>"><p><?php echo $row['title'] ?></p></a>
                                </div>
                            <?php } ?>
                        </div>
                    </aside>
                    <aside class="right_widget r_social_widget">
                        <div class="r_w_title">
                            <h3>we are social</h3>
                        </div>
                        <ul>
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="https://wa.me/08023253220" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </section>

<?php require_once "includes/footer.php" ?>
<?php require_once "includes/scripts.php" ?>