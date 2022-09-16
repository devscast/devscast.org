import * as Turbo from '@hotwired/turbo'

/**
 * @param {object} obj
 * @return {URLSearchParams}
 */
export function objToSearchParams(obj) {
    if (obj === undefined || obj === null) {
        return new URLSearchParams()
    }
    const params = new URLSearchParams()
    Object.keys(obj).forEach(k => {
        params.append(k, obj[k])
    })
    return params
}

/**
 * Redirect to a specific url using turbo
 */
export function redirect(url) {
    return new Promise((resolve) => {
        const onLoad = function () {
            resolve()
            document.removeEventListener('turbo:load', onLoad)
        }
        document.addEventListener('turbo:load', onLoad)
        Turbo.visit(url)
    })
}
