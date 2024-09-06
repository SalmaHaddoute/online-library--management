<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to My PHP Development Site</title>
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #080710;
            height: 1000px;
        }
        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }
        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }
        .shape:first-child {
            background: linear-gradient(
                #1845ad,
                #23a2f6
            );
            left: -80px;
            top: -80px;
        }
        .shape:last-child {
            background: linear-gradient(
                to right,
                #ff512f,
                #f09819
            );
            right: -60px;
            bottom: -70px;
        }
        .hi {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            color: #fff;
            height: 300px;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            resize: vertical;
        }
        button[type="submit"] {
        background: linear-gradient(to right, #1845ad, #ff512f);
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background: linear-gradient(to right, #23a2f6, #f09819);
    }
    </style>
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="hi">
        <h1>Leave a message for us!</h1>
        <form>
            <textarea placeholder="Write your message here..."></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>