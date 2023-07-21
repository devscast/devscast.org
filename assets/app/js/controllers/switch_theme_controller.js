import {Controller} from "@hotwired/stimulus";

export default class SwitchThemeController extends Controller
{
    connect() {
        const switchTheme = document.querySelector("[data-switch-theme]")

        window.addEventListener("load", ()=>{
            if (
                localStorage.getItem("appTheme") === "dark" ||
                (!("appTheme" in localStorage) &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches)
            ) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        })


        if (switchTheme) {
            switchTheme.addEventListener("click", (e) => {
                e.preventDefault();
                const doc = document.documentElement;
                if (doc) {
                    if (localStorage.getItem("appTheme")) {
                        if (localStorage.getItem("appTheme") === "light") {
                            doc.classList.add("dark");
                            localStorage.setItem("appTheme", "dark");
                        } else {
                            document.documentElement.classList.remove("dark");
                            localStorage.setItem("appTheme", "light");
                        }
                    } else {
                        if (doc.classList.contains("dark")) {
                            doc.classList.remove("dark");
                            localStorage.setItem("appTheme", "light");
                        } else {
                            doc.classList.add("dark");
                            localStorage.setItem("appTheme", "dark");
                        }
                    }
                }
            })
        }
    }
}
