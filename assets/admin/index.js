// dashlite theme
import './scss/dashlite.min.css'
import './scss/skins/theme-bluelite.css'

// start stimulus app
import './js/bootstrap'

// custom elements definition
import Toast from "../shared/js/elements/Toast";
import {InputChoices, SelectChoices} from "../shared/js/elements/Choices";
import AutogrowTextarea from "../shared/js/elements/AutogrowTextarea";
import DatePicker from "../shared/js/elements/DatePicker";

// Custom Element
customElements.define('app-toast', Toast)
customElements.define('app-input-choices', InputChoices, {extends: 'input'})
customElements.define('app-select-choices', SelectChoices, {extends: 'select'})
customElements.define('app-textarea-autogrow', AutogrowTextarea, {extends: 'textarea'})
customElements.define('app-datepicker', DatePicker, {extends: 'input'})
