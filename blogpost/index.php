<?php
require_once "../core/init.php";

if (isset($_POST['comment_btn'])) {
    $postid = $_POST['postid'];
    $comment = htmlspecialchars(htmlentities($_POST['message']));
//    TODO: fix for php 8 upwards
    $author = $_SESSION['wiscoprimenl'] ?? rand(0, 9999);
    otherQuery("INSERT INTO blog_comments (postid, author, comment, date_posted) VALUES ('$postid', '$author', '$comment', now())");
    $alert = array();
    if (mysqli_num_rows(selectQuery("SELECT * FROM blog_comments WHERE comment = '$comment'"))) {
        $alert[0] = 'success';
        $alert[1] = 'Reply Posted';
        header("refresh:4;url={$GLOBALS['path']}blogpost?m=$postid");
    }else {
        $alert[0] = 'danger';
        $alert[1] = 'Error Occurred';
    }
}

$query = isset($_GET['m']) ? selectQuery("SELECT * FROM blogposts WHERE slug = '{$_GET['m']}'") : selectQuery("SELECT * FROM blogposts ORDER BY RAND() LIMIT 1");
while ($row = mysqli_fetch_assoc($query)) {
    $postid = $row['id'];
    $title = $row['title'];
    $slug = $row['slug'];

    $author = getUserInfoById($row['author'], "username") ?: 'Anonymous';
    $cover = $GLOBALS['path']."/".$row['cover'];
    $thumb = $row['thumb'];
//    check if text file was created
    $filename = "../assets/blog/".$row['file']."/".$row['author'].".txt";
    $content = null;
    if (file_exists($filename)) {
        $textfile = fopen($filename, "r");
        $content = fread($textfile, filesize($filename));
        fclose($textfile);
    }
    $body = $content ?: $row['body'];
    $paragraphs = str_split($body, 200);
    $quote = strlen($row['qoute']) > 0 ? $row['qoute'] : false;
    $tags = explode(",", $row['tags']);
    $views = $row['views'];
    $str = date_create($row['date_posted']);
    $date = $str->format("F, Y");
    $date_str = $str->format("d");
}

?>

<?php require_once "../includes/styles.php" ?>

<?php require_once "../includes/navbar.php" ?>

<section class="banner_area" style="background-image: url('<?php echo $GLOBALS['path'] ?>assets/img/banner/single-page-banner3.jpg')">
    <div class="container">
        <div class="banner_inner_text">
            <h4>Blog</h4>
            <ul>
                <li><a href="<?php echo $GLOBALS['path'] ?>">Home</a></li>
                <li class="active"><a href="<?php echo $GLOBALS['path'] ?>blogpost">Blog</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="blog_details_area p_100">
    <div class="container">
        <div class="alert alert-<?php echo isset($alert) ? $alert[0] : null ?>"><?php echo isset($alert) ? $alert[1] : null ?></div>
        <div class="row blog_details_inner">
            <div class="col-md-8">
                <div class="blog_details_img">
                    <img src="<?php echo $cover ?>" alt="cover image">
                    <div class="b_date">
                        <h3><?php echo $date_str; ?></h3>
                        <h5><?php echo $date; ?></h5>
                    </div>
                </div>
                <div class="blog_d_text">
                    <h6>Posted By <a href="#"><?php echo $author ?></a> <span><i class="fa fa-eye" aria-hidden="true"></i><?php echo $views ?></span></h6>
                    <a href="#"><h3><?php echo $title ?></h3></a>

                    <p><?php echo nl2br($body) ?></p>

                    <?php if ($quote): ?>
                    <div class="quote_text">
                        <p>
                            <i class="fa fa-quote-left"></i>
                            <?php echo $quote; ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="image_text">
                    <h5>Tag:</h5>
                    <ul class="img_tages">
                        <?php foreach ($tags as $tag){ ?>
                        <li><a href="#"><?php echo getTag($tag); ?>,</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="like_post">
                    <h3>You may also like</h3>
                    <div class="row">
                        <?php
                        $tags_raw = implode(",", $tags);
                        $query = selectQuery("SELECT * FROM blogposts WHERE id != '$postid' AND tags LIKE '%$tags_raw%' LIMIT 2");
                        if (mysqli_num_rows($query)==0) { echo "<p>Loading...</p>"; }
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                        <div class="col-sm-6">
                            <div class="like_post_item">
                                <a href="?m=<?php echo $row['slug'] ?>">
                                    <img src="<?php echo $GLOBALS['path']."/".$row['cover'] ?>" alt="">
                                </a>
                                <h5><?php echo $row['title']; ?></h5>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="comment_list">
                    <?php
                    $query = selectQuery("SELECT * FROM blog_comments WHERE postid = '$postid'")
                    ?>
                    <h3><?php echo number_format(mysqli_num_rows($query)); ?> Comments</h3>
                    <div class="comment_list_inner">
                        <?php
                        while ($row = mysqli_fetch_assoc($query)) { ?>
                            <div class="media">
                                <div class="media-body">
                                    <span><strong><?php echo getUserInfoById($row['author'], "username") ?: 'Anonymous'; ?></strong></span>
                                    <h5><?php $str = date_create($row['date_posted']); echo $str->format("F d, Y")." AT ".$str->format("g:i A"); ?> <!-- MAY 25, 2017 AT 5:36 PM --></h5>
                                </div>
                                <p><?php echo $row['comment']; ?></p>
                                <a class="cm_reply" href="reply?m=<?php echo $row['id'] ?>"><i class="fa fa-reply" aria-hidden="true"></i> Reply</a>
                            </div>
                        <?php
                            $query2 = selectQuery("SELECT * FROM blog_replies WHERE commentid = '{$row['id']}'");
                            while ($row2 = mysqli_fetch_assoc($query2)) { ?>
                                <div class="media reply">
                                    <div class="media-body">
                                        <span><strong><?php echo getUserInfoById($row2['author'], "username") ?: 'Anonymous'; ?></strong></span>
                                        <h5><?php $str = date_create($row2['date_posted']); echo $str->format("F d, Y")." AT ".$str->format("g:i A"); ?> <!-- MAY 25, 2017 AT 5:36 PM --></h5>
                                    </div>
                                    <p><?php echo $row2['reply']; ?></p>
<!--                                    <a class="cm_reply" href="#"><i class="fa fa-reply" aria-hidden="true"></i> Reply</a>-->
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
                <div class="comment_form_area">
                    <h3>Drop a comment</h3>
                    <form class="contact_us_form row" method="post">
                        <input type="hidden" name="postid" value="<?php echo $postid; ?>">
                        <div class="form-group col-md-12">
                            <textarea required class="form-control" name="message" id="message" rows="1" placeholder="Your Comment"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <button name="comment_btn" type="submit" value="submit" class="btn submit_btn form-control">Post Comment</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar_area">
                    <aside class="right_widget r_post_widget">
                        <div class="r_w_title">
                            <h3>Trending Post</h3>
                        </div>
                        <div class="r_post_inner">
                            <?php
                            $query = selectQuery("SELECT * FROM blogposts WHERE id != '$postid' ORDER BY views DESC");
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
                            <li><a href="#"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once "../includes/footer.php" ?>

<?php require_once "../includes/scripts.php" ?>
