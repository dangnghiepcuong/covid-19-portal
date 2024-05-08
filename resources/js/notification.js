let bindingNotification = false

$(document).ready(function () {
    window.countUnread()

    // BELL ON CLICK REFRESH NOTIFICATION LIST
    $('.notifications .icon_wrap').on('click', function () {
        $(this).parent().toggleClass('active');

        if ($(this).parent().hasClass('active')) {
            window.refreshNotificationList()
        }
    });

    // MARK ALL AS READ
    $('#notification_ul').on('click', '.show_all .link', function () {
        window.markAllAsRead()
    });

    // BELL ON SCROLL LOAD MORE NOTIFICATION
    let lastScrollTop = 0;
    let notification_dd = $('#notification_dd')
    notification_dd.on('scroll', function () {
        if (notification_dd.scrollTop() + notification_dd.outerHeight() >= notification_dd[0].scrollHeight) {
            window.getNotifications()
        }
        lastScrollTop = notification_dd.scrollTop() <= lastScrollTop ? 0 : notification_dd.scrollTop();
    })

    // PUSHER LISTEN TO BROADCAST NOTIFCATION
    var pusher = new window.Pusher(window.PUSHER_APP_KEY, {
        cluster: window.PUSHER_APP_CLUSTER
    });
    var channel = pusher.subscribe(window.USER_PRIVATE_CHANNEL);
    channel.bind(window.EVENT_VACCINATION_REGISTERED, function (data) {
        let currentCountUnread = $('#new_notification_dot').text()
        if (currentCountUnread === '9+') {
            $('#new_notification_dot').show()
        } else if (parseInt(currentCountUnread) < 9) {
            $('#new_notification_dot').text(parseInt(currentCountUnread) + 1)
            $('#new_notification_dot').show()
        } else {
            $('#new_notification_dot').text(1)
            $('#new_notification_dot').show()
        }

        window.toastr.info(`${data.title} ${data.content}`)
    });
});

window.getNotifications = function () {
    // Check if previous ajax request is still binding notifications
    if (bindingNotification) {
        return
    }

    // Check if all notifications are loaded
    let lastPage = parseInt($('#last_page').val())
    let currentPage = parseInt($('#current_page').val())
    if (currentPage >= lastPage) {
        return
    }

    bindingNotification = true

    $.ajax({
        cache: false,
        url: '/api/v1/notifications',
        method: 'GET',
        data: { page: currentPage + 1 },
        success: function (result) {
            $('#last_page').val(result.last_page)
            $('#current_page').val(result.current_page)

            let read = 'read'
            for (let element of result.data) {
                let date = new Date(element.created_at)
                if (element.read_at === null) {
                    read = 'unread'
                } else {
                    read = 'read'
                }

                $('#notification_ul li:last').before(`
                        <li id="${element.id}" class="${read}">
                            <div class="notify_data">
                                <div class="title">
                                    ${element.data.title}
                                </div>
                                <div class="sub_title">
                                    ${element.data.content}
                                </div>
                                <div class="notify_time">
                                    <p>${date.toLocaleDateString()} ${date.toLocaleTimeString()}</p>
                                </div>
                            </div>
                        </li>
                    `)
            }
            bindingNotification = false
        },
    })
}

window.countUnread = function () {
    $.ajax({
        cache: false,
        url: 'api/v1/notifications/countUnread',
        method: 'GET',
        success: function (result) {
            if (result) {
                result = result > 9 ? '9+' : result
                $('#new_notification_dot').text(result)
                $('#new_notification_dot').show()
            }
        }
    })
}

window.markAllAsRead = function () {
    let token = $('#markAllAsReadToken').val()
    $.ajax({
        cache: false,
        url: 'api/v1/notifications/markAllAsRead',
        method: 'POST',
        data: { _token: token },
        success: function (result) {
            switch (result['status']) {
            case 'success':
                window.refreshNotificationList()
                $('#new_notification_dot').text('')
                $('#new_notification_dot').hide()
                break

            default:
            }
        }
    })
}

window.refreshNotificationList = function () {
    $('#last_page').val(0)
    $('#current_page').val(-1)
    $('#notification_ul').html(`
        <li class="show_all">
            <p class="link">${window.trans('notification.mark_all_as_read')}</p>
        </li>
    `)
    window.getNotifications()
}
