<?php
require_once "../core/init.php";

is_admin();

if (isset($_GET['edit'])) {
    $blog_slug = $_GET['edit'];
    $query = selectQuery("SELECT * FROM blogposts WHERE slug = '$blog_slug'");
    while ($row = mysqli_fetch_assoc($query)) {
        $title = $row['title'];
        $quote = $row['qoute'];
        $body = $row['body'];
        $old_cover = $row['cover'];


        $dirpath = "../assets/blog/".$blog_slug;
        if (strlen($body) == 0) {
            $file = fopen($dirpath."/" . $row['author'] . ".txt", "r");
            $body = fread($file, filesize($dirpath. "/" . $row['author'] . ".txt"));
            fclose($file);
        }

        $blog_topics = explode(",", $row['tags']);

        $blog_images = array();
        $files = scandir($dirpath);
        $total = count($files);
        for($x = 0; $x <= $total - 1; $x++){
            if ($files[$x] != '.' && $files[$x] != '..' && $files[$x] != $row['author'].'.txt') {
                $blog_images[] = $files[$x];
            }
        }
    }
}

if (isset($_GET['edit']) && isset($_GET['unlink'])) {
    $blog_slug = $_GET['edit'];
    $filename = $_GET['unlink'];

    $dirpath = "../assets/blog/".$blog_slug;
    $files = scandir($dirpath);
    $total = count($files);
    for($x = 0; $x <= $total - 1; $x++){
        if ($files[$x] == $filename) {
            unlink($dirpath . "/" . $files[$x]);
            break;
        }
    }

    $_SESSION['alert'] = "Deleted file successfully";
    header("Location: new-blog.php?edit=".$blog_slug);
    exit();
}

if(isset($_POST['post_btn'])) {
    $title = $_POST['title'];
    $quote = $_POST['quote'];
    $body = $_POST['body'];
    $blog_topics = $_POST['tags'];
    //topics
    $tags_str = "";
    foreach ($blog_topics as $tag) {
        $tags_str .= $tag .",";
    }
    $tags = trim($tags_str, ",");
    //sensitive info
    $blog_slug = str_replace(" ", "-", substr($title, 0, 20)) . rand();
    $cover = $_FILES['cover_image'];
    $projects_dir_relative = "../assets/blog/{$blog_slug}";
    if (!file_exists($projects_dir_relative)) {
        mkdir($projects_dir_relative, 0777, true);
    }

    $author = $_SESSION['logged_in']['username'];

    if(!isset($_GET['edit']) && !is_uploaded_file($_FILES["cover_image"]["tmp_name"])) { // if we're not trying to edit project and user did not upload cover image, throw error
        $_SESSION['alert'] = "Please upload a cover image";
    } else { // if a project image was uploaded or we're trying to edit project
        if (is_uploaded_file($_FILES["cover_image"]["tmp_name"])) {
            $cover_file = $projects_dir_relative . "/" . basename($_FILES["cover_image"]["name"]);
            if (!file_exists($cover_file)) {
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $cover_file)) { //uploaded cover file
                    //save details file
                    if(strlen($body) > 2000) {
                        $details_file = fopen($projects_dir_relative."/".$author.".txt", "w");
                        fwrite($details_file, nl2br($body));
                        fclose($details_file);
                        $body = null;
                    }
                    //save everything to database
                    $cover_name = is_uploaded_file($_FILES["cover_image"]["tmp_name"]) ? basename($_FILES["cover_image"]["name"]) : $old_cover;
                    if (isset($_GET['edit'])) {
                        otherQuery("UPDATE blogposts SET title = '$title', cover = '$cover_name', body = '$body', qoute = '$quote', tags = '$tags' WHERE slug = '{$_GET['edit']}'");
                        $_SESSION['alert'] = 'Updated Successfully';
                    } else {
                        otherQuery("INSERT INTO blogposts(title, slug, author, cover, body, qoute, file, tags, date_posted) VALUES ('$title', '$blog_slug', '$author', '$cover_name', '$body', '$quote', '$blog_slug', '$tags', now())");
                        $_SESSION['alert'] = 'Added Successfully';
                    }
                    header("Location: blogs.php");
                    exit();
                } else {
                    $_SESSION['alert'] = 'Could not move file please contact system admin';
                }
                header("Location: blogs.php");
                exit();
            } else {
                $_SESSION['alert'] = 'Error occurred, file already exists';
                header("Location: blogs.php");
                exit();
            }
        } else {
            //just save project
            if (isset($_GET['edit'])) {
                otherQuery("UPDATE blogposts SET title = '$title', body = '$body', qoute = '$quote', tags = '$tags' WHERE slug = '{$_GET['edit']}'");
                $_SESSION['alert'] = 'Updated Successfully';
                header("Location: blogs.php");
                exit();
            }
        }
    }
}

?>

    <!-- html starts here -->
<?php require_once "../includes/styles.php" ?>

    <link rel="stylesheet" href="./theme.css">

    <section class="top_bar" style="padding: 10px 30px;background-color: #444;color: white;margin-bottom: 10px">
        <div class="" style="display: flex;align-items: center;justify-content: space-between">
            <h4>Welcome: <strong>Admin</strong></h4>
            <a href="logout.php"><i class="fa fa-2x text-danger fa-sign-out"></i></a>
        </div>
    </section>
    <div class="container navigation text-center" style="font-size: 30px">
        <a class="active" href="index.php">Projects</a>|
        <a href="blogs.php">Blog</a> |
        <a href="settings.php">Settings</a>
    </div>
    <section style="margin-top: 20px">
        <div class="container">
            <?php if(isset($_SESSION['alert'])) { ?>
                <div class="alert alert-warning">
                    <div class="alert-message"><?php echo $_SESSION['alert']; ?></div>
                </div>
                <?php unset($_SESSION['alert']);} ?>
            <form enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <label>Blog Title:</label>
                    <input required class="form-control" name="title" placeholder="Name of the Blog Post" value="<?php if (isset($title)) { echo $title; } ?>" />
                </div>
                <div class="form-group">
                    <label>Blog Topics:</label>
                    <select required class="form-control" multiple="multiple" name="tags[]">
                        <?php
                        $query = selectQuery("SELECT * FROM tags");
                        while($row=mysqli_fetch_assoc($query)) { ?>
                            <option <?php if (isset($blog_topics) && in_array($row['id'], $blog_topics)) { echo "selected"; } ?> value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quote Post:</label>
                    <input name="quote" class="form-control" placeholder="Blog quote" value="<?php if (isset($quote)) { echo $quote; } ?>" />
                </div>
                <div class="form-group">
                    <label>Post Body:</label>
                    <textarea required rows="8" class="form-control" name="body" placeholder="Project Details"><?php if (isset($body)) { echo $body; } ?></textarea>
                </div>
                <div class="form-group">
                    <h5><strong>Post Images:</strong></h5>
                    <?php
                    if (isset($blog_images)) {
                        foreach ($blog_images as $image) {
                            echo "<div style='display: flex;align-items: center;justify-content: space-between'>";
                            echo "<div style='display: flex;gap: 4px'>";
                            echo "<img src='".$dirpath."/".$image."' width='60px' />";
                            echo "<p>$image</p>";
                            echo "</div>";
                            echo "<a onclick='window.alert(`This action cannot be undone?`)' href='?edit=$blog_slug&unlink=$image' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                            echo "</div>";
                        }
                    }
                    ?>
                    <hr/>
                    <label>Cover Image:</label>
                    <input  <?php if (!isset($_GET['edit'])) { echo "required"; } ?> class="form-control" type="file" name="cover_image" placeholder="Select a Cover Image" />
                </div>
                <div class="form-group">
                    <button type="submit" name="post_btn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>

<?php require_once "../includes/scripts.php" ?>