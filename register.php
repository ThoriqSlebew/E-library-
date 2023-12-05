<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>
<body style="background-image: url('buku.webp'); background-repeat: no-repeat; background-position: center ; background-size: cover;  ">
<div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center w-50 m-auto">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Daftar Akun</h1>
                                    </div>
                                    <form class="user" action="aksi_register.php" method="POST">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="email" required>
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-warning" type="submit">Daftar</button>
                                        </div>
                                        </a>
                                    </form>   
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>