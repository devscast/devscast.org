import {Controller} from "@hotwired/stimulus";

export default class CommentBlockController extends Controller {
    static targets = ["show", "hide"];

    connect() {
        this.showTarget.addEventListener("click",  () => this.element.setAttribute("data-show-comment-box-area","true"));
        this.hideTarget.addEventListener("click", e => {
            e.preventDefault()
            this.element.setAttribute("data-show-comment-box-area","")
        });
    }
}
