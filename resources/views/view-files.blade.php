<!DOCTYPE html>
<html>
<head>
    <title>View Uploaded Files</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Uploaded Files</h1>
    <table>
        <thead>
            <tr>
                <th>Filename</th>
                <th>Type</th>
                <th>Size</th>
                <th>Uploader</th>
                <th>Upload Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
            <tr>
                <td>{{ $file->filename }}</td>
                <td>{{ $file->mime_type }}</td>
                <td>{{ number_format($file->size / 1024, 2) }} KB</td>
                <td>{{ $file->uploader_name }} ({{ $file->uploader_email }})</td>
                <td>{{ $file->upload_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 