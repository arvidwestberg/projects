// function change_theme() {
//   const theme = document.querySelector("html");
//   var setTheme = (usedTheme) => {
//     theme.setAttribute("data-bs-theme", usedTheme);
//   };
//   const totalScore = document.getElementById("totalScore");
// //   const array = [
// //     {
// //       html_element: document.querySelectorAll(".topTenLight"),
// //       dark: ["bg-dark", "text-light"],
// //       light: ["bg-light", "text-dark"],
// //     },
// //     {
// //       html_element: document.querySelectorAll(".topTenWhite"),
// //       dark: ["bg-white", "text-dark"],
// //       light: ["bg-white", "text-dark"],
// //     },
// //   ];

//   if (theme.getAttribute("data-bs-theme") === "dark") {
//     setTheme("light");
//     // array.forEach((element) => {
//     //   element.html_element.forEach((el) => {
//     //     el.classList.remove(element.dark);
//     //     el.classList.add(element.light);
//     //     console.log(el);
//     //     console.log("removed: " + element.dark);
//     //     console.log("added: " + element.light);
//     //     console.log("====================");
//     //   });
//     // });
//   } else {
//     setTheme("dark");
//     // totalScore.classList.remove("bg-light", "text-dark");
//     // totalScore.classList.add("bg-dark", "text-light");
//   }

//   console.log(theme.getAttribute("data-bs-theme"));
// }

function changeTheme() {
    theme = document.documentElement.getAttribute("data-bs-theme");
    theme === "dark" ? (theme = "light") : (theme = "dark");
    // get the current theme
    // Make an AJAX request to update the theme
    var xhr = new XMLHttpRequest();
  xhr.open("GET", "update_theme.php?theme=" + theme, true);
  xhr.onload = function () {
      document.documentElement.setAttribute("data-bs-theme", theme);
  };
  xhr.send();
}
