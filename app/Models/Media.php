<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Exception;

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
    
    public static function connectionInfo()
    {
        try {
            $connected = static::first() !== null || true;
            return [
                'connected' => $connected,
                'connection' => config('database.connections.mongodb'),
                'extension_loaded' => extension_loaded('mongodb')
            ];
        } catch (Exception $e) {
            return [
                'connected' => false,
                'error' => $e->getMessage(),
                'connection' => config('database.connections.mongodb'),
                'extension_loaded' => extension_loaded('mongodb')
            ];
        }
    }
}