import {Controller} from "@hotwired/stimulus";

export default class TabController extends Controller
{
    connect() {
        const tabControlsParent = "[data-tab-header-profile]"
        const tabcontrolsSelector = "[data-tab-control]"
        const tabBodyContainer = "[data-tab-body-profile]"
        const tabBodyELements = "[data-tab-element]"

        const tabHeaderControl = document.querySelector(`${tabControlsParent}`)

        const tabBody = document.querySelector(`${tabBodyContainer}`)

        if (tabHeaderControl && tabBody) {
            const tabControls = tabHeaderControl.querySelectorAll(`${tabcontrolsSelector}`)
            const tabELements = tabBody.querySelectorAll(`${tabBodyELements}`)
            let activeBtn = tabHeaderControl.querySelector("[aria-selected]")

            let indicator = document.createElement("span")
            indicator.classList.add("tabIndicator")
            tabHeaderControl.appendChild(indicator)
            indicator.style.setProperty("transform", getTransform(activeBtn))


            /**
             * desactivé tous les items de tabcontainer (tabContent)
             */
            const hideAllTabsCont = () => {
                tabELements.forEach((tabContent) => {
                    if (tabContent.classList.contains("hideTabItem")) return;
                    tabContent.classList.add("hideTabItem");

                    if (tabContent.classList.contains("active")) {
                        tabContent.classList.remove("active")
                    }

                    if (tabContent.hasAttribute("aria-selected"))
                        tabContent.removeAttribute("aria-selected")
                })
            }

            /**
             * @param { HtmlElement } => correspond à l'element où l'indicateur sera placé
             * @return { cssStyle } => style à appliquer sur l'indicateur pour transformer sa position, sa taille et sa largeur
             */
            function getTransform(el) {
                const transform = {
                    x: el.offsetLeft,
                    scaleX: el.offsetWidth / 100,
                };
                return `translateX(${transform.x}px) scaleX(${transform.scaleX})`;
            }

            tabControls.forEach(tabControl => {
                tabControl.addEventListener("click", e => {
                    e.preventDefault();
                    hideAllTabsCont();
                    tabBody.querySelector(`#${tabControl.getAttribute("data-target")}`).classList.remove("hideTabItem");
                    tabBody.querySelector(`#${tabControl.getAttribute("data-target")}`).classList.add("active")
                    tabBody.querySelector(`#${tabControl.getAttribute("data-target")}`).setAttribute("aria-selected", "true")
                    if (e.currentTarget !== activeBtn) {
                        activeBtn?.removeAttribute("aria-selected")
                        tabControl.setAttribute("aria-selected", "true")

                        indicator.animate([{ transform: getTransform(tabControl) }], {
                            fill: "both",
                            duration: 600,
                            easing: "linear",
                        })
                        activeBtn = tabControl
                    }
                })
            })

            const showActiveTabContent = () => {
                tabBody.querySelectorAll(`${tabBodyELements}`).forEach(tabContent => {
                    tabBody.querySelectorAll(`${tabBodyELements}`).forEach((tabContent) => {
                        if (tabContent.classList.contains("hideTabItem")) return;
                        tabContent.classList.add("hideTabItem");
                    });
                    tabBody.querySelector("[aria-selected]").classList.remove("hideTabItem");
                    tabBody.querySelector("[aria-selected]").classList.add("active");
                });
            }

            window.addEventListener("load", (e) => {
                e.preventDefault()
                showActiveTabContent()
            })
        }
    }
}
