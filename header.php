<header>
    <div class="header">
        <a href="http://firsthost.com/"><img class="logo-img" src="/image/logo.svg" /></a>
        <div class="menu">
        <button id="log" onClick="btnLog()"></button>    
        </div>
    </div>
    <script src="./js/getCookie.js" ></script>
    <script src="./js/query.js" ></script>
    <script>
    let btnLog;        
        if(!getCookie('id') && !getCookie('hash')) {

            let login = document.getElementById("log");
            document.getElementById("log").innerHTML = "Login";
            btnLog = () => {
                window.location.assign(`http://localhost/login`);
            };
        }
        else {
            document.getElementById("log").innerHTML = "Logout";
            btnLog = () => {
                logout();
            };
        }
    </script>
</header>