<!-- resources/views/dorms/chat.blade.php -->

@extends('layouts.app')

@section('title', 'Chat with ' . $dorm->name)

@section('content')

<style>
    .chat-box {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        background-color: #f1f1f1;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
        display: flex;
        flex-direction: column;
        height: 400px;
    }

    .chat-box h2 {
        text-align: center;
        font-size: 1.5rem;
        color: #007bff;
        margin-bottom: 15px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: scroll;
        padding: 10px;
        background-color: white;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .message-input-container {
        display: flex;
        padding-top: 10px;
        border-top: 1px solid #ddd;
        background-color: white;
    }

    #message-input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 10px;
        font-size: 1rem;
        margin-right: 10px;
        resize: none;
    }

    #send-button {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 0 15px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #send-button:hover {
        background-color: #0056b3;
    }

    /* Styling for chat bubbles */
    .chat-bubble {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 20px;
        margin: 5px 0;
        font-size: 0.9rem;
        position: relative;
        word-wrap: break-word;
    }

    .chat-bubble.sent {
        background-color: #007bff;
        color: white;
        margin-left: auto;
        text-align: right;
    }

    .chat-bubble.received {
        background-color: #e9ecef;
        color: #333;
        margin-right: auto;
        text-align: left;
    }

    /* Timestamps */
    .chat-time {
        font-size: 0.75rem;
        color: #999;
        margin-top: 5px;
    }

    /* Scroll to the bottom when new messages appear */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background-color: #007bff;
        border-radius: 10px;
    }
</style>

<div class="chat-box">
    <h2>Chat about {{ $dorm->name }}</h2>
    <div id="chat-messages" class="chat-messages"></div>
    <div class="message-input-container">
        <textarea id="message-input" rows="3" placeholder="Type your message..."></textarea>
        <button id="send-button">Send</button>
    </div>
</div>

<script>
    window.route = {
        fetchMessagesUrl: '{{ route("FetchDormMessage", ["dormId" => ":dormId", "roomId" => ":roomId"]) }}',
        sendMessageUrl: '{{ route("DormSendMessage", ["dormId" => ":dormId", "roomId" => ":roomId"]) }}',
        markMessagesReadUrl: '{{ route("message.read") }}',
    };
</script>

<script>
    const markMessagesReadUrl = window.route.markMessagesReadUrl;
    function markMessagesAsRead(roomId) {
        fetch(markMessagesReadUrl, {
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

        // Declare variables outside the conditional blocks
        let dormId, roomId;

        if (isNaN(parseInt(pathParts[2], 10)) || isNaN(parseInt(pathParts[4], 10))) {
            dormId = pathParts[4]; // Extract dormId from the URL
            roomId = pathParts[6];
        } else {
            dormId = pathParts[2]; // Extract dormId from the URL
            roomId = pathParts[4];
        }


        // Replace placeholders in the URLs
        const fetchMessagesUrl = window.route.fetchMessagesUrl.replace(':dormId', dormId).replace(':roomId', roomId);
        const sendMessageUrl = window.route.sendMessageUrl.replace(':dormId', dormId).replace(':roomId', roomId);
        console.log(fetchMessagesUrl);


        markMessagesAsRead(roomId);
        fetchMessages()
        const messagesContainer = document.getElementById('chat-messages');
        const messageInput = document.getElementById('message-input');
        const sendButton = document.getElementById('send-button');

        function fetchMessages() {
            fetch(fetchMessagesUrl)
                .then(response => response.json())
                .then(messages => {
                    messagesContainer.innerHTML = '';
                    messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        const isSentByUser = message.user.id === userId;

                        messageElement.classList.add('chat-bubble');
                        messageElement.classList.add(isSentByUser ? 'sent' : 'received');
                        messageElement.textContent = isSentByUser ? ` ${message.message} : ${message.user.name}` : `${message.user.name}: ${message.message}`;

                        // Add timestamp
                        const messageTime = document.createElement('div');
                        messageTime.classList.add('chat-time');
                        const messageDate = new Date(message.created_at);
                        messageTime.textContent = messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        messageElement.appendChild(messageTime);
                        messagesContainer.appendChild(messageElement);
                    });
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                })
                .catch(error => console.error('Error fetching messages:', error));
        }

        sendButton.addEventListener('click', function () {
            const message = messageInput.value;
            if (message.trim() === '') return;

            fetch(sendMessageUrl, {
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

        var channel2 = pusher.subscribe('message.' + userId);

        channel2.bind('test.message', function (data) {
            if (data) {
                fetchMessages();
                markMessagesAsRead(roomId);
            }
        });
    });


</script>
@endsection