var bouton_accueil = document.getElementById("acces_accueil");
var circle =  document.getElementById("circle");

bouton_accueil.addEventListener("click",()=>{
   circle.classList.toggle("clicked");
   bouton_accueil.style.backgroundColor ="red";


   
});