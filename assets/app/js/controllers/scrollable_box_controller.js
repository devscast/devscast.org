import {Controller} from "@hotwired/stimulus";

export default class ScrollableBoxController extends Controller
{
    static targets = ['content'];

    left = () => {
        this.contentTarget.scrollLeft -= this.contentTarget.clientWidth
    }

    right = () => {
        this.contentTarget.scrollLeft += this.contentTarget.clientWidth
    }
}
