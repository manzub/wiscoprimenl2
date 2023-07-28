<?php
require_once "core/init.php";

if (!isset($_GET['m'])) {
    header("location: {$GLOBALS['path']}projects");
}

$query = selectQuery("SELECT * FROM projects WHERE slug = {$_GET['m']}");
while ($row = mysqli_fetch_assoc($query)) {
    $projects_dir = "{$GLOBALS['path']}assets/projects/{$row['slug']}";
    $projects_dir_relative = "assets/projects/{$row['slug']}";

    $cover_image = "$projects_dir/{$row['cover']}";

    $thumbnails = array();
    if ($handle = opendir("assets/projects/{$row['slug']}")) {
        while (false !== ($item = readdir($handle))) {
            if (!in_array($item, array(".", "..", ".DS_Store", "details.txt", $row['cover']))) {
                $var = explode(".", $item);
                if (in_array($var[sizeof($var)-1], array("jpg","png"))) {
                    array_push($thumbnails, $item);
                }
            }
        }
    }

    $summary = $row['summary'];
    $clientname = $row['clientname'];

    $category = "";
    $x = explode(",", $row['tags']);
    $count = 0;
    foreach ($x as $item) {
        $str = getTag($item, 1);
        $category .= "$str";
        $count += 1;
        $category .= sizeof($x) > $count ? "," : null;
    }
    $num = number_format($row['value']);
    $value = "$$num";
    $year_comp = date_create($row['year_comp'])->format("F Y");
    $area = $row['area'];
    $architect = $row['architect'];
    $location = $row['location'];
    $inv_url = $row['investor_web'];

    $owner_review = $row['owner_review'];
    $owner_rate = $row['owner_rate'];

    $file = fopen($projects_dir_relative."/details.txt", "r");
    $project_details = fread($file, filesize($projects_dir_relative."/details.txt"));
    fclose($file);
}
?>

    <!-- html starts here -->
<?php require_once "includes/styles.php" ?>
<?php require_once "includes/navbar.php" ?>

    <section class="banner_area">
        <div class="container">
            <div class="banner_inner_text">
                <h4>Our Projects</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Projects</a></li>
                    <li class="active"><a href="#">Info #<?php echo $_GET['m'] ?></a></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="project_single_area">
        <div class="container">
            <div class="project_single_inner">
                <div class="project_single_slider">
                    <div class="flexslider" id="slider">
                        <div class="flex-viewport">
                            <ul class="slides">
                                <?php
                                foreach ($thumbnails as $thumb) {
                                    echo "<li><img src='$projects_dir/$thumb' width='100%' /></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div id="carousel" class="flexslider">
                        <div class="custom-navigation">
                            <a href="#" class="flex-prev flex-disabled" tabindex="-1"><i class="fa fa-angle-left"></i></a>
                            <a href="#" class="flex-next"><i class="fa fa-angle-right"></i></a>
                        </div>
                        <div class="flex-viewport">
                            <ul class="slides">
                                <?php
                                foreach ($thumbnails as $thumb) {
                                    echo "<li><div style='background-image: url(".$projects_dir."/".$thumb.");height: 100px;background-position: center; background-size: cover'></div></li>";
//                                    echo "<li><img src='$projects_dir/$thumb' /></li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="project_summery">
                            <h4 class="project_title">Project Summary</h4>
                            <p><?php echo $summary; ?></p>
                            <ul>
                                <li><a href="#">Client's Name: <span><?php echo $clientname; ?></span></a></li>
                                <li><a href="#">Category: <span><?php echo $category; ?></span></a></li>
                                <li><a href="#">Year Completed: <span><?php echo $year_comp; ?></span></a></li>
                                <li><a href="#">Area: <span><?php echo $area; ?></span></a></li>
                                <li><a href="#">Location: <span><?php echo $location; ?></span></a></li>
                            </ul>
                        </div>
                        <div class="project_quote">
                            <h4 class="project_title">Owner Review</h4>
                            <div class="quote_inner">
                                <p><?php echo $owner_review; ?></p>
                                <?php
                                    for ($i=0; $i<intval($owner_rate);$i++) {
                                        echo '<a href="#"><i class="fa fa-star"></i></a>';
                                    }
                                    if (intval($owner_rate) < 5) {
                                        $unrate = 5 - intval($owner_rate);
                                        for ($i=0; $i<$unrate;$i++) {
                                            echo '<a href="#"><i class="fa fa-star-o"></i></a>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <hr>
                        <?php include "faq.php"; ?>
                    </div>
                    <div class="col-md-6">
                        <div class="project_discription">
                            <h4 class="project_title">Project Details</h4>
                            <p><?php echo nl2br($project_details); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php require_once "includes/footer.php" ?>
<?php require_once "includes/scripts.php" ?>