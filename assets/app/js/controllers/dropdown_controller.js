import {Controller} from "@hotwired/stimulus";

export default class DropdownController extends Controller {
    static targets = ['trigger'];

    connect() {
        this.tiggerTarget.addEventListener('click', this.toggle);

        document.addEventListener('mousedown', (e) => {
            if (this.element && !this.element.contains(e.target)) {
                this.close();
            }
        });
    }

    close() {
        this.element.setAttribute("data-dropdown-open", "false");
    }

    toggle() {
        const state = this.element.getAttribute("data-dropdown-open") === "true" ? "false" : "true";
        this.element.setAttribute("data-dropdown-open", state);
    }
}
