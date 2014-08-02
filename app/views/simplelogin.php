
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
</head>
<body>

    <form action="/oauth/access_token?grant_type=password&scope=app" method="post">
        <label for="username">Username:</label>
        <input name="username" placeholder="username"/><br>
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="password"/><br>
        <input type="hidden" name="client_id" value="Ki8WTB5RH4IdOx9yvAdbq7Tk7d0puIqlO1sqJGDt"/>
        <input type="hidden" name="client_secret" value="kCVrIpxRMieuoiesFiPIdJj8oC5cIAqrdY9CXQiB"/>
        <button type="submit">LOGIN</button>
    </form>


</body>
</html>
