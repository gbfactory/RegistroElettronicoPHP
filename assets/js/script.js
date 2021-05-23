// Script Registro Elettronico
//       Using jQuery

$(document).ready(function() {
    // Materialize CSS
    $('.sidenav').sidenav();
    // $('.tabs').tabs();
    $('.tooltipped').tooltip();
    $('.collapsible').collapsible();
    $('.modal').modal();

    // Theme toggle
    // https://github.com/mritunjaysaha/-BLOG-local-storage
    const themeSwitcher = document.getElementById("theme-switch");

    themeSwitcher.checked = false;
    function clickHandler() {
        if (this.checked) {
            document.body.classList.remove("light");
            document.body.classList.add("dark");
            localStorage.setItem("theme", "dark");
        } else {
            document.body.classList.add("light");
            document.body.classList.remove("dark");
            localStorage.setItem("theme", "light");
        }
    }
    themeSwitcher.addEventListener("click", clickHandler);
    
    window.onload = checkTheme();
    
    function checkTheme() {
        const localStorageTheme = localStorage.getItem("theme");
    
        if (localStorageTheme !== null && localStorageTheme === "dark") {
            // set the theme of body
            document.body.className = localStorageTheme;
    
            // adjust the slider position
            const themeSwitch = document.getElementById("theme-switch");
            themeSwitch.checked = true;
        }
    }

    // Rimuovi iubenda
    $('.iubenda-tp-btn.iubenda-cs-preferences-link').remove();
});
