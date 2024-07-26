<?php
$pdo = Koneksi::connect();
$crudUser = user::getInstance($pdo);

$id_user = $_GET["id"];

if (isset($_POST["reset"])) {
    // $username = $_POST["username"];
    // $email = $_POST["email"];
    $password = htmlspecialchars($_POST["password"]);

    if ($crudUser->resetPassword($id_user, $password)) {
        // echo '<script>window.location.href ="index.php?"</script>';
    } else {
        echo '<script>alert("Gak bisa")</script>';
    }
}

?>

<div class="section-header">
    <h1>Change Password</h1>
</div>
<div class="row">
    <div class="card">
        <form method="POST">
            <div class="card-body">

                <div class="">
                    <p>
                        Make Your New Password
                    </p>
                </div>
                <div class="col-20 col-md-16 col-lg-18">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="password">Password</label>
                            <input id="password" type="password" class="form-control" name="password" autocomplete="off" placeholder="Confirm Password" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" name="reset">
                        Confirm Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>