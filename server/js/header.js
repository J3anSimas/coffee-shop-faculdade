let userMenu = document.querySelector(".user-menu");
if (userMenu) {
  userMenu.addEventListener("click", () => {
    document.querySelector(".user-menu-list").classList.toggle("show");
  });
}
