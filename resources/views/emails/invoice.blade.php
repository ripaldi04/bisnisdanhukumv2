<!DOCTYPE html>
<html>
<head>
    <title>Invoice Pembayaran Membership</title>
</head>
<body>
    <p>Dear Bapak/Ibu {{ $name }},</p>
    <p>Untuk menikmati sajian ilmu luar biasa dari Bisnis dan Hukum, Anda dapat membayar membership dengan melakukan transfer sejumlah <strong>Rp {{ $price }}</strong> sebelum <strong>{{ $expires }}</strong>.</p>
    <p>Faktur Pembayaran: <a href="{{ url('checkout/' . $trxID) }}">{{ url('checkout/' . $trxID) }}</a></p>
    <p>Untuk informasi lebih lanjut, silahkan login akun pada halaman berikut: <a href="{{ url('login') }}">{{ url('login') }}</a></p>
    <p>Semangat Sukses!</p>
</body>
</html>
