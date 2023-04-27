<!DOCTYPE html>
<html>

<head>
    <title id='title'>Пользователь</title>
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
                <a href="/aksessuary/" class="nav"><span> Аксессуары</span></a>
                <a href="/akkumulyatory/" class="nav"><span> Аккумуляторы</span></a>
                <a href="/displei-dlya-telefonov/" class="nav"><span class='last'>Дисплеи для телефонов</span> </a>
            </div>
            <div class="content">
                <div class="user">
                </div>
            </div>
        </div>
        <footer>
            <div class="footer"></div>
        </footer>
    </div>
</body>
<script src="../js/query.js"></script>
<script>
    getUser(<?php echo htmlspecialchars($_GET["id"]) ?>);
</script>

</html>

<?php

?>