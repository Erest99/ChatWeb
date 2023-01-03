const form = document.querySelector(".signup form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{                           //na stisk tlačítka
    let xhr = new XMLHttpRequest();                   //vytvoř post request pro registraci
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              console.log(data);
              if(data === "success"){                  //pokud je odpověď "success", redirektni na users.php (uživatelské menu)
                location.href="users.php";
              }else{
                errorText.style.display = "block";     //jinak zobraz odpověď jako chybovou hlášku
                errorText.textContent = data;
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);                                 //odešli data
}