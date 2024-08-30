document.addEventListener('DOMContentLoaded', function () {
    const chatBox = document.getElementById('chat-box');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const dormId = {{ $dorm->id }};
    const userId = {{ Auth::id() }};

    function fetchMessages() {
        fetch(`/chat/messages/${dormId}`)
            .then(response => response.json())
            .then(messages => {
                chatMessages.innerHTML = '';
                messages.forEach(message => {
                    appendMessage(message);
                });
            });
    }

    function sendMessage() {
        const message = chatInput.value;

        fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                dorm_id: dormId,
                message: message
            })
        })
        .then(response => response.json())
        .then(data => {
            chatInput.value = '';
        });
    }

    function appendMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.textContent = `${message.user.name}: ${message.message}`;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Pusher setup
    Pusher.logToConsole = true;

    var pusher = new Pusher('your-pusher-key', {
        cluster: 'your-pusher-cluster',
        encrypted: true
    });

    var channel = pusher.subscribe(`private-chat.${dormId}`);
    channel.bind('App\\Events\\MessageSent', function (data) {
        appendMessage(data.message);
    });

    fetchMessages();
    window.sendMessage = sendMessage;
});
