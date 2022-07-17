// dashlite theme
import './scss/app.scss'

// start stimulus app
import './js/bootstrap'
import {Workbox} from "workbox-window";
import {installServiceWorker} from "./js/utils/alert";
import axios from "./js/utils/axios";

// custom elements definitions
import SpinningDots from "./js/elements/SpinningDots"
import LoaderOverlay from "./js/elements/LoaderOverlay"
import Skeleton from "./js/elements/Skeleton"
import Toast from "./js/elements/Toast";
import {InputChoices, SelectChoices} from "./js/elements/Choices";
import AutogrowTextarea from "./js/elements/AutogrowTextarea";
import DatePicker from "./js/elements/DatePicker";

// Custom Element
customElements.define('app-loader-spinning', SpinningDots)
customElements.define('app-loader-overlay', LoaderOverlay)
customElements.define('app-loader-skeleton', Skeleton)
customElements.define('app-toast', Toast)
customElements.define('app-input-choices', InputChoices, {extends: 'input'})
customElements.define('app-select-choices', SelectChoices, {extends: 'select'})
customElements.define('app-textarea-autogrow', AutogrowTextarea, {extends: 'textarea'})
customElements.define('app-datepicker', DatePicker, {extends: 'input'})

/*const pushPermission = document.querySelector('#push-permission');
if (pushPermission && Notification.permission === 'default') {
    pushPermission.addEventListener("click", async() => {
        await Notification.requestPermission()
    })
}*/

if ("serviceWorker" in navigator) {
    window.addEventListener("load", async() => {
        const wb = new Workbox('/sw.js', {scope: '/'})
        const showSkipWaitingPrompt = async() => {
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
        /*const registration = await wb.register();

        let subscription = await registration.pushManager.getSubscription();
        if (!subscription) {
            subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: await axios.get('/notification/push/key').then(r => r.data.key)
            });
        }

        await axios.post('/notification/push/subscribe', subscription.toJSON());*/
    });
}
