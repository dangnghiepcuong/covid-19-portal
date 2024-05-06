$(document).ready(function () {
    $('.notifications .icon_wrap').on('click', function () {
        $(this).parent().toggleClass('active');

        if ($(this).parent().hasClass('active')) {
            window.getNotifications()
        }
    });

    $('#notification_ul').on('click', '.show_all .link', function () {
        $('.notifications').removeClass('active');
        $('.popup').show();
    });

    $('#all_notifications_ul').on('click', '.close', function () {
        $('.popup').hide();
    });

    // Enable pusher logging - don't include this in production
    window.Pusher.logToConsole = true;

    var pusher = new window.Pusher(window.PUSHER_APP_KEY, {
        cluster: window.PUSHER_APP_CLUSTER
    });
    var channel = pusher.subscribe(window.USER_PRIVATE_CHANNEL);
    channel.bind(window.EVENT_VACCINATION_REGISTERED, function (data) {
        window.toastr.info(`${data.title} ${data.content}`)
    });
});

window.getNotifications = function () {
    $.ajax({
        cache: false,
        url: '/api/v1/notifications',
        method: 'GET',
        success: function (result) {
            console.log(result)
            $('.notification_ul').html(``)
            $('#notification_ul').html(`
                <li class="show_all">
                    <p class="link">Show All Activities</p>
                </li>
            `)
            for (let element of result.data) {
                let date = new Date(element.created_at)
                let read = element.read_at === null ? 'unread' : 'read'
                $('.notification_ul').prepend(`
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
            $('#all_notifications_ul').prepend(`
                <li class="title">
                    <p>All Notifications</p>
                    <p class="close"><i class="fas fa-times" aria-hidden="true"></i></p>
                </li>
            `)
        },
    })
}
