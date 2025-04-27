@extends('layouts.app')

@section('content')
<!-- Navigation Bar -->
 
 

<!-- Add margin top to account for fixed navbar -->
<div >
<div class="welcome-hero">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Store and Share Your Media Files Securely</h1>
                <p class="lead text-muted mb-5">Upload, manage, and access your videos, audio, images, and documents from anywhere. Your files, your control.</p>
                <div class="d-flex gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                    @else
                        <a href="{{ url('/upload-form') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-upload me-2"></i>Upload Files
                        </a>
                        <a href="{{ url('/view-files') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-folder-open me-2"></i>View My Files
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="https://cdn-icons-png.flaticon.com/512/4403/4403384.png" alt="File Storage" class="img-fluid welcome-image">
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-gradient-to-r from-blue-50 to-indigo-50">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Powerful Media Management</h2>
            <p class="text-muted">Advanced features designed for your media needs</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-hover transition-all">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle rounded-circle p-3 mb-3">
                            <i class="fas fa-photo-video fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Smart Media Player</h5>
                        <p class="text-muted mb-0">Built-in player supporting various formats including MP4, MP3, and streaming capabilities.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-hover transition-all">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle rounded-circle p-3 mb-3">
                            <i class="fas fa-cloud-upload-alt fa-2x text-success"></i>
                        </div>
                        <h5 class="fw-bold">Cloud Storage</h5>
                        <p class="text-muted mb-0">Powered by MongoDB Atlas for reliable and scalable file storage with automatic backups.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-hover transition-all">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle rounded-circle p-3 mb-3">
                            <i class="fas fa-user-shield fa-2x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">Private Access</h5>
                        <p class="text-muted mb-0">Secure user authentication and personal file management system.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-hover transition-all">
                    <div class="card-body p-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-info-subtle rounded-circle p-3 mb-3">
                            <i class="fas fa-mobile-screen fa-2x text-info"></i>
                        </div>
                        <h5 class="fw-bold">Mobile Ready</h5>
                        <p class="text-muted mb-0">Fully responsive design for seamless access across all devices.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8 mx-auto text-center">
                <div class="card border-0 bg-primary text-white p-4">
                    <h3 class="fw-bold mb-3">Ready to Get Started?</h3>
                    <p class="mb-4">Join now and experience the best way to manage your media files</p>
                    @guest
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </a>
                        </div>
                    @else
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ url('/upload-form') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-upload me-2"></i>Start Uploading
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Features</h2>
            <p class="text-muted">Everything you need to manage your media files</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white mb-4">
                            <i class="fas fa-film fa-2x"></i>
                        </div>
                        <h4>Video & Audio</h4>
                        <p class="text-muted">Stream your media files directly from the browser with our built-in player.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-success bg-gradient text-white mb-4">
                            <i class="fas fa-images fa-2x"></i>
                        </div>
                        <h4>Image Gallery</h4>
                        <p class="text-muted">View and organize your images with our beautiful gallery interface.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="feature-icon bg-info bg-gradient text-white mb-4">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                        <h4>Documents</h4>
                        <p class="text-muted">Store and manage your important documents securely in one place.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Why Choose Us?</h2>
                <div class="d-flex mb-4">
                    <div class="feature-icon bg-warning bg-gradient text-white me-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h4>Secure Storage</h4>
                        <p class="text-muted mb-0">Your files are encrypted and stored securely in MongoDB Atlas.</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="feature-icon bg-danger bg-gradient text-white me-4">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <h4>Fast Access</h4>
                        <p class="text-muted mb-0">Quick upload and instant access to your files from anywhere.</p>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="feature-icon bg-primary bg-gradient text-white me-4">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div>
                        <h4>Responsive Design</h4>
                        <p class="text-muted mb-0">Access your files on any device with our mobile-friendly interface.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <img src="https://img.freepik.com/premium-vector/interrogative-concept-flat-people-search-woman-holding-magnifier-group-investigation-searching-solution-answers-ask-person-utter-vector-concept_53562-15576.jpg" alt="File Storage" class="img-fluid welcome-image">
            </div>
        </div>
    </div>
</div>
</div>
<!-- Footer Section -->
<div style="background-color: #212529; color: white; padding-top: 3rem; padding-bottom: 1.5rem; margin-top: 1rem;">

    <!-- Back to top link with spacing below -->
    <div style="text-align: center; margin-top: -2rem; margin-bottom: 2rem;">
        <a href="#" style="color: #adb5bd; text-decoration: none;">Back to top</a>
    </div>

    <!-- Footer content -->
    <div style="max-width: 1140px; margin: 0 auto;">
        <div style="display: flex; flex-wrap: wrap; text-align: start;">

            <!-- First Column -->
            <div style="flex: 0 0 25%; padding: 0 1rem;">
                <h5 style="font-weight: bold;">MySecureVault</h5>
                <ul style="list-style: none; padding-left: 0;">
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">About Us</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Key Features</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Security</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Meet the Team</a></li>
                </ul>
            </div>

            <!-- Second Column -->
            <div style="flex: 0 0 25%; padding: 0 1rem;">
                <h5 style="font-weight: bold;">Technology Stack</h5>
                <ul style="list-style: none; padding-left: 0;">
                    <li><a href="https://laravel.com/docs" target="_blank" style="color: #adb5bd; text-decoration: none;">Laravel</a></li>
                    <li><a href="https://laravel.com/docs/sanctum" target="_blank" style="color: #adb5bd; text-decoration: none;">Sanctum Auth</a></li>
                    <li><a href="https://www.mongodb.com/atlas/database" target="_blank" style="color: #adb5bd; text-decoration: none;">MongoDB Atlas</a></li>
                    <li><a href="https://react.dev" target="_blank" style="color: #adb5bd; text-decoration: none;">React Frontend</a></li>
                </ul>
            </div>

            <!-- Third Column -->
            <div style="flex: 0 0 25%; padding: 0 1rem;">
                <h5 style="font-weight: bold;">Help & Support</h5>
                <ul style="list-style: none; padding-left: 0;">
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">FAQs</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Customer Support</a></li>
                    <li><a href="# " style="color: #adb5bd; text-decoration: none;">Privacy Policy</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Fourth Column -->
            <div style="flex: 0 0 25%; padding: 0 1rem;">
                <h5 style="font-weight: bold;">Contact Us</h5>
                <ul style="list-style: none; padding-left: 0;">
                    <li><a href="mailto:kmadhurendra59@gmail.com" style="color: #adb5bd; text-decoration: none;">Email Support</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">reach admin</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Send Feedback</a></li>
                    <li><a href="#" style="color: #adb5bd; text-decoration: none;">Live Chat</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div style="text-align: center; margin-top: 20px; color: #adb5bd; text-decoration: none;">
            <p>&copy; 2025 MySecureVault<sup>&reg;</sup>. All rights reserved.</p>
        </div>
    </div>
</div>
<!-- End of Footer -->
@endsection
