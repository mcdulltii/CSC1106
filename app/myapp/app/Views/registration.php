<?= $this->extend('layout/bootstrap') ?>

<?= $this->section('body') ?>
<!-- Registration Section-->
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <?= session()->getFlashdata('error') ?>
            <form action="<?php echo base_url(); ?>register" method="post">
                <?= csrf_field() ?>
                <h5> Create a New User: </h5>

                <!-- Username input -->
                <div class="form-outline mb-4">
                    <input type="text" id="username" name="username" class="form-control" value="<?= set_value('username') ?>" />
                    <label class="form-label" for="username">Username</label>
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="password" name="password" class="form-control" value="<?= set_value('password') ?>" />
                    <label class="form-label" for="password">Password</label>
                </div>

                <!-- Repeat Password input -->
                <div class="form-outline mb-4">
                    <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" value="<?= set_value('confirmpassword') ?>" />
                    <label class="form-label" for="confirmpassword">Repeat password</label>
                </div>

                <?= validation_list_errors(); ?>

                <!-- Submit button -->
                <div class="form-check d-flex justify-content-center mb-4">
                    <button type="submit" class="btn btn-primary btn-block mb-3">Register</button>
                </div>
            </form>
        </div>
</section>
<!-- About Section-->
<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- About Section Content-->
        <div class="row">
            <div class="col-lg-4 ms-auto">
                <p class="lead">In a world where seamless data collection and efficient information processing have become paramount, welcome to the cutting-edge realm of Form++—a state-of-the-art form builder designed to redefine the way we create, customize, and deploy forms.</p>
            </div>
            <div class="col-lg-4 me-auto">
                <p class="lead">Form++ is not just an ordinary form builder; it represents the culmination of years of research, technological innovation, and user-centric design. With its unparalleled feature set and intuitive interface, Form++ empowers individuals, businesses, and organizations to effortlessly create dynamic and engaging forms that capture data with unprecedented ease and accuracy.</p>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>