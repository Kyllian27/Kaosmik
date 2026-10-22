<div>
    <div class="row align-items-end <?= $sender_context ? 'justify-content-end':''; ?>">
        <div class="col col-md-6">
            <div class="chat-bubble <?= $sender_context ? 'chat-bubble-me':'';?>">
                <div class="chat-bubble-title">
                    <div class="d-flex justify-content-end">
                        <span class="chat-bubble-date">
                            <?= $chatMessage->created_at->format('H:i'); ?>
                        </span>
                    </div>
                </div>
                <div class="chat-bubble-body">
                    <p>
                        <?= esc($chatMessage->message); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>