import {bindHighlight} from "../utils/highlightjs";

export class SyntaxCode extends HTMLDivElement {
    connectedCallback() {
        bindHighlight(this)
    }
}
