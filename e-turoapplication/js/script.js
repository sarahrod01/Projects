function userbtn(){
   let profile = document.querySelector('.header .flex .profile');

   document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   search.classList.remove('active');
   }
}
function menubtn(){
   let sideBar = document.querySelector('.side-bar');

   document.querySelector('#menu-btn').onclick = () =>{
      sideBar.classList.toggle('active');
      body.classList.toggle('active');
   }

   document.querySelector('#close-btn').onclick = () =>{
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }
}
function searchbtn(){
   let search = document.querySelector('.header .flex .search-form');

   document.querySelector('#search-btn').onclick = () =>{
      search.classList.toggle('active');
      profile.classList.remove('active');
   }
}