
document.addEventListener("DOMContentLoaded", function() {
    
    document.getElementById('closeSidebar').addEventListener('click', closeSidebar)
    document.getElementById('openSidebar').addEventListener('click', openSidebar)
    document.querySelectorAll('.deleteUser').forEach((el) => {
        el.addEventListener('click', deleteUserConfirm)
    })
    document.addEventListener('click', closeSidebarOnOutsideClick)
  });

function closeSidebar (e) {
    let sidebar = document.querySelector('.sidebar')
    sidebar.style.left = "-17em";
}

function openSidebar (e) {
    let sidebar = document.querySelector('.sidebar')
    sidebar.style.left = '0'
}

function deleteUserConfirm (e) {
    e.preventDefault()
    let c = confirm(' Ar tikrai norite ištrinti vartotoją? ')
    if (c === true) {
        e.target.closest('form').submit()
    } else {
        return false
    }
}

function closeSidebarOnOutsideClick(e) {
    e.stopPropagation()
    let sidebar = document.querySelector('.sidebar')
    let sidebarOpenButton = document.getElementById('openSidebar')
    if (e.target !== sidebar && !sidebar.contains(e.target) && e.target !== sidebarOpenButton) {
        closeSidebar()
    }
}