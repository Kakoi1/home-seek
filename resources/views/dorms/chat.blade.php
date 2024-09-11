<!-- resources/views/dorms/chat.blade.php -->

@extends('layouts.app')

@section('title', 'Chat with ' . $dorm->name)

@section('content')
<div class="chat-box">
    <h2>Chat about {{ $dorm->name }}</h2>
    <div id="chat-messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;"></div>
    <textarea id="message-input" rows="3" placeholder="Type your message..."></textarea>
    <button id="send-button">Send</button>
</div>
<script>

    function markMessagesAsRead(roomId) {
        fetch('/mark-messages-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ roomId: roomId })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Messages marked as read');
                    // Update the unread count in the navbar
                }
            })
            .catch(error => console.error('Error marking messages as read:', error));
    }


    document.addEventListener('DOMContentLoaded', function () {
        // Extract dormId and roomId from the URL path
        const pathParts = window.location.pathname.split('/');
        const dormId = pathParts[2]; // Assuming the URL format is /dorms/{dormId}/chat/{roomId}
        const roomId = pathParts[4]; // The roomId is the last part of the URL
        markMessagesAsRead(roomId)
        if (!dormId || !roomId) {
            console.error('Dorm ID or Room ID is missing in the URL.');
            return;
        }
        const messagesContainer = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');

        function fetchMessages() {
            fetch(`/dorms/${dormId}/chat/${roomId}/fetch-messages`)
                .then(response => response.json())
                .then(messages => {
                    console.log('Retrieved messages:', messages); // Log the retrieved messages

                    messagesContainer.innerHTML = '';
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.textContent = `${message.user.name}: ${message.message}`;
                        messagesContainer.appendChild(messageElement);
                    });
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(error => console.error('Error fetching messages:', error));
        }



        sendButton.addEventListener('click', function () {
            const message = messageInput.value;
            if (message.trim() === '') return;

            fetch(`/dorms/${dormId}/send-message/${roomId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'Message sent successfully') {
                        messageInput.value = '';
                        fetchMessages();
                    }
                })
                .catch(error => console.error('Error sending message:', error));
        });

        // Fetch messages initially
        var channel2 = pusher.subscribe('message.' + userId);

        channel2.bind('test.message', function (data) {

            if (data) {
                fetchMessages();
                markMessagesAsRead(roomId)
                fetchConvo();
            }
        });

    });



</script>
@endsection