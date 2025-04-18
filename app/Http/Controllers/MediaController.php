<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadForm()
    {
        return view('upload');
    }

    public function uploadMedia(Request $request)
    {
        $request->validate([
            'media' => 'required|file|mimes:mp4,mov,avi,mp3,wav,pdf,doc,docx,txt,jpg,jpeg,png,gif|max:20480' // 20MB limit
        ]);

        $file = $request->file('media');
        $extension = $file->getClientOriginalExtension();
        
        // Determine type based on extension
        $type = $this->getFileType($extension);
        
        // Read file content as binary
        $content = base64_encode(file_get_contents($file->getRealPath()));
        
        // Create media document in MongoDB
        $media = Media::create([
            'filename' => $file->getClientOriginalName(),
            'type' => $type,
            'content' => $content,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'uploader_name' => auth()->user()->name,
            'uploader_email' => auth()->user()->email,
            'user_id' => auth()->id(),
            'upload_date' => now()
        ]);

        return redirect('/upload-form')->with('message', 'File uploaded successfully to MongoDB Atlas!');
    }

    private function getFileType($extension)
    {
        $videoTypes = ['mp4', 'mov', 'avi'];
        $audioTypes = ['mp3', 'wav'];
        $documentTypes = ['pdf', 'doc', 'docx'];
        $imageTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extension, $videoTypes)) return 'video';
        if (in_array($extension, $audioTypes)) return 'audio';
        if (in_array($extension, $documentTypes)) return 'document';
        if (in_array($extension, $imageTypes)) return 'image';
        return 'text';
    }

    public function viewFiles()
    {
        $files = Media::where('user_id', auth()->id())->get();
        return view('view-files', ['files' => $files]);
    }

    public function playMedia($id)
    {
        $media = Media::findOrFail($id);
        
        // Check if user owns this media
        if ($media->user_id !== auth()->id()) {
            abort(403);
        }

        return view('play-media', ['media' => $media]);
    }
}