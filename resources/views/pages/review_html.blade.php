<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Review HTML</title>
    {{-- <link rel="stylesheet" href="{{asset($style)}}"> --}}
    <style>
        {!! $style !!}
    </style>
</head>

<body>
    {!! $body ?? 'Nothing for review' !!}
</body>

</html>
