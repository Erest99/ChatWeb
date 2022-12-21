const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-text");

form.onsubmit = (e)=>{
    e.preventDefault();
}

continueBtn.onclick = ()=>{                         //na stisk tlačítka pošli request na login
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = ()=>{                              //počkej na odpověď
      if(xhr.readyState === XMLHttpRequest.DONE){   //zkontroluj
          if(xhr.status === 200){
              let data = xhr.response;
              console.log(data);
              if(data === "success"){               //pokud je login úspěšný
                location.href = "users.php";        //nastav lokaci do uživatelského menu
              }else{
                errorText.style.display = "block";  //jinak zobraz obsah odpovědi jako chybovou hlášku
                errorText.textContent = data;
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);                              //pošli data z formuláře na login check
}