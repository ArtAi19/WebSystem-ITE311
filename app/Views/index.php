<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="text-center mb-5">
                <h1 class="display-4">Welcome to Our LMS</h1>
                <p class="lead">Your journey to knowledge starts here</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title"><i class="bi bi-book"></i> Courses</h3>
                    <p class="card-text">Browse through our extensive collection of courses designed to enhance your skills.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title"><i class="bi bi-person-video3"></i> Expert Instructors</h3>
                    <p class="card-text">Learn from industry experts and experienced professionals in your field.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="card-title"><i class="bi bi-graph-up"></i> Track Progress</h3>
                    <p class="card-text">Monitor your learning journey with detailed progress tracking and analytics.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6 offset-md-3 text-center">
            <p class="lead">Ready to start learning?</p>
            <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg">Get Started</a>
            <a href="<?= base_url('about') ?>" class="btn btn-outline-secondary btn-lg ms-2">Learn More</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
