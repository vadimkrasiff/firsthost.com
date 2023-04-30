<!DOCTYPE html>
<html>

<head>
    <title id='title'>Создать пользователя</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/index.css">
    <link rel="stylesheet" href="./user.css">
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
 <p>Your fio: <input type="text" id="fio" name="fio" /></p>
 <p>Your number phone: <input id="number" type="text" name="num_phone" /></p>
 <p><input type="submit" /></p>
</form>s
            </div>
        </div>
        <footer>
            <div class="footer"></div>
        </footer>
    </div>
</body>
<script src="../js/query.js"></script>
<script>
    let loginForm = document.getElementById("loginForm");

loginForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let fio = document.getElementById("fio");
  let number = document.getElementById("number");

 
    createUser({'fio':fio.value, 'num_phone': number.value});

  }
);
</script>
</html>

<?php

?>