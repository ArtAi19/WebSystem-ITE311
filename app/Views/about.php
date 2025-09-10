<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="text-center mb-5">
                <h1 class="display-4">About Us</h1>
                <p class="lead">Empowering learners through technology</p>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">Our Mission</h2>
                    <p class="card-text">To provide accessible, high-quality education through an innovative learning management system that empowers both educators and students to achieve their goals.</p>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title"><i class="bi bi-star"></i> What We Offer</h3>
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle text-success"></i> Interactive online courses</li>
                                <li><i class="bi bi-check-circle text-success"></i> Expert instructors</li>
                                <li><i class="bi bi-check-circle text-success"></i> Flexible learning schedule</li>
                                <li><i class="bi bi-check-circle text-success"></i> Progress tracking</li>
                                <li><i class="bi bi-check-circle text-success"></i> Certificates of completion</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title"><i class="bi bi-people"></i> Our Community</h3>
                            <p class="card-text">Join our growing community of learners and educators who are passionate about education and personal growth.</p>
                            <a href="<?= base_url('contact') ?>" class="btn btn-primary">Get in Touch</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary me-2">Back to Home</a>
                <a href="<?= base_url('contact') ?>" class="btn btn-primary">Contact Us</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
