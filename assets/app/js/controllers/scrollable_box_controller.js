import {Controller} from "@hotwired/stimulus";

export default class ScrollableBoxController extends Controller
{
    connect() {
        const containers = document.querySelectorAll("[data-scrollable-container]")
        if (containers) {
            containers.forEach(scrollContainer => {
                const buttonLeft = scrollContainer.querySelector("[data-scroll-to-left]")
                const buttonRight = scrollContainer.querySelector("[data-scroll-to-right]")
                const content = scrollContainer.querySelector("[data-scrollable]")

                const onScroll = () => {
                    if (content.scrollLeft <= 0) {
                        buttonLeft.classList.add("!hidden");
                    } else {
                        buttonLeft.classList.remove("!hidden");
                    }

                    if (content.scrollLeft >= content.scrollWidth - content.offsetWidth - 1) {
                        buttonRight.classList.add("!hidden");
                    } else {
                        buttonRight.classList.remove("!hidden");
                    }
                }

                buttonLeft.addEventListener("click", () => content.scrollLeft -= content.clientWidth);
                buttonRight.addEventListener("click",  () => content.scrollLeft += content.clientWidth);

                content.addEventListener("scroll", onScroll);
                window.addEventListener("load", onScroll);
            })
        }
    }
}
