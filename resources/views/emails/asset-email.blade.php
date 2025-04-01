<!DOCTYPE html>
<html>
<head>
    <title>Asset Download Links</title>
    <style>
        body { font-family: Arial, sans-serif; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 10px; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <p>Dear User,</p>
    <p>Please find the attached assets you requested:</p>
    <ul>
        @foreach($filePaths as $asset)
            <li><a href="{{ asset('storage/' . $asset) }}" download>{{ $asset }}</a></li>
        @endforeach
    </ul>
    <p>Thank you!</p>
</body>
</html>