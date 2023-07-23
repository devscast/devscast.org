import {Controller} from "@hotwired/stimulus";

export default class SwitchThemeController extends Controller
{
    connect() {
        const isDarkMode = localStorage.getItem("appTheme") === "dark" ||
            (!("appTheme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches)

        window.addEventListener("load", ()=> {
            isDarkMode ?
                document.documentElement.classList.add("dark") :
                document.documentElement.classList.remove("dark");
        });

        this.element.addEventListener("click", (e) => {
            e.preventDefault();

            if (localStorage.getItem("appTheme")) {
                if (localStorage.getItem("appTheme") === "light") {
                    document.documentElement.classList.add("dark");
                    localStorage.setItem("appTheme", "dark");
                } else {
                    document.documentElement.classList.remove("dark");
                    localStorage.setItem("appTheme", "light");
                }
            } else {
                if (document.documentElement.classList.contains("dark")) {
                    document.documentElement.classList.remove("dark");
                    localStorage.setItem("appTheme", "light");
                } else {
                    document.documentElement.classList.add("dark");
                    localStorage.setItem("appTheme", "dark");
                }
            }
        });
    }
}
