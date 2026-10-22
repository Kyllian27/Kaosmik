<div class="row mb-3 align-items-center">
    <div class="col">
        <div>
            <h1 class="shadow text-white">On papote avec <?= $receiver->username; ?></h1>
            <span class="text-white">On reste cordial</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card" style="height: 75vh;">
            <div class="card-body scrollable">
                <div class="chat">
                    <div class="chat-bubbles">
                        <?php foreach($messages as $message): ?>
                            <?= view_cell('BubbleMessageCell', ['chatMessage' => $message, 'sender_context' => $message->id_sender == $logged_user->id]); ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <textarea id="content-message" class="form-control" rows="1" placeholder="Ecrivez votre message"></textarea>
                    </div>
                    <div class="col-auto">
                        <button id="send-message" class="btn btn-kaosmik" data-receiver="<?= $receiver->id; ?>">Envoyer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentMessage = document.getElementById('content-message');
        const sendButton = document.getElementById('send-message');
        const receiver = sendButton.getAttribute('data-receiver');
        const chatBubbles = document.querySelector('.chat-bubbles');
        const chatContainer = document.querySelector('.card-body.scrollable');

        let lastMessageDate = "<?= !empty($messages) ? end($messages)->created_at : date('Y-m-d H:i:s'); ?>";

        function scrollToBottom(smooth = true) {
            if(chatContainer) {
                chatContainer.scrollTo({
                    top: chatContainer.scrollHeight,
                    behavior: smooth ? 'smooth' : 'instant'
                });
            }
        }

        scrollToBottom(false);

        function sendMessage() {
            const textMessage = contentMessage.value.trim();
            if(!textMessage) return;

            sendButton.disabled = true;

            const formData = new FormData();
            formData.append('receiver_id', receiver);
            formData.append('message', textMessage);

            fetch('<?= base_url("/chat/send"); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (!response.ok) throw new Error('Erreur de réseau');
                return response.json();
            }).then(data => {
                if (data.success) {
                    chatBubbles.insertAdjacentHTML('beforeend', data.html);
                    contentMessage.value = '';
                    scrollToBottom();
                } else {
                    alert(data.error || 'Impossible d\'envoyer le message');
                }
            }).catch(error => {
                console.error('Erreur: ', error);
                alert('Une erreur est survenue lors de l\'envoi du message');
            }).finally( () => {
                sendButton.disabled = false;
            })
        }

        sendButton.addEventListener('click', sendMessage);

        contentMessage.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        function fetchNewMessages() {
            const url = `<?= base_url('/chat/new-messages');?>?receiver_id=${receiver}&last_date=${encodeURIComponent(lastMessageDate)}`;
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(res => res.json()
            ).then(data => {
                if(data.success && data.html !== '') {
                    chatBubbles.insertAdjacentHTML('beforeend', data.html);
                    lastMessageDate = data.latest_date;
                    scrollToBottom(true);
                }
            }).catch(err => console.error('Erreur de récupération des messages : ', err));
        }

        setInterval(fetchNewMessages, 1000);
    })
</script>