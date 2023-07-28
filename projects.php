<?php require_once "core/init.php" ?>

    <!-- html starts here -->
<?php require_once "includes/styles.php" ?>
<?php require_once "includes/navbar.php" ?>

<section class="banner_area">
    <div class="container">
        <div class="banner_inner_text">
            <h4>Our Projects</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li class="active"><a href="#">Projects</a></li>
            </ul>
        </div>
    </div>
</section>

<section class="our_project2_area project_grid_two">
    <div class="container">
        <div class="main_c_b_title">
            <h2>Our<br class="title_br">Projects</h2>
            <h6>Great &amp; Awesome Works</h6>
        </div>

        <ul class="our_project_filter">
            <li class="active" data-filter="*">
                <a href="#">All</a>
            </li>
            <?php
            $query = selectQuery("SELECT * FROM tags WHERE type = 1");
            while ($row = mysqli_fetch_assoc($query)) {
                $tag = ucfirst($row['name']);
                echo "<li data-filter='.{$row['name']}'><a href='#'>$tag</a>";
            }
            ?>
        </ul>

        <div class="row our_project_details" style="position: relative; height: 868.876px">
            <?php
            $query = selectQuery("SELECT * FROM projects");
            while ($row = mysqli_fetch_assoc($query)) {
                $tags = explode(",", $row['tags']);
                $tags_str = "";
                foreach ($tags as $x) {
                    $tag = getTag($x, 1);
                    $tags_str .= " ".strtolower($tag);

                    $cover_image = $GLOBALS['path']."assets/projects/".$row['slug']."/".$row['cover'];

                }
            ?>
               <div class="col-md-6 <?php echo $tags_str; ?>">
                   <div class="project_item">
                       <img src="<?php echo $cover_image ?>" alt="cover image">
                       <div class="project_hover">
                           <div class="project_hover_inner">
                               <div class="project_hover_content">
                                   <a href="project-info?m=<?php echo $row['slug'] ?>">
                                       <h4><?php echo $row['projectname']; ?></h4>
                                   </a>
                                   <p><?php echo $row['summary']; ?></p>
                                   <a href="project-info?m=<?php echo $row['slug'] ?>" class="view_btn">View Project</a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php require_once "includes/footer.php" ?>
<?php require_once "includes/scripts.php" ?>