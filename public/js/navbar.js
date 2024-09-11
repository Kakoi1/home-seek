function fetchConvo() {
    // Fetch chatrooms
    fetch('/chatrooms')
        .then(response => response.json())
        .then(chatrooms => {
            console.log('Fetched chatrooms:', chatrooms); // Log the chatrooms data
            
            // Initialize unread message counters
            let totalUnreadDormInquiries = 0;
            let totalUnreadRoomInquiries = 0;

            // Fetch room chats
            fetch('/room-chats')
                .then(response => response.json())
                .then(roomChats => {
                    console.log('Fetched room chats:', roomChats); // Log the room chats data
                    
                    const chatroomDropdownMenu = document.getElementById('chatroomDropdownMenu');
                    chatroomDropdownMenu.innerHTML = '';
                    
                    // Add chatrooms to dropdown
                    chatroomDropdownMenu.innerHTML += `<h6>Dorm Inquiries:</h6>`;
                    chatrooms.chat.forEach(chatroom => {
                        const unreadCount = chatroom.unread_count;

                        const chatroomItem = document.createElement('a');
                        chatroomItem.classList.add('dropdown-item');
                        chatroomItem.href = `/dorms/${chatroom.dorm_id}/chat/${chatroom.chatroom_id}`;
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
                        const roomChatItem = document.createElement('a');
                        roomChatItem.classList.add('dropdown-item');
                        roomChatItem.href = `/rooms/${roomChat.room_id}/chat/${roomChat.roomchat_id}`;
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
    fetch('/notifications')
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
                    notificationItem.href = `/room/${notification.room_id}/edit/view`; // Redirect to the room page
                    notificationItem.setAttribute('data-id', notification.id); // Set the notification ID

                    // Create a div for the message and sender
                    const textDiv = document.createElement('div');

                    const messageDiv = document.createElement('div');
                    messageDiv.style.display = 'flex'; // Use flexbox to align items
                    messageDiv.style.justifyContent = 'space-between';

                    const messageElement = document.createElement('h6');
                    messageElement.textContent = notification.data; // Assuming `notification.data` contains the message
                    messageElement.style.margin = 0;

                    const senderElement = document.createElement('p');
                    senderElement.textContent = `Sent by: ${notification.sender.name}`; // Assuming `notification.sender.name` is correct
                    senderElement.style.margin = 0;
                    senderElement.style.fontSize = 'smaller';

                    const createdAt = new Date(notification.created_at); // Parse the date string
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
                    timestampElement.style.marginLeft = 'auto'; // Push timestamp to the right
                    timestampElement.style.fontSize = 'smaller';
                    timestampElement.style.color = '#888';

                    // If the notification is unread, apply bold style to both message and sender elements
                    if (!notification.read) {
                        messageElement.style.fontWeight = 'bold';
                        senderElement.style.fontWeight = 'bold';
                        timestampElement.style.fontWeight = 'bold';
                    }

                    textDiv.appendChild(messageElement);
                    textDiv.appendChild(senderElement);
                    messageDiv.appendChild(textDiv); // Append text div to message div
                    messageDiv.appendChild(timestampElement);
                    notificationItem.appendChild(messageDiv);

                    notificationItem.addEventListener('click', function (e) {
                        e.preventDefault();
                        markNotificationAsRead(notification.id, notificationItem.href);
                    });

                    notificationMenu.appendChild(notificationItem);
                });
            } else {
                notificationMenu.innerHTML = '<span class="dropdown-item">No new notifications</span>';
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
}


function markNotificationAsRead(notificationId, redirectUrl) {
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: notificationId })
    })
        .then(response => {
            if (response.ok) {
                window.location.href = redirectUrl; // Redirect after marking as read
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