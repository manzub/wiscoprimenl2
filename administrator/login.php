<?php
require_once "../core/init.php";

if (isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['lgn_btn'])) {
    $username_or_email = $_POST['nameemail'];
    $password = $_POST['password'];

    $is_email = filter_var($username_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    $query = selectQuery("SELECT * FROM members WHERE $is_email = '$username_or_email'");
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['alert'] = "Logged in successfully";
                $_SESSION['logged_in'] = $row;
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['alert'] = 'Password is incorrect';
            }
        }
    } else {
        $_SESSION['alert'] = 'Invalid username or email';
    }
}


?>

    <!-- html starts here -->
<?php require_once "../includes/styles.php" ?>

    <link rel="stylesheet" href="./theme.css">

    <section style="margin-top: 20px">
        <div class="container">
            <?php if(isset($_SESSION['alert'])) { ?>
                <div class="alert alert-warning">
                    <div class="alert-message"><?php echo $_SESSION['alert']; ?></div>
                </div>
                <?php unset($_SESSION['alert']);} ?>
            <form method="post">
                <h3 style="margin-bottom: 20px">Admin Login</h3>
                <div class="form-group">
                    <label for="">Username or Email:</label>
                    <input required class="form-control" name="nameemail" placeholder="Username or Email" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input required class="form-control" name="password" placeholder="Password" />
                </div>
                <div class="form-group">
                    <button type="submit" name="lgn_btn" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </section>

<?php require_once "../includes/scripts.php" ?>