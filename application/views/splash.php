<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MiCompanion</title>

    <style>
        :root {
            --brand-red: #e30613;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--brand-red);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto;
            overflow: hidden;
        }

        .splash {
            text-align: center;
            color: #fff;
            animation: fadeIn 0.8s ease forwards;
        }

        /* LOGO */
        .logo {
            width: 110px;
            margin: 0 auto 6px;
            animation: scaleUp 1s ease forwards;
        }

        .logo img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* BRAND NAME */
        .brand-name {
            font-weight: 800;
            font-size: 64px;
            letter-spacing: -1px;
            line-height: 1;
            margin: 0;
            animation: slideUp 0.8s ease forwards;
            animation-delay: 0.2s;
            opacity: 0;
        }

        /* TAGLINE */
        .tagline {
            margin-top: 6px;
            font-size: 15px;
            letter-spacing: 0.5px;
            opacity: 0;
            animation: slideUp 0.8s ease forwards;
            animation-delay: 0.5s;
        }

        /* ANIMATIONS */
        @keyframes scaleUp {
            from {
                transform: scale(0.7);
                opacity: 0
            }

            to {
                transform: scale(1);
                opacity: 1
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(12px);
                opacity: 0
            }

            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }
    </style>

</head>

<body>

    <div class="splash">

        <div class="logo">
            <img src="<?= base_url('assets/icons/logo.jpeg') ?>" alt="Aramex">
        </div>

        <h1 class="brand-name">aramex</h1>

        <div class="tagline">
            Smart Cargo. Real-Time Tracking.
        </div>

    </div>

    <script>
        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = "<?= site_url('welcome/login') ?>";
        }, 3000);
    </script>

</body>


</html>