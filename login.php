<?php

require_once "config/helper.php";

// Cek apakah user sudah login
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    // Redirect ke halaman dashboard jika sudah login
    header("Location: dashboard.php");
    exit;
}
// Fungsi untuk melakukan login
function login($username, $password) {

    $conn = connectDB();

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, md5($password));

    $sql = "SELECT * FROM tbl_login WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit; 
    } else {
        echo '
        <script>
            alert("Username dan Password Salah");
            window.location = ""; // Redirect ke halaman login lagi jika login gagal
        </script>
        ';
    }

    $conn->close();
}

// Proses login saat form terkirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    login($username, $password);
}
?>

<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>ltr/assets/images/favicon.png">
    <title>Login</title>
    <!-- Custom CSS -->
    <link href="<?= base_url() ?>ltr/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper bg-dark">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="auth-box">
                <div id="loginform">
                    <div class="logo">
                        <span class="db"><img src="<?= base_url() ?>ltr/assets/images/logo-icon.png" alt="logo" /></span>
                        <h5 class="font-medium mb-3">Sign In to Admin</h5>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3" method="post" id="loginform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control " name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password"  name="password" class="form-control " placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                                </div>
                                
                                <div class="form-group text-center">
                                    <div class="col-xs-12 pb-3">
                                        <button class="btn btn-block btn-info" type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>ltr/assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?= base_url() ?>ltr/assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>ltr/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    
    </script>
</body>

</html>
