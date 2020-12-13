let FroalaEditor = require('froala-editor');
require('froala-editor/js/plugins/align.min.js')

document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('description')) {
        new FroalaEditor('textarea',{
            width: '800'
        });
    }
    document.getElementById('closeSidebar').addEventListener('click', closeSidebar)
    document.getElementById('openSidebar').addEventListener('click', openSidebar)
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

function closeSidebarOnOutsideClick(e) {
    e.stopPropagation()
    let sidebar = document.querySelector('.sidebar')
    let sidebarOpenButton = document.getElementById('openSidebar')
    if (e.target !== sidebar && !sidebar.contains(e.target) && e.target !== sidebarOpenButton) {
        closeSidebar()
    }
}