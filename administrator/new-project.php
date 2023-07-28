<?php
require_once "../core/init.php";

is_admin();

if(isset($_GET['edit'])) {
    $project_slug = $_GET['edit'];

    $query = selectQuery("SELECT * FROM projects WHERE slug = '$project_slug'");
    if(mysqli_num_rows($query) > 0){
        while ($row = mysqli_fetch_assoc($query)) {
            $projectname = $row['projectname'];
            $land_area = $row['area'];
            $location = $row['location'];
            $summary = $row['summary'];
            $slug = $row['slug'];
            $old_cover = $row['cover'];

            $dirpath = "../assets/projects/".$row['details_file'];
            $file = fopen($dirpath."/details.txt", "r");
            $project_details = fread($file, filesize($dirpath."/details.txt"));
            fclose($file);

            $year_start = $row['year_start'];
            $year_comp = $row['year_comp'];
            $tags = explode(",", $row['tags']);

            $project_images = array();
            $files = scandir($dirpath);
            $total = count($files);
            for($x = 0; $x <= $total - 1; $x++){
                if ($files[$x] != '.' && $files[$x] != '..' && $files[$x] != 'details.txt') {
                    $project_images[] = $files[$x];
                }
            }

        }
    }else {
        header("Location: index.php");
        exit();
    }
}

if (isset($_GET['edit']) && isset($_GET['unlink'])) {
    $project_slug = $_GET['edit'];
    $filename = $_GET['unlink'];

    $dirpath = "../assets/projects/".$project_slug;
    $files = scandir($dirpath);
    $total = count($files);
    for($x = 0; $x <= $total - 1; $x++){
        if ($files[$x] == $filename) {
            unlink($dirpath . "/" . $files[$x]);
            break;
        }
    }

    $_SESSION['alert'] = "Deleted file successfully";
    header("Location: new-project.php?edit=".$project_slug);
    exit();
}

if(isset($_POST['lgn_btn'])) {
    $projectname =  $_POST['projectname'];
    $summary =  $_POST['summary'];
    $location = $_POST['location'];
    $year_start = date("Y-m-d H:i:s", strtotime($_POST['year_start']));
    $year_end = date("Y-m-d H:i:s", strtotime($_POST['year_comp']));
    $land_area = $_POST['land_area'];
    $project_details = $_POST['details'];
    $project_tags = $_POST['tags'];
    $tags_str = "";
    foreach ($project_tags as $tag) {
        $tags_str .= $tag .",";
    }
    $tags = trim($tags_str, ",");

    // sensitive details
    $project_slug = str_replace(" ", "-", substr($projectname, 0, 20)) . rand();
    $thumbs = count($_FILES['thumbs_image']['name']);
    $cover = $_FILES['cover_image'];
    $projects_dir_relative = "../assets/projects/{$project_slug}";
    if (!file_exists($projects_dir_relative)) {
        mkdir($projects_dir_relative, 0777, true);
    }

    if(!isset($_GET['edit']) && !is_uploaded_file($_FILES["cover_image"]["tmp_name"])) { // if we're not trying to edit project and user did not upload cover image, throw error
        $_SESSION['alert'] = "Please upload project images";
    } else { // if a project image was uploaded or we're trying to edit project
        if(is_uploaded_file($_FILES["cover_image"]["tmp_name"]) || is_uploaded_file(end($_FILES["thumbs_image"]["tmp_name"]))) { // if we uploaded images
            $cover_file = $projects_dir_relative . "/" . basename($_FILES["cover_image"]["name"]);
            if (!file_exists($cover_file)) {
                if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $cover_file)) { //uploaded cover file
                    // Loop through each thumb file
                    for( $i=0 ; $i < $thumbs ; $i++ ) {
                        //Get the temp file path
                        $tmpFilePath = $_FILES['thumbs_image']['tmp_name'][$i];

                        //Make sure we have a file path
                        if ($tmpFilePath != ""){
                            //Setup our new file path
                            $newFilePath = $projects_dir_relative ."/" . $_FILES['thumbs_image']['name'][$i];

                            //Upload the file into the temp dir
                            if(!move_uploaded_file($tmpFilePath, $newFilePath)) {
                                $_SESSION['alert'] = "Could not upload thumb image please contact system admin";
                            }
                        }
                    }

                    //save details file
                    $details_file = fopen($projects_dir_relative."/details.txt", "w");
                    fwrite($details_file, nl2br($project_details));
                    fclose($details_file);

                    //save everything to database
                    $cover_name = is_uploaded_file($_FILES["cover_image"]["tmp_name"]) ? basename($_FILES["cover_image"]["name"]) : $old_cover;
                    if (isset($_GET['edit'])) { // update items instead of insert into the db
                        otherQuery("UPDATE projects SET projectname = '$projectname', tags = '$tags', year_comp = '$year_end', year_start = '$year_start', area = '$land_area', location = '$location', summary = '$summary', cover = '$cover_name' WHERE slug = '{$_GET['edit']}'");
                        $_SESSION['alert'] = 'Updated Successfully';
                    } else {
                        otherQuery("INSERT INTO projects(slug, projectname, clientname, tags, year_comp, year_start, area, location, summary, details_file, owner_review, owner_rate, cover, thumbs, date_posted) VALUES ('$project_slug', '$projectname', 'Anonymous', '$tags', '$year_end', '$year_start', '$land_area', '$location', '$summary', '$project_slug', 'Excellent Job', '4', '$cover_name', '$thumbs', now())");
                        $_SESSION['alert'] = 'AddedSuccessfully';
                    }
                    header("Location: index.php");
                    exit();
                } else {
                    $_SESSION['alert'] = 'Could not move file please contact system admin';
                    header("Location: index.php");
                    exit();
                }
            } else {
                $_SESSION['alert'] = 'Error occurred, file already exists';
                header("Location: index.php");
                exit();
            }
        }else  {
            //just save project
            if (isset($_GET['edit'])) { // update items instead of insert into the db
                //save details file
                $details_file = fopen($projects_dir_relative."/details.txt", "w");
                fwrite($details_file, nl2br($project_details));
                fclose($details_file);

                otherQuery("UPDATE projects SET projectname = '$projectname', tags = '$tags', year_comp = '$year_end', year_start = '$year_start', area = '$land_area', location = '$location', summary = '$summary' WHERE slug = '{$_GET['edit']}'");
                $_SESSION['alert'] = 'Updateddffff Successfully';
                header("Location: index.php");
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
        <a class="active" href="index.php">Projects</a> |
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
                    <label>Project Name:</label>
                    <input required class="form-control" name="projectname" placeholder="Name of the Project" value="<?php if(isset($projectname)){ echo $projectname; } ?>" />
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Year Started:</label>
                                <input required class="form-control" name="year_start" type="date" value="<?php if (isset($year_start)) { echo date('Y-m-d',strtotime($year_start)); } ?>" />
                            </div>
                            <div class="form-group">
                                <label for="">Year Completed:</label>
                                <input required class="form-control" name="year_comp" type="date" value="<?php if (isset($year_comp)) { echo date('Y-m-d',strtotime($year_comp)); } ?>" />
                            </div>
                            <div class="form-group">
                                <label for="">Land Area:</label>
                                <input required class="form-control" name="land_area" type="text" placeholder="Measurement of the land area" value="<?php if (isset($land_area)) { echo $land_area; } ?>" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Project Summary:</label>
                                <textarea required class="form-control" rows="9" name="summary" placeholder="Summary of the Project"><?php if (isset($summary)) { echo $summary; } ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Project Categories:</label>
                    <select required class="form-control" multiple="multiple" name="tags[]">
                        <?php
                        $query = selectQuery("SELECT * FROM tags");
                        while($row=mysqli_fetch_assoc($query)) { ?>
                        <option <?php if(isset($tags) && in_array($row['id'], $tags)) { echo "selected"; } ?>  value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Location:</label>
                    <input name="location" class="form-control" placeholder="Location" value="<?php if (isset($location)) { echo $location; } ?>" />
                </div>
                <div class="form-group">
                    <label>Project Details:</label>
                    <textarea required rows="8" class="form-control" name="details" placeholder="Project Details"><?php if (isset($project_details)) { echo $project_details; } ?></textarea>
                </div>
                <div class="form-group">
                    <h5><strong>Project Images:</strong></h5>
                    <?php
                    if (isset($project_images)) {
                        foreach ($project_images as $image) {
                            echo "<div style='display: flex;align-items: center;justify-content: space-between'>";
                            echo "<div style='display: flex;gap: 4px'>";
                            echo "<img src='".$dirpath."/".$image."' width='60px' />";
                            echo "<p>$image</p>";
                            echo "</div>";
                            echo "<a onclick='window.alert(`This action cannot be undone?`)' href='?edit=$slug&unlink=$image' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                            echo "</div>";
                        }
                    }
                    ?>
                    <hr/>
                    <label>Cover Image:</label>
                    <input <?php if (!isset($_GET['edit'])) { echo "required"; } ?> class="form-control" type="file" name="cover_image" placeholder="Select a Cover Image" />
                    <hr/>
                    <label>Other Images:</label>
                    <input <?php if (!isset($_GET['edit'])) { echo "required"; } ?> class="form-control" type="file" name="thumbs_image[]" multiple="multiple" placeholder="Select a Cover Image" />
                </div>
                <div class="form-group">
                    <button type="submit" name="lgn_btn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>

<?php require_once "../includes/scripts.php" ?>