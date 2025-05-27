<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>404 Page Not Found</title>
    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }
        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }
        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }
        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
        pre {
            white-space: normal;
            margin-top: 1.5rem;
        }
        code {
            background: #fafafa;
            border: 1px solid #efefef;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            display: block;
        }
        p {
            margin-top: 1.5rem;
        }
        .debug {
            margin-top: 2rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>404 - File Not Found</h1>
        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
                <div class="debug">
                    <h2>Debug Information:</h2>
                    <p>URL: <?= current_url() ?></p>
                    <p>Method: <?= $_SERVER['REQUEST_METHOD'] ?></p>
                    <p>Controller: <?= $controller ?? 'Not available' ?></p>
                    <p>Method: <?= $method ?? 'Not available' ?></p>
                </div>
            <?php else: ?>
                Sorry! Cannot seem to find the page you were looking for.
            <?php endif ?>
        </p>
    </div>
</body>
</html>
