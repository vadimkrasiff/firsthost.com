'use strict';

const getUsers = async () => {
  let response = await fetch("http://firsthost.com/api/user/read.php", { method: 'get' });
  if (response.ok) { 
    let json = await response.json();
    console.log(json);
    document.querySelector(".users").innerHTML = '';
    json.records.forEach(el => {
      document.querySelector(".users").innerHTML +=
        `<div class="user">
        <a href="http://firsthost.com/user/${el.id}">
          <div class='photo'><img src='../../image/user.png'/></div>
          <div class='info'><div>${el.fio}</div>
          </div>
          </a>
        </div>`;
    });
  } else {
    alert("Ошибка HTTP: " + response.status);
  }

};

const getUser = async (id) => {
  
  console.log(id)
  let response = await fetch(`http://firsthost.com/api/user/read_one.php?id=${id}`, { method: 'get' });
  if (response.ok ) { 
    let json = await response.json();
    console.log(json);
    if(json){
    document.title = json.fio;
    console.log(document.title);
    document.querySelector(".user").innerHTML = '';
      document.querySelector(".user").innerHTML =
        `<div class='photo'><img src='../../image/user.png'/></div>
          <div class='info'><div>${json.fio}</div>`;}
          else {
            document.querySelector(".user").innerHTML = 'Нет такого пользователя(';
          }
  } else {
    alert("Ошибка HTTP: " + response.status);
  }
};

const createUser= async(data) => {
  console.log(JSON.stringify(data))
  let response = await fetch(`http://firsthost.com/api/user/create.php`,
  { method: 'POST',
  headers: {
    "Content-Type": "application/json",
  },
  body:  JSON.stringify(data)});
  let json = await response.json();
  alert(json.message);
  if(response.ok) {
    window.location.assign("http://firsthost.com/users");
  }
};