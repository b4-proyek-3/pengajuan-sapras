<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <p>Halo,</p>
    <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
    <p>Silakan klik link di bawah ini untuk mereset password Anda:</p>
    <p>
        <a href="{{ url('password/reset', $token) }}?email={{ $email }}">
            Reset Password
        </a>
    </p>
    <p>Jika Anda tidak meminta reset password, tidak ada tindakan lebih lanjut yang diperlukan.</p>
    <p>Terima kasih,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
