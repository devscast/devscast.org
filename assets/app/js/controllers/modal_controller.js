import {Controller} from "@hotwired/stimulus";

export default class ModalController extends Controller {
    static targets = ['content', 'trigger'];

    connect() {
        this.triggerTarget.addEventListener('click', this.open);
    }

    open() {
        this.contentTarget.style.animation = 'reveal-modal-content .1s linear';
        document.body.style.overflow = 'hidden';
        document.body.style.overflowY = 'hidden';
        this.triggerTarget.setAttribute('aria-hidden', 'false');
    }

    close () {
        this.contentTarget.style.animation = 'none';
        document.body.style.overflowY = 'auto';
        this.triggerTarget.setAttribute('aria-hidden', 'true');
    }
}
