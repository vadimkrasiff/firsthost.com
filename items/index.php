<!DOCTYPE html>
<html>
    <head>
        <title>Товары</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="/index.css">
    </head>
    <body>
        <header>
            <div class="header">
                <img class="logo-img" src="/image/logo.svg"/>
            </div>
        </header>
        <div class="wrapper">
        <div class="content-wrapper">
            <div class='navbar'>
                <a href="/aksessuary/" class="nav" ><span> Аксессуары</span></a>
                <a href="/akkumulyatory/" class="nav" ><span> Аккумуляторы</span></a>
                <a href="/displei-dlya-telefonov/" class="nav" ><span class='last'>Дисплеи для телефонов</span>  </a>
            </div>
            <div class="content" >
                <div class="thing_wrap">
                <div class="thing"><div class="preloader"></div></div>
                <div class="left_thing" onclick="onLeftClick()">Left</div>
                <div class="right_thing" onclick="onRightClick()">Right</div>
                </div>

            </div>
        </div> 
        <footer><div class="footer"></div></footer>
    </div>
    </body>
    <script src="../js/query.js"></script>
    <script  src="../js/carousel.js"></script>
    <script >
    getUsers().then(()=> setDisplayLeft())
</script>
</html>

<?php

?>