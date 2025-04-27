<?php
// Load header template
$this->load->view('templates/header');
?>


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">About Us</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('beranda') ?>">Home</a></li>
        <li class="breadcrumb-item active text-white">About Us</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- About Start -->
<div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="<?= site_url('fruitables/img/better-nak512x512.png') ?>" class="img-fluid rounded" alt="Livestock Farm">
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="text-primary mb-4">Better-nak - Your Trusted Livestock Partner</h1>
                <p class="mb-4">Better-nak is Indonesia's premier online marketplace for quality livestock, connecting farmers and buyers since 2020. We specialize in providing healthy cattle, sheep, and goats from trusted breeders across the archipelago.</p>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check fa-2x text-primary me-3"></i>
                            <h5 class="mb-0">100% Healthy Animals</h5>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check fa-2x text-primary me-3"></i>
                            <h5 class="mb-0">Veterinary Certified</h5>
                        </div>
                    </div>
                </div>

                <p class="mb-4">Our mission is to modernize livestock trading with transparent pricing, quality assurance, and seamless delivery. Whether you're looking for dairy cows, meat goats, or breeding sheep, Better-nak offers the best selection with complete health records.</p>

                <h4 class="mb-4">Why Choose Better-nak?</h4>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="fas fa-paw text-primary me-2"></i> Direct from trusted local farmers</li>
                    <li class="mb-3"><i class="fas fa-truck text-primary me-2"></i> Nationwide delivery network</li>
                    <li class="mb-3"><i class="fas fa-shield-alt text-primary me-2"></i> 7-day health guarantee</li>
                    <li class="mb-3"><i class="fas fa-money-bill-wave text-primary me-2"></i> Competitive wholesale prices</li>
                    <li><i class="fas fa-headset text-primary me-2"></i> 24/7 expert support</li>
                </ul>

                <a href="<?= site_url('shop') ?>" class="btn btn-primary rounded-pill py-3 px-5 mt-4">Browse Our Livestock</a>
            </div>
        </div>

        <!-- Our Team Section -->
        <div class="row g-5 mt-5">
            <div class="col-12 text-center">
                <h1 class="text-primary mb-4">Meet Our Expert Team</h1>
                <p class="mb-5">Our team combines decades of agricultural expertise with e-commerce innovation</p>
            </div>

            <div class="col-md-4 text-center">
                <div class="team-item bg-light rounded p-4">
                    <img src="<?= site_url('fruitables/img/team-1.jpg') ?>" class="img-fluid rounded-circle mb-4" alt="Team Member">
                    <h4>Irawati</h4>
                    <p class="text-primary mb-1">Livestock Specialist</p>
                    <p class="mb-3">15 years experience in animal husbandry</p>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-center">
                <div class="team-item bg-light rounded p-4">
                    <img src="<?= site_url('fruitables/img/team-1.jpg') ?>" class="img-fluid rounded-circle mb-4" alt="Team Member">
                    <h4>Firda Garnida Kusumah</h4>
                    <p class="text-primary mb-1">Livestock Specialist</p>
                    <p class="mb-3">15 years experience in animal husbandry</p>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-center">
                <div class="team-item bg-light rounded p-4">
                    <img src="<?= site_url('fruitables/img/team-2.jpg') ?>" class="img-fluid rounded-circle mb-4" alt="Team Member">
                    <h4>Adnan Fauji</h4>
                    <p class="text-primary mb-1">Veterinary Doctor</p>
                    <p class="mb-3">Ensuring all livestock meet health standards</p>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-center">
                <div class="team-item bg-light rounded p-4">
                    <img src="<?= site_url('fruitables/img/team-2.jpg') ?>" class="img-fluid rounded-circle mb-4" alt="Team Member">
                    <h4>Raihan Yasykur</h4>
                    <p class="text-primary mb-1">Veterinary Doctor</p>
                    <p class="mb-3">Ensuring all livestock meet health standards</p>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square btn-outline-primary mx-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="row g-4 mt-5 text-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fas fa-cow text-primary fa-3x mb-3"></i>
                        <h2>5,000+</h2>
                        <h5>Cattle Traded</h5>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fas fa-sheep text-primary fa-3x mb-3"></i>
                        <h2>12,000+</h2>
                        <h5>Sheep & Goats</h5>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fas fa-users text-primary fa-3x mb-3"></i>
                        <h2>3,200+</h2>
                        <h5>Satisfied Customers</h5>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="counter bg-white rounded p-5">
                        <i class="fas fa-map-marked-alt text-primary fa-3x mb-3"></i>
                        <h2>24</h2>
                        <h5>Provinces Covered</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

</body>
</html>