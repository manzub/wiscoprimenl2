<?php
require_once "../core/init.php";


is_admin();

if (isset($_GET['delete'])) {
    $project_slug = $_GET['delete'];

    $query = selectQuery("SELECT * FROM projects WHERE slug = '$project_slug'");
    if(mysqli_num_rows($query) > 0) {
        $relative_project_dir = "../assets/projects/" . $project_slug . "/";
        deleteDir($relative_project_dir);
        //remove from database
        otherQuery("DELETE FROM projects WHERE slug = '$project_slug'");
        $_SESSION['alert'] = 'Project Deleted successfully';
        header("Location: index.php");
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
        <div style="display: flex;justify-content: right;align-items: center">
            <a href="new-project.php" class="btn btn-primary" style="margin-bottom: 10px"><i class="fa fa-plus"></i> Add Project</a>
        </div>
        <table class="table table-responsive table-bordered">
            <thead>
            <tr>
                <th>S/N</th>
                <th>Project Name</th>
                <th>Client's Name</th>
                <th>Location</th>
                <th>Date Completed</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $query = selectQuery("SELECT * FROM projects");
            if(mysqli_num_rows($query) > 0) {
                $count = 0;
                while($row=mysqli_fetch_assoc($query)) {
                    $count += 1;
                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>".$row['projectname']."</td>";
                    echo "<td>".$row['clientname']."</td>";
                    echo "<td>".$row['location']."</td>";
                    echo "<td>".$row['year_comp']."</td>";
                    echo "<td style='display: flex;gap: 5px'>";
                    echo "<a onclick='window.confirm(`Are you sure?`)' href='index.php?delete=".$row['slug']."' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                    echo "<a onclick='window.confirm(`Are you sure?`)' href='new-project.php?edit=".$row['slug']."' class='btn btn-warning'><i class='fa fa-pencil'></i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><p>No Projects Yet.</p></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</section>

<?php require_once "../includes/scripts.php" ?>