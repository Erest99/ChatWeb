const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();                                 //po každém zvednutí klávesy ve vstupním poli zkontroluj obsah a pokud je "" tak označ jako neaktivní
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{                             //na stisk tlačítka odešli zprávu
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){   //když příjde odpověď
          if(xhr.status === 200){
              inputField.value = "";                //resetni textbox
              scrollToBottom();                     //scrollni dolu na nové zprávy
          }
      }
    }
    let formData = new FormData(form);              
    xhr.send(formData);                             //pošli text zprávy s requestem
}
chatBox.onmouseenter = ()=>{                        //aktivita chatboxu
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{                                 //každých 500ms aktualizuj zprávy
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;               //přečti response
            chatBox.innerHTML = data;              //vlož data do chatBoxu
            if(!chatBox.classList.contains("active")){  //pokud není chatBox používán scrollni dolu na novou zprávu
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);           //pošli request spolu s id uživatele kterému aktualizuješ zprávy
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;        
  }
  