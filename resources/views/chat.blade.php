<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial; max-width: 600px; margin: auto; }
        .msg { padding: 10px; margin: 5px; border-radius: 10px; }
        .user { background: #d1e7dd; text-align: right; }
        .bot { background: #f8d7da; }
    </style>
</head>
<body>

<div id="chat"></div>

<input id="input" placeholder="Напиши сообщение..." />
<button onclick="send()">Отправить</button>

<script>
    let chatId = null;

    function addMessage(text, role) {
        const div = document.createElement("div");
        div.className = "msg " + (role === "user" ? "user" : "bot");
        div.innerText = text;
        document.getElementById("chat").appendChild(div);
    }

    async function send() {
        const input = document.getElementById("input");
        const message = input.value;

        addMessage(message, "user");
        input.value = "";

        const res = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message: message,
                chat_id: chatId
            })
        });

        const data = await res.json();
        chatId = data.chat_id;

        addMessage(data.reply, "bot");
    }
</script>

</body>
</html>
