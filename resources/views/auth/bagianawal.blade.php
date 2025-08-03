<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Sistem Monitoring Kinerja Dosen</title>
    <style>
        /* Import font modern */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
        }

        .hero {
            position: relative;
            height: 100vh;
            background: url('assets/bg_kampus.jpg') no-repeat center center/cover;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 128, 0, 0.4); /* hijau transparan */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 20px;
        }

        .nav {
            position: absolute;
            top: 20px;
            right: 40px;
        }

        .nav a {
            text-decoration: none;
            margin-left: 20px;
            color: white;
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 25px;
            transition: 0.3s;
        }

        .nav a:hover {
            background-color: white;
            color: green;
        }

        h1 {
            font-size: 48px;
            color: white;
            margin-bottom: 10px;
        }

        p {
            font-size: 20px;
            color: #f0f0f0;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }
            .nav {
                top: 15px;
                right: 20px;
            }
            .nav a {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="hero">
    <div class="overlay">
        <div class="nav">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        </div>

        <h1>Sistem Monitoring Kinerja Dosen</h1>
        <p>Membantu memantau dan mengevaluasi kinerja dosen dengan mudah dan efisien</p>
    </div>
</div>

</body>
</html>
