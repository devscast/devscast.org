import {toast} from '../utils/alert'

export default class Toast extends HTMLElement {
    async connectedCallback() {
        await toast(this.getAttribute('type'), this.getAttribute('message'))
    }
}
