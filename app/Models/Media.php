<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Media extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'media';
    protected $fillable = [
        'filename',
        'type',
        'content',
        'mime_type',
        'size',
        'uploader_name',
        'uploader_email',
        'user_id',
        'upload_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}