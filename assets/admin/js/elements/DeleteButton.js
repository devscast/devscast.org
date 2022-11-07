import axios from "../../../shared/js/utils/axios"
import {confirmation, toast} from "../../../shared/js/utils/alert"
import {closest, createButtonLoader, removeButtonLoader, removeFadeOut} from "../../../shared/js/utils/dom"
import {redirect} from "../../../shared/js/utils/url";

export default class DeleteButton extends HTMLButtonElement {
    connectedCallback()
    {
        const _token = this.getAttribute('token')
        const endpoint = this.getAttribute('endpoint')
        const redirectUrl = this.getAttribute('redirect')
        const content = this.innerHTML

        this.addEventListener('click', async e => {
            e.preventDefault()
            await confirmation("supprimer", async() => {
                createButtonLoader(this)
                try {
                    const response = await axios.delete(endpoint, {data: {_token}})
                    if (response.status === 202) {
                        if (redirect.length > 0) {
                            await redirect(redirectUrl);
                        } else {
                            removeFadeOut(closest(this, 'tr'));
                        }

                        await toast("success", "Suppression effectuée avec succès");
                    } else {
                        removeButtonLoader(this, content);
                        await toast("error", "Désolé, une erreur est survenue lors de la suppression");
                    }
                } catch (e) {
                    console.error({e});
                    removeButtonLoader(this, content);
                    await toast("error", e.response.data.message);
                }
            });
        })
    }
}
