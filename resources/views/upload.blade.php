<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Media</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-6 text-center">Upload Files</h2>

        @if(session('message'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ url('/upload-media') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Uploader Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Your Name:</label>
                <input type="text" name="uploader_name" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            @error('uploader_name')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror

            <!-- Uploader Email -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Your Email:</label>
                <input type="email" name="uploader_email" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            @error('uploader_email')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror

            <!-- File Upload -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Choose File:</label>
                <input type="file" name="media" 
                       accept=".mp4,.mov,.avi,.mp3,.wav,.pdf,.doc,.docx,.txt,image/*" required
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-600 mt-1">
                    Supported files: Video, Audio, PDF, Documents, Text, Images
                </p>
            </div>

            @error('media')
                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
            @enderror

            <div class="mt-6">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    Upload
                </button>
            </div>
        </form>
    </div>

</body>
</html>