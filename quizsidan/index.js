function changeTheme() {
    theme = document.documentElement.getAttribute("data-bs-theme");
    theme === "dark" ? (theme = "light") : (theme = "dark");
    var xhr = new XMLHttpRequest();
  xhr.open("GET", "update_theme.php?theme=" + theme, true);
  xhr.onload = function () {
      document.documentElement.setAttribute("data-bs-theme", theme);
  };
  xhr.send();
}
