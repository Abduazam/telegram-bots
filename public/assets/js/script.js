/**
 * Showing bootstrap toast function.
 */
function showToast(event) {
    let toast = document.getElementById('toast');
    let toastIcon = toast.querySelector('.toast-header i');
    let toastTitle = toast.querySelector('.toast-header strong');
    let toastBody = toast.querySelector('.toast-body');

    toastIcon.className = event.detail[0].icon;
    toastTitle.innerText = event.detail[0].title;
    toastBody.innerHTML = event.detail[0].description;

    new bootstrap.Toast(toast).show();
}

/**
 * Showing bootstrap toast listener.
 */
window.addEventListener('dispatch-toast', showToast);

/**
 * Refreshing page listener.
 */
window.addEventListener('refresh-page', function () {
    location.reload();
});
