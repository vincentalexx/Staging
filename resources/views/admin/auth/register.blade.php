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

    <style>
       /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgb(130, 106, 251);
        }
        .container {
            position: relative;
            max-width: 700px;
            width: 100%;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .container header {
            font-size: 1.5rem;
            color: #333;
            font-weight: 500;
            text-align: center;
        }
        .container .form {
            margin-top: 30px;
        }
        .form .input-box {
            width: 100%;
            margin-top: 20px;
        }
        .input-box label {
            color: #333;
        }
        .form :where(.input-box input, .select-box) {
            position: relative;
            height: 50px;
            width: 100%;
            outline: none;
            font-size: 1rem;
            color: #707070;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0 15px;
        }
        .input-box input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }
        .form .column {
            display: flex;
            column-gap: 15px;
        }
        .form .gender-box {
            margin-top: 20px;
        }
        .gender-box h3 {
            color: #333;
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 8px;
        }
        .form :where(.gender-option, .gender) {
            display: flex;
            align-items: center;
            column-gap: 50px;
            flex-wrap: wrap;
        }
        .form .gender {
            column-gap: 5px;
        }
        .gender input {
            accent-color: rgb(130, 106, 251);
        }
        .form :where(.gender input, .gender label) {
            cursor: pointer;
        }
        .gender label {
            color: #707070;
        }
        .address :where(input, .select-box) {
            margin-top: 15px;
        }
        .select-box select {
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            color: #707070;
            font-size: 1rem;
        }
        .form button {
            height: 55px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            font-weight: 400;
            margin-top: 30px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgb(130, 106, 251);
        }
        .form button:hover {
            background: rgb(88, 56, 250);
        }
        /*Responsive*/
        @media screen and (max-width: 500px) {
            .form .column {
                flex-wrap: wrap;
            }
            .form :where(.gender-option, .gender) {
                row-gap: 15px;
            }
        }
    </style>

</head>
<body>
    <section class="container">
        <header>Pendataan Jemaat</header>
        <form action="{{ url('signup') }}" class="form" method="POST">
            @csrf
            <div class="input-box">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="ex: John Doe" required />
            </div>
            <div class="input-box">
                <label>Kelas</label>
                <div class="select-box">
                    <select name="kelas">
                        <option hidden>- Kelas -</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>Kuliah</option>
                    </select>
                </div>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Nomor WhatsApp</label>
                    <input type="text" name="no_wa" placeholder="ex: 08xxxxxxxxxx" required />
                </div>
                <div class="input-box">
                    <label>Birth Date</label>
                    <input type="date" name="tgl_lahir" placeholder="ex: mm/dd/yyyy" required />
                </div>
            </div>
            <div class="gender-box">
                <h3>Jenis Kelamin</h3>
                <div class="gender-option">
                    <div class="gender">
                        <input type="radio" id="check-male" name="jenis_kelamin" value="laki-laki" checked />
                        <label for="check-male">Laki-laki</label>
                    </div>
                    <div class="gender">
                        <input type="radio" id="check-female" name="jenis_kelamin" value="perempuan" />
                        <label for="check-female">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="input-box address">
                <label>Alamat Tinggal</label>
                <input type="text" name="alamat" placeholder="ex: Jl. Apel no. 23" required />
            </div>
            <div class="input-box">
                <label>Hobi</label>
                <input type="text" name="hobi" placeholder="ex: Main musik" required />
            </div>
            <button>Submit</button>
        </form>
    </section>
</body>
</html>