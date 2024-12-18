<script>
    var userId = {{auth()->id()}}
    var pusher = new Pusher('dcc0e13b5e4470612577', {
        cluster: 'ap1',
        forceTLS: true
    });
    document.addEventListener('DOMContentLoaded', function () {
        const chatroomsUrl = window.routes.chatroomsUrl; // Access the URL from the global variable
        const roomchatUrl = window.routes.roomchatUrl;
        const chatroomUrlTemplate = window.routes.dormUrl;
        const roomchatUrlTemplate = window.routes.roomUrl;
        const notifyUrl = window.routes.notificationUrl;
        const roomEditUrlTemplate = window.routes.roomEditUrl;
        const markNotificationUrlTemplate = window.routes.markNotificationUrl;
        Pusher.logToConsole = false;
        if (userId) {

            var channel = pusher.subscribe('user.' + userId);
            var channel2 = pusher.subscribe('message.' + userId);


            channel.bind('test.notification', function (data) {

                if (data.sender && data.message) {
                    const maxLength = 50; // You can adjust this limit as needed

                    // Truncate the message if it's longer than the maximum length
                    let truncatedMessage = data.message;
                    if (truncatedMessage.length > maxLength) {
                        truncatedMessage = truncatedMessage.substring(0, maxLength) + '...';
                    }
                    let linker = '';
                    let notificationContent = '';
                    if (data.route === null) {
                        fetchNotifications();
                        linker = markNotificationUrlTemplate.replace(':id', data.rooms);

                        notificationContent = `
        <div onclick='openPopup("${data.message}", null); markNotificationAsRead("${linker}", null);' class="notification-content" id="notify">
            <i class="fas fa-user"></i> <span>${data.sender.name}</span>
            <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.message}</span>
        </div>
    `;
                    } else {
                        fetchNotifications();
                        linker = markNotificationUrlTemplate.replace(':id', data.rooms);

                        // Ensure data.message is properly escaped for use in openPopup
                        notificationContent = `
        <div onclick='openPopup("${data.message}", "${data.route}"); markNotificationAsRead("${linker}", null);' class="notification-content">
            <i class="fas fa-user"></i> <span>${data.sender.name}</span><br>
            <i class="fas fa-book" style="margin-left: 20px;"></i> <span>${data.message}</span>
        </div>
    `;
                    }


                    toastr.info(notificationContent, 'New Notification', {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 0, // Set timeOut to 0 to make it persist until closed
                        extendedTimeOut: 0, // Ensure the notification stays open
                        positionClass: 'toast-top-right',
                        enableHtml: true
                    });



                } else {
                    console.error('Invalid data received:', data);
                }
            });

            // Debugging line for connection status
            pusher.connection.bind('connected', function () {
            });

            // Optional: handle errors
            pusher.connection.bind('error', function (err) {
                console.error('Pusher connection error:', err);
            });
        } else {
            console.error('User is not authenticated.');
        }
    });
</script>