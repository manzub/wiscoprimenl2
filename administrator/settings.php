<?php
require_once "../core/init.php";

is_admin();

$query = selectQuery("SELECT * FROM settings");
while ($row=mysqli_fetch_assoc($query)) {
    if($row['name'] == 'phone') {
        $phone = $row['value'];
    }

    if ($row['name'] == 'working_hours') {
        $working_hours =  $row['value'];
    }

    if ($row['name'] == 'mailto') {
        $mailto = $row['value'];
    }

    if ($row['name'] == 'address') {
        $address = $row['value'];
    }

    if ($row['name'] == 'aboutus'){
        $aboutus = $row['value'];
    }
}


if(isset($_POST['post_btn'])) {
    $phone = $_POST['phone'];
    $mailto = $_POST['mailto'];
    $address = $_POST['address'];
    $working_hours = $_POST['working_hours'];
    $aboutus = $_POST['aboutus'];

    otherQuery("UPDATE settings SET value = '$phone' WHERE name = 'phone'");
    otherQuery("UPDATE settings SET value = '$mailto' WHERE name = 'mailto'");
    otherQuery("UPDATE settings SET value = '$address' WHERE name = 'address'");
    otherQuery("UPDATE settings SET value = '$working_hours' WHERE name = 'working_hours'");
    otherQuery("UPDATE settings SET value = '$aboutus' WHERE name = 'aboutus'");

    $_SESSION['alert'] = 'Updated Successfully';
    header("Location: index.php");
    exit();
}

if (isset($_POST['add_faq'])) {
    $title = $_POST['title'];
    $faq_body = $_POST['faq_body'];

    otherQuery("INSERT INTO faq (title, faq_body) VALUES ('$title', '$faq_body')");
    $_SESSION['alert'] = "Added Successfully";
    header("Location: index.php");
    exit();
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
        <div class="container" style="margin-bottom: 20px">
            <?php if(isset($_SESSION['alert'])) { ?>
                <div class="alert alert-warning">
                    <div class="alert-message"><?php echo $_SESSION['alert']; ?></div>
                </div>
                <?php unset($_SESSION['alert']);} ?>
            <form enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input class="form-control" name="phone" placeholder="Phone Number" value="<?php echo $phone ?>" />
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input class="form-control" name="mailto" value="<?php echo $mailto ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Office Address</label>
                                <input class="form-control" name="address" value="<?php echo $address ?>" />
                            </div>
                            <div class="form-group">
                                <label>Open Hours</label>
                                <input class="form-control" name="working_hours" value="<?php echo $working_hours ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>About Us</label>
                    <textarea rows="8" class="form-control" name="aboutus"><?php echo $aboutus ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" name="post_btn" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <hr />
        </div>
        <div class="container">
            <h3>Frequently Asked Questions.</h3>
            <hr />
            <?php
            $query = selectQuery("SELECT * FROM faq");
            if (mysqli_num_rows($query)) {
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<div style='margin-top: 10px;display: flex;align-items: center;justify-content: space-between'>";
                        echo "<div>";
                            echo "<h4>".$row['title']."</h4>";
                            echo "<p>".$row['faq_body']."</p>";
                        echo "</div>";
                        echo "<div style='display: flex;gap: 4px'>";
                            echo "<a class='btn btn-danger'><span class='fa fa-trash'></span></a>";
                            echo "<a class='btn btn-warning'><span class='fa fa-edit'></span></a>";
                        echo "</div>";
                    echo  "</div>";
                }
            } else {
                echo "<p>No Questions Yet.</p>";
            }
            ?>
            <hr />
            <form method="post" style="margin-top: 20px">
                <h4>Add a New Question</h4>
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" name="title" placeholder="Question" />
                </div>
                <div class="form-group">
                    <label>Body</label>
                    <input class="form-control" name="faq_body" placeholder="Answer" />
                </div>
                <div class="form-group">
                    <button type="submit" name="add_faq" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>

<?php require_once "../includes/scripts.php" ?>