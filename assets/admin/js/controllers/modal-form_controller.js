import { Controller } from '@hotwired/stimulus';
import {redirect} from "../../../shared/js/utils/url";
import {toast} from "../../../shared/js/utils/alert";

export default class ModalFormController extends Controller {
    static targets = ['modal'];
    modal = null;

    connect()
    {
        this.element.addEventListener('turbo:submit-end', (event) => {
            if (event.detail.success) {
                this.modal.hide();
            }
        });

        document.addEventListener('turbo:before-fetch-response', async(event) => {
            if (!this.modal || !this.modal._isShown) {
                return
            }

            const fetchResponse = event.detail.fetchResponse;
            if (fetchResponse.succeeded && fetchResponse.redirected) {
                event.preventDefault()
                this.modal.dispose()

                await redirect(fetchResponse.location)
                await toast("success", "action effectuée avec succès")
            }
        })
    }

    async open(event)
    {
        this.modal = new window.bootstrap.Modal(this.modalTarget);
        this.modal.show()
    }

    async close(event)
    {
        this.modal.dispose()
    }
}
