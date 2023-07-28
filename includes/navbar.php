<?php $page = basename($_SERVER['REQUEST_URI'], '?'.$_SERVER['QUERY_STRING']);  ?>

<header class="main_header_area">
  <div class="header_top_area">
    <div class="container">
      <div class="pull-left">
        <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'phone' LIMIT 1");
        while ($row = mysqli_fetch_assoc($query)) { ?>
        <a href=""><i class="fa fa-phone"></i><?php echo $row['value'] ?></a>
        <?php } ?>

        <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'address'");
        while ($row = mysqli_fetch_assoc($query)) { ?>
        <a href=""><i class="fa fa-map-marker"></i><?php echo $row['value'] ?></a>
        <?php } ?>

        <?php $query = selectQuery("SELECT * FROM settings WHERE name = 'working_hours'");
        while ($row = mysqli_fetch_assoc($query)) { ?>
            <a href=""><i class="mdi mdi-clock"></i><?php echo $row['value'] ?></a>
        <?php } ?>
      </div>
      <div class="pull-right">
        <ul class="header_social">
          <li><a href=""><i class="fa fa-facebook"></i></a></li>
          <li><a href=""><i class="fa fa-whatsapp"></i></a></li>
          <li><a href=""><i class="fa fa-envelope"></i></a></li>
        </ul>
      </div>
    </div>
  </div>


  <div class="main_menu_area">
    <div class="container">
      <nav class="navbar navbar-default">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-header-menu" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="<?php echo $GLOBALS['path'] ?>" class="navbar-brand"><strong><b class="text-theme">WISCO</b>PRIME</strong></a>
        </div>
        <div class="navbar-collapse collapse" id="main-header-menu" aria-expanded="false">
          <ul class="nav navbar-nav navbar-right">
            <li class="<?php echo $page == 'wiscoprimenl' ? 'active' : null ?>">
                <a href="<?php echo $GLOBALS['path'] ?>">Home</a>
            </li>
            <li class="<?php echo $page == 'projects' ? 'active' : null ?>">
                <a href="<?php echo $GLOBALS['path'] ?>projects">Projects</a>
            </li>
            <li class=""><a href="<?php echo $GLOBALS['path'] ?>#services">Our Services</a></li>
            <li class="<?php echo $page == 'about' ? 'active' : null ?>">
                <a href="<?php echo $GLOBALS['path'] ?>about">About Us</a>
            </li>
            <li class="<?php echo $page == 'blogpost' ? 'active' : null ?>">
                <a href="<?php echo $GLOBALS['path'] ?>blogpost">Blog</a>
            </li>
            <li class="<?php echo $page == 'contactus' ? 'active' : null ?>">
                <a href="<?php echo $GLOBALS['path'] ?>contactus">Contact</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</header>