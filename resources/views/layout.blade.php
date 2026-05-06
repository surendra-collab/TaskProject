<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortner</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; color: #111827; }
        .container { max-width: 1080px; margin: 24px auto; padding: 0 16px; }
        .panel { background: #fff; border: 1px solid #d1d5db; border-radius: 8px; padding: 16px; margin-bottom: 16px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        .title { font-size: 20px; margin: 0; }
        .muted { color: #6b7280; font-size: 13px; }
        .btn, button { background: #3b82f6; color: #fff; border: 1px solid #2563eb; border-radius: 4px; padding: 6px 12px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn.secondary { background: #fff; color: #111827; border-color: #9ca3af; }
        button[disabled] { background: #cbd5e1; border-color: #cbd5e1; cursor: not-allowed; }
        input, select { width: 100%; max-width: 420px; padding: 7px; border: 1px solid #9ca3af; border-radius: 4px; }
        label { font-size: 13px; color: #374151; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; font-size: 13px; text-align: left; }
        th { background: #f3f4f6; }
        .row { display: flex; gap: 16px; flex-wrap: wrap; }
        .col { flex: 1 1 480px; }
        .error-list { background: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 10px 14px; border-radius: 6px; }
        .nav-links { display: flex; gap: 8px; flex-wrap: wrap; }
    </style>
</head>
<body>
    <div class="container">
        @if ($errors->any())
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        @yield('content')
    </div>
</body>
</html>
