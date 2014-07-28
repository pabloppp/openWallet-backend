
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
</head>
<body>

    <form action="/oauth/access_token?grant_type=client_credentials" method="post">
        <label for="client_id">Client ID:</label>
        <input name="client_id" placeholder="client id"/><br>
        <label for="client_secret">Client Secret:</label>
        <input name="client_secret" placeholder="client id"/><br>
        <button type="submit">LOGIN</button>

    </form>


</body>
</html>
