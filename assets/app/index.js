// devscast community theme
import './scss/app.scss'

// start stimulus app
import './js/bootstrap'

// custom elements definition
import Toast from "../shared/js/elements/Toast";
import {Workbox} from "workbox-window";
import {installServiceWorker} from "../shared/js/utils/alert";

// Custom Element
customElements.define('app-toast', Toast)

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
