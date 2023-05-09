<!DOCTYPE html>
<html>

<head>
    <title id='title'>Создать пользователя</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/index.css">
</head>

<body>
    <header>
        <div class="header">
            <a href="http://firsthost.com/"><img class="logo-img" src="/image/logo.svg" /></a>
        </div>
    </header>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class='navbar'>
                <a href="/create-user/" class="nav"><span> Создать пользователя</span></a>
                <a href="/users/" class="nav"><span>Пользователи</span></a>
                <a href="/displei-dlya-telefonov/" class="nav"><span class='last'>Дисплеи для телефонов</span> </a>
            </div>
            <div class="content">
                <form action="" id="loginForm">
                    <p>Your login: <input id="login" type="text" name="login" /></p>
                    <p>Your password: <input id="password" type="password" name="password" /></p>
                    <p><input type="submit" /></p>
                </form>
            </div>
        </div>
        <footer>
            <div class="footer"></div>
        </footer>
    </div>
</body>
<script src="../js/query.js"></script>
<script>
    if (check()) {
        history.back();
    } else {
        let loginForm = document.getElementById("loginForm");

        loginForm.addEventListener("submit", (e) => {
            e.preventDefault();

            let loginel = document.getElementById("login");
            let password = document.getElementById("password");
            console.log("dsasdsd");
            login({
                'login': loginel.value,
                'password': password.value
            });

        });
    }
</script>

</html>

<?php

?>