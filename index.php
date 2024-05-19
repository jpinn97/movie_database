<!DOCTYPE html>
<html>

<head>
    <title>Movie Database</title>
    <script src="https://unpkg.com/htmx.org"></script>
    <style>
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php echo "Hello, World! This is a HTMX page running on XAMPP...."; ?>
    <h1>Movie Database</h1>
    <form>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br>
        <br>
        <!-- SQL Query Buttons -->
        <button hx-post="/php/query_1.php" hx-trigger="click" hx-target="#result" hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'>
            Query 1
        </button>
        <button hx-post="/php/query_2.php" hx-trigger="click" hx-target="#result" hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'>
            Query 2
        </button>
        <button hx-post="/php/query_3.php" hx-trigger="click" hx-target="#result" hx-vals='{"username": document.getElementById("username").value, "password": document.getElementById("password").value}'>
            Query 3
        </button>

        <!-- MongoDB Query Buttons -->
        <button type="button" hx-post="/php/m_query_1.php" hx-trigger="click" hx-target="#result">
            MongoDB Query 1
        </button>
        <button type="button" hx-post="/php/m_query_2.php" hx-trigger="click" hx-target="#result">
            MongoDB Query 2
        </button>
        <button type="button" hx-post="/php/m_query_3.php" hx-trigger="click" hx-target="#result">
            MongoDB Query 3
        </button>
    </form>

    <div id="result" style="width: 1000px; height: 400px; border: 4px solid black; overflow: auto;"></div>
</body>

</html>