<div class="panel-group project_collaps" id="accordion" role="tablist" aria-multiselectable="true">
    <h4 class="project_title" style="margin-bottom: 20px">Frequently Asked Questions</h4>
    <?php
    $query =  selectQuery("SELECT * FROM faq");
    if(mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $row['title']; ?>
                            <i class="fa fa-minus" aria-hidden="true"></i>
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"><?php echo $row['faq_body']; ?></div>
                </div>
            </div>
        <?php
        }
    }else { ?>
        <p>No Questions Yet.</p>
    <?php } ?>
</div>