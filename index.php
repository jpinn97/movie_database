<!DOCTYPE html>
<html>

<head>
    <title>Movie Database</title>
    <script src="https://unpkg.com/htmx.org"></script>
</head>

<body>

    <h1>Movie Database</h1>
    <form>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <br>
        <label for="password">Password:</label><br>
        <input type="text" id="password" name="password"><br>
        <br>

        <button hx-post="/php/query_1.php" hx-trigger="click" hx-target="#result" hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'>
            Query 1
        </button>
        <button hx-post="/php/query_2.php" hx-trigger="click" hx-target="#result" hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'>
            Query 2
        </button>
        <button hx-post="/php/query_3.php" hx-trigger="click" hx-target="#result" hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'>
            Query 3
        </button>
    </form>

    <div id="result" style="width: 200px; height: 200px; border: 1px solid black;"></div>
</body>

</html>