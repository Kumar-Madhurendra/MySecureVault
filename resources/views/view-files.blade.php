@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Files</h5>
                    <a href="{{ url('/upload-form') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-upload me-1"></i> Upload New File
                    </a>
                </div>

                <div class="card-body">
                    @if($files->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No files uploaded yet</h5>
                            <p class="text-muted">Start by uploading your first file</p>
                            <a href="{{ url('/upload-form') }}" class="btn btn-primary">
                                <i class="fas fa-upload me-1"></i> Upload Now
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px"></th>
                                        <th>File Name</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Uploaded</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                    <tr>
                                        <td>
                                            <i class="fas fa-{{ getFileIcon($file->type) }} fa-lg text-{{ getFileColor($file->type) }}"></i>
                                        </td>
                                        <td>
                                            <div class="text-break">{{ $file->filename }}</div>
                                            <div class="small text-muted">{{ $file->mime_type }}</div>
                                        </td>
                                        <td>{{ ucfirst($file->type) }}</td>
                                        <td>{{ formatFileSize($file->size) }}</td>
                                        <td>{{ $file->upload_date->diffForHumans() }}</td>
                                        <td class="text-end">
                                            <a href="{{ url('/play-media/' . $file->_id) }}" 
                                               class="btn btn-sm btn-{{ getActionButtonStyle($file->type) }}">
                                                <i class="fas fa-{{ getActionIcon($file->type) }} me-1"></i>
                                                {{ getActionText($file->type) }}
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
</style>
@endpush

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

function getFileColor($type) {
    return match($type) {
        'video' => 'danger',
        'audio' => 'success',
        'image' => 'primary',
        'document' => 'warning',
        default => 'secondary'
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

function getActionButtonStyle($type) {
    return match($type) {
        'video', 'audio' => 'primary',
        'image' => 'info',
        default => 'secondary'
    };
}

function getActionIcon($type) {
    return match($type) {
        'video', 'audio' => 'play',
        'image' => 'eye',
        default => 'download'
    };
}

function getActionText($type) {
    return match($type) {
        'video', 'audio' => 'Play',
        'image' => 'View',
        default => 'Download'
    };
}
@endphp
@endsection 