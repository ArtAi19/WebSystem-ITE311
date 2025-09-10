<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="text-center mb-5">
                <h1 class="display-4">Contact Us</h1>
                <p class="lead">We'd love to hear from you</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Get in Touch</h3>
                            <form>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" rows="4" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Contact Information</h3>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-geo-alt-fill text-primary"></i>
                                    <strong>Address:</strong><br>
                                    123 Education Street<br>
                                    Learning City, LC 12345
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-envelope-fill text-primary"></i>
                                    <strong>Email:</strong><br>
                                    info@yourlms.com
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-telephone-fill text-primary"></i>
                                    <strong>Phone:</strong><br>
                                    +1 (234) 567-8900
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-clock-fill text-primary"></i>
                                    <strong>Hours:</strong><br>
                                    Monday - Friday: 9:00 AM - 5:00 PM
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary me-2">Back to Home</a>
                <a href="<?= base_url('about') ?>" class="btn btn-outline-primary">Learn About Us</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
