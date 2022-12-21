const pswrdField = document.querySelector(".form input[type='password']"), //vyber textbox s heslem
toggleIcon = document.querySelector(".form .field i");                     //vyber styl



toggleIcon.onclick = () =>{
  if(pswrdField.type === "password"){                                     //přepíná viditelnost hesla
    pswrdField.type = "text";
    toggleIcon.classList.add("active");
  }else{
    pswrdField.type = "password";
    toggleIcon.classList.remove("active");
  }
}
