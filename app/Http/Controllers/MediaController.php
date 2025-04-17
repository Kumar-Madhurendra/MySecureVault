<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'uploader_name' => 'required|string|max:255',
            'uploader_email' => 'required|email|max:255',
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
            'uploader_name' => $request->uploader_name,
            'uploader_email' => $request->uploader_email,
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
        $files = Media::all();
        return view('view-files', ['files' => $files]);
    }
}