<?php require_once "../core/init.php";

if (!isset($_GET['m'])) {
    header("location: {$GLOBALS['path']}blogpost");
}

if (isset($_POST['reply_btn'])) {
    $message = htmlspecialchars(htmlentities($_POST['message']));
//    TODO : fix for php 8 up
    $author = $_SESSION['wiscoprimenl'] ?? rand(0, 9999);
    otherQuery("INSERT INTO blog_replies (commentid, author, reply, date_posted) VALUES ('{$_GET['m']}', '$author', '$message', now())");
    $alert = array();
    if (mysqli_num_rows(selectQuery("SELECT * FROM blog_replies WHERE reply = '$message'"))) {
        $alert[0] = 'success';
        $alert[1] = 'Reply Posted';
        header("refresh:4;url={$GLOBALS['path']}blogpost");
    }else {
        $alert[0] = 'danger';
        $alert[1] = 'Error Occurred';
    }
}

$query = selectQuery("SELECT * FROM blog_comments WHERE id = '{$_GET['m']}'");
while ($row=mysqli_fetch_assoc($query)) {
    $author = getUserInfoById($row['author'], "username") ?: 'Anonymous';
    $str = date_create($row['date_posted']);
    $date = $str->format("Y-m-d H:i:S");
    $message = substr($row['comment'], 0, 10).'...';
}
?>

<?php require_once "../includes/styles.php" ?>

<?php require_once "../includes/navbar.php" ?>

<section class="banner_area" style="background-image: url('<?php echo $GLOBALS['path'] ?>assets/img/banner/single-page-banner3.jpg')">
    <div class="container">
        <div class="banner_inner_text">
            <h4>Blog</h4>
            <ul>
                <li><a href="<?php echo $GLOBALS['path'] ?>blogpost">Blog</a></li>
                <li class="active"><a href="<?php echo $GLOBALS['path'] ?>blogpost">Reply</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="reply_blog" style="padding: 50px 0px">
    <div class="container">
        <div class="alert alert-<?php echo isset($alert) ? $alert[0] : null ?>"><?php echo isset($alert) ? $alert[1] : null ?></div>
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 50px">
                <h3>Reply To: <span class="text-muted"><?php echo "#$author - $date ($message)" ?></span></h3>
            </div>

            <div class="col-md-8">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="">Message:</label>
                        <textarea required name="message" rows="8" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn slider_btn" name="reply_btn" type="submit">POST</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once "../includes/footer.php" ?>

<?php require_once "../includes/scripts.php" ?>
