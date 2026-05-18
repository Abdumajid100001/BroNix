@include('public.partials.header')

<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
        background: #f8f9fa;
    }

    .chat-main {
        flex: 1;
        overflow-y: auto;
        padding: 2rem;
        display: flex;
        flex-direction: column;
    }

    .chat-messages {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        max-width: 900px;
        margin: 0 auto;
        width: 100%;
    }

    .message {
        display: flex;
        gap: 1rem;
        animation: slideIn 0.3s ease;
    }

    .message.user {
        justify-content: flex-end;
    }

    .message.assistant {
        justify-content: flex-start;
    }

    .message-content {
        padding: 1rem 1.3rem;
        border-radius: 16px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .message.user .message-content {
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message.assistant .message-content {
        background: white;
        color: #333;
        border: 1px solid #e0e0e0;
        border-bottom-left-radius: 4px;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-input-section {
        padding: 2rem;
        background: white;
        border-top: 1px solid #e0e0e0;
    }

    .chat-input-container {
        display: flex;
        gap: 1rem;
        max-width: 900px;
        margin: 0 auto;
        width: 100%;
    }

    .chat-input {
        flex: 1;
        padding: 0.9rem 1.3rem;
        border: 2px solid #e0e0e0;
        border-radius: 24px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease;
    }

    .chat-input:focus {
        outline: none;
        border-color: #4f46e5;
    }

    .chat-send-btn {
        padding: 0.9rem 1.8rem;
        background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
        color: white;
        border: none;
        border-radius: 24px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .chat-send-btn:hover {
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
    }

    .business-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1rem;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
    }

    .business-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .business-card-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.8rem;
    }

    .business-card-title {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1a1a1a;
    }

    .business-rating {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        color: #ff9800;
        font-weight: 600;
    }

    .business-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8rem;
        font-size: 0.9rem;
        color: #666;
    }

    .business-action {
        margin-top: 1rem;
    }

    .btn-book {
        width: 100%;
        padding: 0.7rem;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
        text-align: center;
    }

    .btn-book:hover {
        background: #3b82f6;
        text-decoration: none;
        color: white;
    }

    .chat-welcome {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        text-align: center;
    }

    .welcome-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #1a1a1a;
    }

    .welcome-subtitle {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 2rem;
    }

    .quick-prompts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        width: 100%;
        max-width: 600px;
    }

    .quick-prompt-btn {
        padding: 1rem 1.3rem;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: left;
        font-size: 0.95rem;
    }

    .quick-prompt-btn:hover {
        border-color: #4f46e5;
        background: #f8f9ff;
    }

    .loading {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #999;
    }

    .typing-indicator {
        display: flex;
        gap: 0.3rem;
    }

    .dot {
        width: 8px;
        height: 8px;
        background: #999;
        border-radius: 50%;
        animation: bounce 1.4s infinite;
    }

    .dot:nth-child(2) { animation-delay: 0.2s; }
    .dot:nth-child(3) { animation-delay: 0.4s; }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (max-width: 768px) {
        .message-content {
            max-width: 90%;
        }

        .chat-main {
            padding: 1rem;
        }

        .chat-messages {
            max-width: 100%;
        }
    }
</style>

<main class="main">
    <section class="chat-container">
        <div class="chat-main">
            <div class="chat-messages" id="chatMessages">
                <div class="chat-welcome">
                    <div class="welcome-title">👋 Добро пожаловать в AI Ассистент</div>
                    <div class="welcome-subtitle">Я помогу вам найти лучший бизнес для бронирования</div>
                    <div class="quick-prompts">
                        <button class="quick-prompt-btn" onclick="sendQuickMessage('Найди барбершоп с бюджетом до 150000 сум')">
                            <i class="fas fa-scissors" style="color: #4f46e5; margin-right: 0.5rem;"></i>
                            💈 Дешевый барбершоп
                        </button>
                        <button class="quick-prompt-btn" onclick="sendQuickMessage('Покажи популярные салоны красоты')">
                            <i class="fas fa-sparkles" style="color: #4f46e5; margin-right: 0.5rem;"></i>
                            ✨ Популярные салоны
                        </button>
                        <button class="quick-prompt-btn" onclick="sendQuickMessage('Найди хороший фитнес центр с удобным графиком')">
                            <i class="fas fa-dumbbell" style="color: #4f46e5; margin-right: 0.5rem;"></i>
                            💪 Фитнес клуб
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="chat-input-section">
            <div class="chat-input-container">
                <input
                    type="text"
                    class="chat-input"
                    id="messageInput"
                    placeholder="Опишите, что вы ищете..."
                    onkeypress="if(event.key==='Enter') sendMessage()"
                >
                <button class="chat-send-btn" onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </section>
</main>

<script>
    let messageHistory = [];

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();

        if (!message) return;

        // Добавить сообщение пользователя в UI
        addMessage(message, 'user');
        input.value = '';

        // Показать индикатор печатания
        showTypingIndicator();

        // Отправить на сервер
        fetch('{{ route("assistant.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({
                message: message,
                history: messageHistory,
            }),
        })
        .then(response => response.json())
        .then(data => {
            removeTypingIndicator();

            // Добавить ответ ассистента
            addMessage(data.message, 'assistant');

            // Если есть результаты, показать карточки бизнесов
            if (data.businesses && data.businesses.length > 0) {
                data.businesses.forEach(business => {
                    addBusinessCard(business);
                });
            }

            // Сохранить в историю
            messageHistory.push(
                { role: 'user', content: message },
                { role: 'assistant', content: data.message }
            );
        })
        .catch(error => {
            removeTypingIndicator();
            console.error('Error:', error);
            addMessage('Произошла ошибка. Попробуйте еще раз.', 'assistant');
        });
    }

    function sendQuickMessage(message) {
        document.getElementById('messageInput').value = message;
        sendMessage();
    }

    function addMessage(content, role) {
        const messagesDiv = document.getElementById('chatMessages');

        // Очистить приветствие при первом сообщении
        if (messagesDiv.querySelector('.chat-welcome')) {
            messagesDiv.innerHTML = '';
        }

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${role}`;

        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.innerHTML = content.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                                      .replace(/\n/g, '<br>');

        messageDiv.appendChild(contentDiv);
        messagesDiv.appendChild(messageDiv);

        // Автоскролл вниз
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function addBusinessCard(business) {
        const messagesDiv = document.getElementById('chatMessages');

        const cardDiv = document.createElement('div');
        cardDiv.className = 'business-card';
        cardDiv.innerHTML = `
            <div class="business-card-header">
                <div class="business-card-title">${business.name}</div>
                <div class="business-rating">⭐ ${business.rating}</div>
            </div>
            <div class="business-meta">
                <div>📍 ${business.address || 'Адрес не указан'}</div>
                <div>💰 от ${business.min_price ? new Intl.NumberFormat('ru-RU').format(business.min_price) + ' UZS' : 'по запросу'}</div>
                <div>📊 ${business.bookings_count} бронирований</div>
                <div>🔧 ${business.services_count} услуг</div>
            </div>
            <div class="business-action">
                <a href="{{ route('booking.page') }}?business=${business.id}" class="btn-book">
                    <i class="fas fa-check"></i> Забронировать
                </a>
            </div>
        `;

        messagesDiv.appendChild(cardDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function showTypingIndicator() {
        const messagesDiv = document.getElementById('chatMessages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message assistant';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="message-content" style="padding: 1rem 1.3rem;">
                <div class="typing-indicator">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        `;
        messagesDiv.appendChild(typingDiv);
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }
</script>

@include('public.partials.footer')
