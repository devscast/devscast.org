import { startStimulusApp } from '@symfony/stimulus-bridge'
import ModalFormController from "./controllers/modal-form_controller"

export const app = startStimulusApp()

app.register('modal-form', ModalFormController)
