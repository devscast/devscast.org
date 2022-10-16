// dashlite theme
import './scss/dashlite.min.css'

// start stimulus app
import './js/bootstrap'

// custom elements definition
import Toast from "../shared/js/elements/Toast";
import {InputChoices, SelectChoices} from "../shared/js/elements/Choices";
import AutogrowTextarea from "../shared/js/elements/AutogrowTextarea";
import DatePicker from "../shared/js/elements/DatePicker";
import {Workbox} from "workbox-window";
import {installServiceWorker} from "../shared/js/utils/alert";

// Custom Element
customElements.define('app-toast', Toast)
customElements.define('app-input-choices', InputChoices, {extends: 'input'})
customElements.define('app-select-choices', SelectChoices, {extends: 'select'})
customElements.define('app-textarea-autogrow', AutogrowTextarea, {extends: 'textarea'})
customElements.define('app-datepicker', DatePicker, {extends: 'input'})

if ("serviceWorker" in navigator) {
    window.addEventListener("load", async () => {
        const wb = new Workbox('/sw.js', {scope: '/'})
        const showSkipWaitingPrompt = async () => {
            await installServiceWorker(() => {
                wb.addEventListener('controlling', (event) => {
                    window.location.reload()
                })
                wb.messageSkipWaiting()
            })
        };

        // Add an event listener to detect when the registered
        // service worker has installed but is waiting to activate.
        wb.addEventListener('waiting', showSkipWaitingPrompt);
        await wb.register();
    })
}