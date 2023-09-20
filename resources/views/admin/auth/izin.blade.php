<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">

    <title>@yield('title', "Beat") | Beat GII</title>

    <link rel="stylesheet" href="css\izin.css">

</head>
<body>
    <section class="container">
        <header>Izin Kegiatan Pengurus</header>
        <form action="{{ url('IzinKegiatan/izin') }}" class="form" method="POST">
            @csrf
            <div class="input-box">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="ex: John Doe" required />
            </div>
            <div class="input-box">
                <label>Angkatan</label>
                <input type="text" name="angkatan" placeholder="ex: G18" required />
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Kegiatan</label>
                    <br>
                    <select name="kegiatan" id="select-kegiatan">
                        <option value="kebaktian">Kebaktian</option>
                        <option value="pembinaan">Pembinaan</option>
                    </select>
                </div>
                <div class="input-box">
                    <label>Date</label>
                    <input type="date" name="tgl_kegiatan" placeholder="mm/dd/yyyy" required />
                </div>
            </div>
            <div class="input-box">
                <label>Alasan</label>
                <input type="text" name="alasan" placeholder="ex: Acara Keluarga" required />
            </div>
            <button>Submit</button>
        </form>
    </section>
</body>
</html>