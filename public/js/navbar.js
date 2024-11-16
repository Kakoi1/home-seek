

document.addEventListener('DOMContentLoaded', function() {
    // Fetch notifications when page loads
    fetchNotifications();

    // Select the notification icon and the dropdown menu
    const notificationIcon = document.getElementById('notificationIcon');
    const notificationsMenu = document.getElementById('notificationsMenu');

    // Toggle notification dropdown when the bell icon is clicked
    notificationIcon.addEventListener('click', function() {
        notificationsMenu.classList.toggle('show');
    });

    // Close notification dropdown if clicked outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.notification-wrapper')) {
            notificationsMenu.classList.remove('show');
        }
    });
});

function fetchNotifications() {
    const notifyUrl = window.routes.notificationUrl; // Get the notification URL

    fetch(notifyUrl)
        .then(response => response.json())
        .then(data => {
            const notificationMenu = document.getElementById('notificationsMenu');
            const notificationCount = document.getElementById('notificationCount');
            notificationMenu.style.width = '600px'
            // Clear existing notifications
            notificationMenu.innerHTML = '';
            notificationCount.textContent = data.unread_count; // Set the unread count

            if (data.notifications.length > 0) {
                data.notifications.forEach(notification => {
                    const notificationItem = document.createElement('a');
                    notificationItem.classList.add('dropdown-item', 'notification-item');

                    // Set href based on room_id and notification type
                    notificationItem.href = notification.route;
                    notificationItem.setAttribute('data-id', notification.id);

                    // Create a div for the message and sender
                    const textDiv = document.createElement('div');
                    const messageDiv = document.createElement('div');
                    messageDiv.style.display = 'flex';
                    messageDiv.style.justifyContent = 'space-between';

                    const maxLength = 25;
                    let truncatedMessage = notification.data;
                    if (truncatedMessage.length > maxLength) {
                        truncatedMessage = truncatedMessage.substring(0, maxLength) + '...';
                    }

                    const messageElement = document.createElement('h6');
                    messageElement.innerHTML = truncatedMessage;
                    messageElement.style.margin = 0;
                    messageElement.style.textWrap = 'pretty'

                    const senderElement = document.createElement('p');
                    senderElement.textContent = `Sent by: ${notification.sender.name}`; 
                    senderElement.style.margin = 0;
                    senderElement.style.fontSize = 'smaller';

                    const createdAt = new Date(notification.created_at);
                    const formattedDate = createdAt.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                    });
                    const formattedTime = createdAt.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                    });

                    const timestampElement = document.createElement('span');
                    timestampElement.textContent = `${formattedDate} ${formattedTime}`;
                    timestampElement.style.marginLeft = 'auto';
                    timestampElement.style.fontSize = 'smaller';
                    timestampElement.style.color = '#888';

                    // Add checkmark for read notifications
                    if (notification.read) {
                        const checkMark = document.createElement('span');
                        checkMark.textContent = ' ✓'; // Checkmark symbol
                        checkMark.style.fontSize = 'small';
                        checkMark.style.color = 'green';
                        timestampElement.appendChild(checkMark); // Append checkmark below timestamp
                    }

                    if (!notification.read) {
                        messageElement.style.fontWeight = 'bold';
                        senderElement.style.fontWeight = 'bold';
                        timestampElement.style.fontWeight = 'bold';
                    }

                    textDiv.appendChild(messageElement);
                    textDiv.appendChild(senderElement);
                    messageDiv.appendChild(textDiv);
                    messageDiv.appendChild(timestampElement);
                    notificationItem.appendChild(messageDiv);

                    // Handle click event
                    notificationItem.addEventListener('click', function (e) {
                        e.preventDefault();
                    
                        const markNotificationUrlTemplate = window.routes.markNotificationUrl;
                        const markNotificationUrl = markNotificationUrlTemplate.replace(':id', notification.id);
                    
                        if (notification.route === null) {
                            // Show popup if route is null
                            openPopup(notification.data, null);
                            markNotificationAsRead(markNotificationUrl, null);
                        } else {
                            openPopup(notification.data, notification.route);
                            markNotificationAsRead(markNotificationUrl, null);
                        }
                    });

                    notificationMenu.appendChild(notificationItem);
                });
            } else {
                notificationMenu.innerHTML = '<span class="dropdown-item">No new notifications</span>';
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

function markNotificationAsRead(markNotificationUrl, redirectUrl) {
    fetch(markNotificationUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
    })
        .then(response => {
            if (response.ok) {
                if (redirectUrl == null) {
                    fetchNotifications();
                } else {
                    window.location.href = redirectUrl;
                }
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
}

// Open popup with message
function openPopup(message, redirectUrl) {
    document.getElementById('popupMessage').innerHTML = message;
    document.getElementById('userNot').style.display = 'flex';
    console.log(redirectUrl);

    var closeButton = document.getElementById('closeButton');
    if (closeButton) {
        closeButton.onclick = function() {
            closePopup(redirectUrl);
        }
    } else {
        console.error('Close button not found in the DOM');
    }
}

// Close popup
function closePopup(redirectUrl) {
    // Hide the popup
    document.getElementById('userNot').style.display = 'none';

    // Redirect if a URL is provided
    if (redirectUrl) {
        window.location.href = redirectUrl;
    } else {
        console.log('No redirect URL provided.');
    }
}





// Fetch data every 2 seconds
// setInterval(fetchNotifications, 2000);
// setInterval(fetchConvo, 2000);