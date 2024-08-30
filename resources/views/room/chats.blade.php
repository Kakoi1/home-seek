<!-- resources/views/dorms/chat.blade.php -->

@extends('layouts.app')

@section('title', 'Chat with ' . $room->number)

@section('content')
<div class="chat-box">
    <h2>{{ $dorm->name }}</h2>
    <h2>Chat about {{ $room->number }}</h2>
    <div id="chat-messages" style="height: 300px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px;"></div>

    <textarea id="message-input" rows="3" placeholder="Type your message..."></textarea>
    <button id="send-button">Send</button>

    @if(auth()->id() === $dorm->user_id)
        <!-- Button to send the rent form URL -->
        <button id="send-url-button">Send Rent Form Link</button>
    @endif
</div>

<script>

    function markMessagesAsRead(roomId) {
        fetch('/mark-as-read', {
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
        const pathParts = window.location.pathname.split('/');
        const dormId = pathParts[2];
        const roomId = pathParts[4];

        const messagesContainer = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');
        const sendUrlButton = document.getElementById('send-url-button');

        function fetchMessages() {
            fetch(`/rooms/${dormId}/chat/${roomId}/fetch-messages`)
                .then(response => response.json())
                .then(messages => {
                    messagesContainer.innerHTML = '';
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        if (message.message.includes('http://') || message.message.includes('https://')) {
                            messageElement.innerHTML = `${message.user.name}: <a href="${message.message}" target="_blank">${message.message}</a>`;
                        } else {
                            messageElement.textContent = `${message.user.name}: ${message.message}`;
                        }
                        messagesContainer.appendChild(messageElement);
                    });
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        sendButton.addEventListener('click', function () {
            const message = messageInput.value;
            if (message.trim() === '') return;

            fetch(`/rooms/${dormId}/send-message/${roomId}`, {
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

        @if(auth()->id() === $dorm->user_id)
            sendUrlButton.addEventListener('click', function () {
                fetch(`/rooms/${roomId}/send-url/${dormId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'Link sent successfully') {
                            fetchMessages();
                            Swal.fire({
                                title: 'Success!',
                                text: data.status,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Handle other error cases
                            Swal.fire({
                                title: 'Error',
                                text: data.status,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error sending URL:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    })
                    .catch(error => console.error('Error sending URL:', error));

            });
        @endif
        fetchMessages();
        setInterval(fetchMessages, 2000);

        setInterval(function () {
            markMessagesAsRead(roomId);
        }, 2000);

    });

</script>
@endsection