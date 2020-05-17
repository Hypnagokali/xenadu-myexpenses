<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>here we Go!</h1>
    <h2>Hash:</h2>
    <form action="register" method="POST">
        <input type="text" name="inp-str" placeholder="Passwort eingeben">
        <button type="submit">hash this!</button>
    </form>
    <h2>Überprüfen:</h2>
    <form action="verify" method="POST">
        <input type="text" name="password" placeholder="Passwort eingeben">
        <button type="submit">verify this!</button>
    </form>
</body>
</html>