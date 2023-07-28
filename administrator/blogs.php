<?php

require_once "../core/init.php";

is_admin();

if (isset($_GET['delete'])) {
    $blog_slug = $_GET['delete'];
    $query = selectQuery("SELECT * FROM blogposts WHERE slug = '$blog_slug'");
    if (mysqli_num_rows($query) > 0) {
        $dirpath = "../assets/blog/" . $blog_slug . "/";
        deleteDir($dirpath);
        // remove from database
        otherQuery("DELETE FROM blogposts WHERE slug = '$blog_slug'");
        $_SESSION['alert'] = 'Blogpost Deleted successfully';
        header("Location: blogs.php");
        exit();
    } else {
        $_SESSION['alert'] = 'Could not delete item, an error occurred';
        header("Location: blogs.php");
        exit();
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
        <a href="index.php">Projects</a> |
        <a class="active" href="blogs.php">Blog</a> |
        <a href="settings.php">Settings</a>
    </div>
    <section style="margin-top: 20px">
        <div class="container">
            <?php if(isset($_SESSION['alert'])) { ?>
                <div class="alert alert-warning">
                    <div class="alert-message"><?php echo $_SESSION['alert']; ?></div>
                </div>
                <?php unset($_SESSION['alert']);} ?>
            <div style="display: flex;justify-content: right;align-items: center">
                <a href="new-blog.php" class="btn btn-primary" style="margin-bottom: 10px"><i class="fa fa-plus"></i> New Blog</a>
            </div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th>S/N</th>
                    <th>Blog Title </th>
                    <th>Author</th>
                    <th>Quote</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = selectQuery("SELECT * FROM blogposts");
                if(mysqli_num_rows($query) > 0) {
                    $count = 0;
                    while($row=mysqli_fetch_assoc($query)) {
                        $author = getUserInfoById($row['author'], "username") ?: 'Anonymous';
                        $tags_arr = explode(",", $row['tags']);
                        $tag_str = "";
                        foreach ($tags_arr as $tag) {
                            $tag_str = $tag_str.",". mysqli_fetch_assoc(selectQuery("SELECT * FROM tags  WHERE id = '$tag'"))['name'];
                            trim($tag_str, ",");
                        }

                        $count += 1;
                        echo "<tr>";
                        echo "<td>".$count."</td>";
                        echo "<td>".substr($row['title'], 0, 35)."...</td>";
                        echo "<td>".$author."</td>";
                        echo "<td>".$row['qoute']."</td>";
                        echo "<td>".$tag_str."</td>";
                        echo "<td style='display: flex;gap: 5px'>";
                        echo "<a onclick='window.alert(`This action cannot be undone`)' href='?delete=".$row['slug']."' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                        echo "<a href='new-blog.php?edit=".$row['slug']."' class='btn btn-warning'><i class='fa fa-pencil'></i></a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><p>No Blogs Yet.</p></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>

<?php require_once "../includes/scripts.php" ?>