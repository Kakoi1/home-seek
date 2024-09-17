
function fetchConvo() {
    const chatroomsUrl = window.routes.chatroomsUrl; // Access the URL from the global variable
    const roomchatUrl = window.routes.roomchatUrl;
    const chatroomUrlTemplate = window.routes.dormUrl;
    const roomchatUrlTemplate = window.routes.roomUrl;
    fetch(chatroomsUrl)
        .then(response => response.json())
        .then(chatrooms => {
            console.log('Fetched chatrooms:', chatrooms); // Log the chatrooms data
            
            // Initialize unread message counters
            let totalUnreadDormInquiries = 0;
            let totalUnreadRoomInquiries = 0;

            // Fetch room chats
            fetch(roomchatUrl)
                .then(response => response.json())
                .then(roomChats => {
                    console.log('Fetched room chats:', roomChats); // Log the room chats data
                    
                    const chatroomDropdownMenu = document.getElementById('chatroomDropdownMenu');
                    chatroomDropdownMenu.innerHTML = '';
                    
                    // Add chatrooms to dropdown
                    chatroomDropdownMenu.innerHTML += `<h6>Dorm Inquiries:</h6>`;
                    chatrooms.chat.forEach(chatroom => {
                        const unreadCount = chatroom.unread_count;
                        const chatroomUrl = chatroomUrlTemplate
                        .replace(':id', chatroom.dorm_id)
                        .replace(':room_id', chatroom.chatroom_id);
    

                        const chatroomItem = document.createElement('a');
                        chatroomItem.classList.add('dropdown-item');
                        chatroomItem.href = chatroomUrl;
                        chatroomItem.textContent = `Chat with ${chatroom.dorm_name} (${chatroom.user_name})`;
                    
                        // Only add the unread count if there are unread messages
                        if (unreadCount > 0) {
                            const messageCount = document.createElement('span');
                            messageCount.style.color = 'white';
                            messageCount.classList.add('badge', 'bg-danger', 'ms-2');
                            messageCount.textContent = ` (${unreadCount})`;
                            chatroomItem.appendChild(messageCount);
                            totalUnreadDormInquiries++;
                        }
                    
                        chatroomDropdownMenu.appendChild(chatroomItem);
                    });

                    // Add separator
                    chatroomDropdownMenu.innerHTML += '<hr>';

                    // Add room chats to dropdown
                    chatroomDropdownMenu.innerHTML += `<h6>Room Inquiries:</h6>`;
                    roomChats.forEach(roomChat => {

                        const roomchatUrl = roomchatUrlTemplate
                        .replace(':id', roomChat.room_id)
                        .replace(':room_id', roomChat.roomchat_id);

                        const roomChatItem = document.createElement('a');
                        roomChatItem.classList.add('dropdown-item');
                        roomChatItem.href = roomchatUrl;
                        roomChatItem.textContent = `Chat in Room ${roomChat.room_number} (${roomChat.user_name})`;

                        const unreadCount = roomChat.unread_count;

                        if (unreadCount > 0) {
                            const messageCount = document.createElement('span');
                            messageCount.style.color = 'white';
                            messageCount.classList.add('badge', 'bg-danger', 'ms-2');
                            messageCount.textContent = ` (${unreadCount})`;
                            roomChatItem.appendChild(messageCount);
                            totalUnreadRoomInquiries++;
                        }

                        chatroomDropdownMenu.appendChild(roomChatItem);
                    });

                    // Calculate total unread count
                    const totalUnreadMessages = totalUnreadDormInquiries + totalUnreadRoomInquiries;

                    // Update the messageCount element with the total unread messages count
                    const messageCountElement = document.getElementById('messageCount');
                    messageCountElement.textContent = totalUnreadMessages;

                })
                .catch(error => console.error('Error fetching room chats:', error));
        })
        .catch(error => console.error('Error fetching chatrooms:', error));
}

function fetchNotifications() {

    const notifyUrl = window.routes.notificationUrl; // Get the notification URL

    fetch(notifyUrl)
        .then(response => response.json())
        .then(data => {
            const notificationMenu = document.getElementById('notificationsMenu');
            const notificationCount = document.getElementById('notificationCount');

            notificationMenu.innerHTML = '';
            notificationCount.textContent = data.unread_count;

            if (data.notifications.length > 0) {
                data.notifications.forEach(notification => {
                    const notificationItem = document.createElement('a');
                    notificationItem.classList.add('dropdown-item');
                    
                    // Set href based on room_id and notification type
                    if (notification.room_id) {
                        const roomEditUrlTemplate = window.routes.roomEditUrl; // Get the room edit URL template
                        notificationItem.href = roomEditUrlTemplate.replace(':room_id', notification.room_id); // Replace placeholder with room_id
                    } else {
                        notificationItem.href = window.routes.homeUrl; // Fallback URL
                    }

                    notificationItem.setAttribute('data-id', notification.id);

                    // Create a div for the message and sender
                    const textDiv = document.createElement('div');
                    const messageDiv = document.createElement('div');
                    messageDiv.style.display = 'flex';
                    messageDiv.style.justifyContent = 'space-between';

                    const maxLength = 50;
                    let truncatedMessage = notification.data;
                    if (truncatedMessage.length > maxLength) {
                        truncatedMessage = truncatedMessage.substring(0, maxLength) + '...';
                    }

                    const messageElement = document.createElement('h6');
                    messageElement.textContent = truncatedMessage;
                    messageElement.style.margin = 0;

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

                        // Replace placeholder with actual notification ID in markNotificationUrl
                        const markNotificationUrlTemplate = window.routes.markNotificationUrl;
                        const markNotificationUrl = markNotificationUrlTemplate.replace(':id', notification.id);
                        console.log(markNotificationUrl);
                        
                        if (notification.type === 'verification') {
                            const fullMessageDiv = document.createElement('div');
                            fullMessageDiv.textContent = notification.data;
                            fullMessageDiv.classList.add('full-notification');

                            document.body.appendChild(fullMessageDiv);

                            fullMessageDiv.addEventListener('click', function () {
                                fullMessageDiv.style.display = 'none';
                                markNotificationAsRead(markNotificationUrl, notificationItem.href,notification.id);
                            });
                        } else {
                            markNotificationAsRead(markNotificationUrl, notificationItem.href);
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

function markNotificationAsRead(markNotificationUrl, redirectUrl, notid) {
    fetch(markNotificationUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: notid })
    })
        .then(response => {
            if (response.ok) {
                window.location.href = redirectUrl;
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
}

document.addEventListener('DOMContentLoaded', function () {
    fetchNotifications();
    fetchConvo();
});


// Fetch data every 2 seconds
// setInterval(fetchNotifications, 2000);
// setInterval(fetchConvo, 2000);