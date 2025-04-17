<style>
    .form-submit1 {
    background: linear-gradient(90deg, #4b6cb7 0%, #182848 100%);
    border: none;
    border-radius: 5px;
    color: white;
    padding: 10px 20px;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.3s ease-in-out;
}

.form-submit1:hover {
    background: linear-gradient(90deg, #182848 0%, #4b6cb7 100%);
}

</style>
<?php
session_start();
include('config.php');

?>
<?php include 'include/navbar.php'; ?>

<!-- Page content-->
<section class="py-5">
    <div class="container px-5">
        <!-- Contact form-->
        <div class="bg-light rounded-4 py-5 px-4 px-md-5">
            <div class="text-center mb-5">
                <div class="feature bg-primary bg-gradient-primary-to-secondary text-white rounded-3 mb-3"><i class="bi bi-box-arrow-in-right"></i></div>
                <h1 class="fw-bolder">Login</h1>
                <p class="lead fw-normal text-muted mb-0">สำหรับเจ้าหน้าที่</p>
            </div>
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <form id="contactForm" method="post" action="login_db_official.php">
                        <?php if (isset($_SESSION['error'])) : ?>
                            <div class="error">
                                <h3>
                                    <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                    ?>
                                </h3>
                            </div>
                        <?php endif ?>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="username" name="username" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                            <label for="username">Username</label>
                            <div class="invalid-feedback" data-sb-feedback="username:required">กรุณากรอก Username</div>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name="password" type="password" placeholder="Enter your pass..." data-sb-validations="required" />
                            <label for="password">Password</label>
                            <div class="invalid-feedback" data-sb-feedback="password:required">กรุณากรอก Password</div>
                        </div>
                        <!-- Submit Button-->
                        <div class="form-group">
                        <center><input type="submit" name="login_user" id="signin" class="form-submit1" value="Log in" /></center></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</main>
<?php include 'include/footer.php'; ?>
</body>

</html>