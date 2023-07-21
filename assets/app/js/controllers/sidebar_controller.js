import {Controller} from "@hotwired/stimulus";

export default class SidebarController extends Controller
{
    connect() {
        this.toggle({
            buttonEl: "[data-open-sidebar]",
            sidebarEl:"[data-side-bar]",
            overlayEl:"[data-nav-overlay]"
        })

        this.toggle({
            buttonEl: "[data-toggle-sidebar-tags-list]",
            sidebarEl:"[data-sidebar-tagslist]",
            overlayEl:"[data-tagslist-overlay]"
        })

        this.toggle({
            buttonEl: "[data-toggle-sidebar-list-tag]",
            sidebarEl:"[data-sidebar-tags]",
            overlayEl:"[data-overlay-tags-list]"
        })
    }

    toggle({buttonEl, sidebarEl, overlayEl}) {
        const button = document.querySelector(`${buttonEl}`)
        const sidebar = document.querySelector(`${sidebarEl}`)
        const overlay = document.querySelector(`${overlayEl}`)

        if (button && sidebar && overlay) {
            const openSideBar = () => {
                sidebar.setAttribute("data-is-open", "true")
                document.documentElement.style.overflow = "hidden"
            }
            const closeSideBar = () => {
                sidebar.setAttribute("data-is-open", "false")
                document.documentElement.style.overflowY = "auto"
            }

            button.addEventListener("click", openSideBar)
            overlay.addEventListener("click", closeSideBar)
        }
    }
}
