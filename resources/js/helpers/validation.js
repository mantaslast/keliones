export function showErrors(errors) {
    let elementNames = Object.keys(errors)
    elementNames.map(name => {
        manageClassOfElement('[name='+name+']', 'is-invalid', 'add')
    })
}

export function hideAllErrors(wrapper) {
    let parent = isElement(wrapper) ? wrapper : document.querySelector(wrapper)
    let errorElements = parent.querySelectorAll('.is-invalid')
    for (let element of errorElements) {
        manageClassOfElement(element, 'is-invalid', 'remove')
      }
}

function manageClassOfElement (el, className, action) {
    let element = isElement(el) ? el : document.querySelector(el)
    if (action === 'add') {
        element.classList.add(className)
    } else {
        element.classList.remove(className)
    }
}

function isElement(element) {
    return element instanceof Element || element instanceof HTMLDocument;  
}