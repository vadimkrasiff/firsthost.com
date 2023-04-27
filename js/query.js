'use strict';

const getUsers = async () => {
  let response = await fetch("http://firsthost.com/users/get_users.php", { method: 'get' });
  if (response.ok) { 
    let json = await response.json();
    console.log(json);
    document.querySelector(".users").innerHTML = '';
    json.forEach(el => {
      document.querySelector(".users").innerHTML +=
        `<div class="user">
          <div class='photo'><img src='../../image/user.png'/></div>
          <div class='info'><div>${el.FIO}</div>
          
          </div>
        </div>`;
    });
  } else {
    alert("Ошибка HTTP: " + response.status);
  }

};

const getUser = async (id) => {
  
  console.log(id)
  let response = await fetch(`http://firsthost.com/user/get_user.php?id=${id}`, { method: 'get' });
  if (response.ok ) { 
    let json = await response.json();
    console.log(document.title);
    
    document.title = json.FIO;
    console.log(document.title);
    document.querySelector(".user").innerHTML = '';
      document.querySelector(".user").innerHTML =
        `<div class='photo'><img src='../../image/user.png'/></div>
          <div class='info'><div>${json.FIO}</div>`;
  } else {
    alert("Ошибка HTTP: " + response.status);
  }
};