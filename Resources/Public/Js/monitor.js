/**
 * Monitor.js
 */
document.addEventListener('DOMContentLoaded', () => {
    const monitorUpdateButtons = document.getElementsByClassName('monitorUpdateButton');
    for(let i = 0; i < monitorUpdateButtons.length; i++) {
        monitorUpdateButtons[i].addEventListener("click", function(item) {
        const xhr = new XMLHttpRequest();
        const target = document.getElementById(item.target.dataset.target);
        target.innerHTML = 'generating ... ';
        xhr.open('POST', item.target.dataset.url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            target.innerHTML = this.responseText;
        };
        xhr.send('tx_sitemonitor_generateajax[client]=' + item.target.dataset.client);
        })
    }
    console.log('ficken2002');
});
