'use strict';

const redirect = (path) => {
  window.location.assign(`http://localhost/${path}`);
}
const getUsers = async() => {
  check().then(async (res) => {
    if (res) {

      let response = await fetch("http://localhost/api/user/read.php", { method: 'get' });
      let json = await response.json();
      if (response.ok) {

        console.log(json);
        document.querySelector(".users").innerHTML = '';
        json.records.forEach(el => {
          document.querySelector(".users").innerHTML +=
            `<div class="user">
        <a href="http://localhost/user/${el.id}">
          <div class='photo'><img src='../../image/user.png'/></div>
          <div class='info'><div>${el.fio}</div>
          </div>
          </a>
        </div>`;
        });
      } else {
        alert("Ошибка HTTP: " + response.status);
        document.querySelector(".users").innerHTML = json.message;
      }
    } else {
      redirect("login");
    }
  });

};

const getUser = async (id) => {

  console.log(id)
  if (check()) {
    let response = await fetch(`http://localhost/api/user/read_one.php?id=${id}`, { method: 'get' });
    let json = await response.json();
    if (response.ok) {

      console.log(json);
      if (json) {
        document.title = json.fio;
        console.log(document.title);
        document.querySelector(".user").innerHTML = '';
        document.querySelector(".user").innerHTML =
          `<div class='photo'><img src='../../image/user.png'/></div>
          <div class='info'><div>${json.fio}</div>`;
      }
      else {
        document.querySelector(".user").innerHTML = 'Нет такого пользователя(';
      }
    } else {
      alert("Ошибка HTTP: " + response.status);
    }
  }
};

const createUser = async (data) => {
  console.log(JSON.stringify(data))
  let response = await fetch(`http://localhost/api/user/register.php`,
    {
      method: 'POST',
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data)
    });
  let json = await response.json();
  alert(json.message);
  if (response.ok) {
    redirect("users");
  }
};

const login = async (data) => {
  console.log(JSON.stringify(data))
  let response = await fetch(`http://localhost/api/user/login.php`,
    {
      method: 'POST',
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data)
    });
  let json = await response.json();
  alert(json.message);
  if (response.ok) {
    history.back();
  }
};

const check = async () => {
  let response = await fetch(`http://localhost/api/user/check.php`);
  let json = await response.json();
  // alert(json.message);
  if (response.ok) {
    return true;
  }

  return false
}; 
