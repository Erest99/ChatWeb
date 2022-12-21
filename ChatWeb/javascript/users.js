const searchBar = document.querySelector(".search input"),      //vyhledávací pole
searchIcon = document.querySelector(".search button"),          //tlačítko vyhledávání
usersList = document.querySelector(".users-list");              //předem připravená oblast pro dynamické vložení userů

searchIcon.onclick = ()=>{                                      //přepínání vyhledávače (ikona + hledání)
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();
  if(searchBar.classList.contains("active")){                   
    searchBar.value = "";                                       //musí být reset hodnoty protože při "vypnutí" jde jenom do pozadí
    searchBar.classList.remove("active");
  }
}

searchBar.onkeyup = ()=>{                                       //po zvednutí libovolné klávesy ve vyhledávacím poli
  let searchTerm = searchBar.value;
  if(searchTerm != ""){                                         //kontrola "vypnutí"
    searchBar.classList.add("active");
  }else{
    searchBar.classList.remove("active");
  }
  let xhr = new XMLHttpRequest();                                //nový request
  xhr.open("POST", "php/search.php", true);                      //nastavení request
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){                  //zkontroluj úplnost
        if(xhr.status === 200){                                  //zkontroluj jestli request byl úspěšný
          let data = xhr.response;
          usersList.innerHTML = data;                            //naplň user oblast odpovědí
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  //nastav hlavičku
  xhr.send("searchTerm=" + searchTerm);                          //pošli request
}

setInterval(() =>{                                               //každých 500ms aktualizuj user-list
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "php/users.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;
          if(!searchBar.classList.contains("active")){
            usersList.innerHTML = data;
          }
        }
    }
  }
  xhr.send();
}, 500);

