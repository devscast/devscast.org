import {Controller} from "@hotwired/stimulus";
import SimpleBar from 'simplebar';
import ResizeObserver from 'resize-observer-polyfill';

// You will need a ResizeObserver polyfill for browsers that don't support it! (iOS Safari, Edge, ...)
window.ResizeObserver = ResizeObserver;

export default class ScrollbarController extends Controller
{
    connect () {
        const slideScrollBar = document.querySelector('[data-simple-scroll-container]')
        if(slideScrollBar){
            new SimpleBar(slideScrollBar);
        }

        const costumScrollBars = document.querySelectorAll('[data-costum-scrollbar]')
        if (costumScrollBars) {
            costumScrollBars.forEach(costumScrollBar=>new SimpleBar(costumScrollBar))
        }

        const preTags = document.querySelectorAll("pre")
        if(preTags){
            preTags.forEach(precodebloc =>{
                new SimpleBar(precodebloc)
            })
        }
    }
}
