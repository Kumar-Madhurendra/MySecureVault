@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-{{ getFileIcon($media->type) }} me-2"></i>
                        {{ $media->filename }}
                    </h5>
                    <a href="{{ url('/view-files') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Files
                    </a>
                </div>

                <div class="card-body">
                    <div class="text-center">
                        @if($media->type === 'video')
                            <div class="ratio ratio-16x9">
                                <video controls class="rounded">
                                    <source src="data:{{ $media->mime_type }};base64,{{ $media->content }}" type="{{ $media->mime_type }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif($media->type === 'audio')
                            <div class="p-4 bg-light rounded">
                                <i class="fas fa-music fa-3x text-primary mb-3"></i>
                                <audio controls class="w-100">
                                    <source src="data:{{ $media->mime_type }};base64,{{ $media->content }}" type="{{ $media->mime_type }}">
                                    Your browser does not support the audio tag.
                                </audio>
                            </div>
                        @elseif($media->type === 'image')
                            <img src="data:{{ $media->mime_type }};base64,{{ $media->content }}" 
                                 alt="{{ $media->filename }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 70vh;">
                        @else
                            <div class="p-5 bg-light rounded">
                                <i class="fas fa-file-alt fa-4x text-primary mb-3"></i>
                                <h5>{{ $media->filename }}</h5>
                                <p class="text-muted mb-4">This is a {{ $media->type }} file.</p>
                                <a href="data:{{ $media->mime_type }};base64,{{ $media->content }}" 
                                   download="{{ $media->filename }}" 
                                   class="btn btn-primary">
                                    <i class="fas fa-download me-2"></i>Download File
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4">
                        <h6 class="text-muted mb-3">File Information</h6>
                        <div class="row g-3">
                            <div class="col-sm-6 col-md-4">
                                <div class="p-3 border rounded bg-light">
                                    <div class="small text-muted">Type</div>
                                    <div>{{ ucfirst($media->type) }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="p-3 border rounded bg-light">
                                    <div class="small text-muted">Size</div>
                                    <div>{{ formatFileSize($media->size) }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="p-3 border rounded bg-light">
                                    <div class="small text-muted">Uploaded</div>
                                    <div>{{ $media->upload_date->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
function getFileIcon($type) {
    return match($type) {
        'video' => 'film',
        'audio' => 'music',
        'image' => 'image',
        'document' => 'file-pdf',
        default => 'file-alt'
    };
}

function formatFileSize($size) {
    if ($size < 1024) {
        return $size . ' B';
    } elseif ($size < 1048576) {
        return round($size / 1024, 2) . ' KB';
    } else {
        return round($size / 1048576, 2) . ' MB';
    }
}
@endphp
@endsection 