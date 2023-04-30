<!DOCTYPE html>
<html>

<head>
    <title>Пользователи</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/index.css">
    <link rel="stylesheet" href="./users.css">
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
                <div class="users_wrap">
                    <div class="users">
                        <div class="preloader"></div>
                    </div>
                    <div class="left_user" onclick="onLeftClick()">Left</div>
                    <div class="right_user" onclick="onRightClick()">Right</div>
                </div>

            </div>
        </div>
        <footer>
            <div class="footer"></div>
        </footer>
    </div>
</body>
<script src="../js/query.js"></script>
<script src="../js/carousel.js"></script>
<script>
    getUsers().then(() => setDisplayLeft())
</script>

</html>

<?php

?>