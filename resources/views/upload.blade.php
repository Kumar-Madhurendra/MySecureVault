@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Upload Media</h5>
                    <a href="{{ url('/view-files') }}" class="btn btn-light btn-sm">View My Files</a>
                </div>

                <div class="card-body">
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ url('/upload-media') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <div class="upload-area p-5 text-center border rounded bg-light">
                                <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                <h5>Drag & Drop Files Here</h5>
                                <p class="text-muted">or</p>
                                <label for="media" class="btn btn-outline-primary">
                                    Choose File
                                    <input type="file" class="d-none @error('media') is-invalid @enderror" id="media" name="media">
                                </label>
                                <div id="selected-file" class="mt-3 text-muted"></div>
                                @error('media')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <p class="text-muted small">
                                    <i class="fas fa-info-circle"></i>
                                    Supported files: Video (MP4, MOV, AVI), Audio (MP3, WAV), Documents (PDF, DOC, DOCX, TXT), Images (JPG, PNG, GIF)
                                </p>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Upload File
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .upload-area {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .upload-area:hover {
        background-color: #f8f9fa !important;
        border-color: #0d6efd !important;
    }
    .upload-area.dragover {
        background-color: #e9ecef !important;
        border-color: #0d6efd !important;
        border-style: dashed !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.querySelector('.upload-area');
    const fileInput = document.getElementById('media');
    const selectedFile = document.getElementById('selected-file');

    uploadArea.addEventListener('click', () => fileInput.click());

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('dragover');
        });
    });

    uploadArea.addEventListener('drop', handleDrop);
    fileInput.addEventListener('change', handleFileSelect);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        updateFileName(files[0]);
    }

    function handleFileSelect(e) {
        const files = e.target.files;
        updateFileName(files[0]);
    }

    function updateFileName(file) {
        if (file) {
            selectedFile.textContent = `Selected: ${file.name}`;
        }
    }
});
</script>
@endpush
@endsection