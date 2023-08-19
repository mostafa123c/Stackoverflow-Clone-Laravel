import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


window.Echo.private('App.Models.User.' + userId)
    .notification(function (data) {
        // alert(data.body)
        var notificationToast = document.getElementById('notificationToast')
        var toast = new bootstrap.Toast(notificationToast)
        document.getElementById('notification-body').innerHTML = data.body
        document.getElementById('notification-title').innerHTML = data.title
        document.getElementById('notification-time').innerHTML = new Date()
        toast.show()

        const countElm = document.getElementById('nm-count')
        let count = Number(countElm.innerText)
        countElm.innerText = count + 1

        const listElm = document.getElementById('nm-list')
        listElm.innerHTML = `<li><a class="dropdown-item" href="${data.url}?notify_id=${data.id}">
                    <h6>${data.title}</h6>
                    <p>${data.body}</p>
                    <p class="text-muted">${(new Date).toLocaleTimeString()}</p>
                </a></li>` + listElm.innerHTML


    });
