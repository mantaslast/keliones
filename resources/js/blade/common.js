loginPopupShow = (event) => {
    event.preventDefault
    document.getElementById('loginPopup').style.display = 'block';
    document.querySelector('.body_overlay').style.display = 'block';
    return false;
}

bodyOverlayShow = () => {
    document.querySelector('.body_overlay').style.display = 'block';
}

bodyOverlayHide = () => {
    document.querySelector('.body_overlay').style.display = 'none';
}

paymentModalShow = () => {
    bodyOverlayShow()
    document.querySelector('.paymentModal').style.display = 'block';
}

paymentModalHide = () => {
    bodyOverlayHide()
    document.querySelector('.paymentModal').style.display = 'none';
}