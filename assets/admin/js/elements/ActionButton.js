import axios from "../../../shared/js/utils/axios"
import {confirmation, toast} from "../../../shared/js/utils/alert"
import {createButtonLoader, removeButtonLoader} from "../../../shared/js/utils/dom"
import {redirect} from "../../../shared/js/utils/url";

export default class ActionButton extends HTMLButtonElement {
    connectedCallback()
    {
        const _token = this.getAttribute('token')
        const endpoint = this.getAttribute('endpoint')
        const redirectUrl = this.getAttribute('redirect')
        const label = this.innerHTML

        this.addEventListener('click', async e => {
            e.preventDefault()
            await confirmation(label, async() => {
                createButtonLoader(this)
                try {
                    const response = await axios.post(endpoint, _token ? {_token} : {})
                    if (response.status === 202 || response.status === 200) {
                        await toast("success", response.data.message ?? 'action effectué avec succès !');
                        redirectUrl && await redirect(redirectUrl);
                    } else {
                        await toast("error", response.data.message);
                    }
                } catch (e) {
                    console.error({e});
                    await alert("error", e.response.data.message);
                } finally {
                    removeButtonLoader(this, label);
                }
            });
        })
    }
}
