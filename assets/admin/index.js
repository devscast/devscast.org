// dashlite theme
import './scss/dashlite.min.css'
import './scss/skins/theme-green.css'
import './scss/attachment.scss'
import 'filemanager-element/FileManager.css'

// start stimulus app
import './js/bootstrap'

// custom elements definition
import Toast from "../shared/js/elements/Toast";
import {InputChoices, SelectChoices} from "../shared/js/elements/Choices";
import AutogrowTextarea from "../shared/js/elements/AutogrowTextarea";
import DatePicker from "../shared/js/elements/DatePicker";
import {Workbox} from "workbox-window";
import {installServiceWorker} from "../shared/js/utils/alert";
import {MarkdownEditor} from "../shared/js/elements/editor";
import DeleteButton from "./js/elements/DeleteButton";
import ActionButton from "./js/elements/ActionButton";
import SpinningDots from "../shared/js/elements/SpinningDots";
import InputAttachment from "./js/elements/InputAttachment";
import {ModalDialog} from "../shared/js/elements/ModalDialog";
import {FileManager} from "filemanager-element";

// Custom Element
customElements.define('app-toast', Toast)
customElements.define('app-input-choices', InputChoices, {extends: 'input'})
customElements.define('app-input-attachment', InputAttachment, { extends: 'input' })
customElements.define('app-select-choices', SelectChoices, {extends: 'select'})
customElements.define('app-textarea-autogrow', AutogrowTextarea, {extends: 'textarea'})
customElements.define('app-markdown-editor', MarkdownEditor, { extends: 'textarea' })
customElements.define('app-datepicker', DatePicker, {extends: 'input'})
customElements.define('app-delete-button', DeleteButton, {extends: 'button'})
customElements.define('app-action-button', ActionButton, {extends: 'button'})
customElements.define('modal-dialog', ModalDialog)
customElements.define('spinning-dots', SpinningDots)
FileManager.register();

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
        await wb.register();
    })
}
