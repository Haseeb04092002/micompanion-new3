<?php if (!empty($messages)): ?>
  <?php foreach ($messages as $m): ?>

    <?php if ($m['is_me']): ?>
      <!-- OUTGOING -->
      <div class="d-flex justify-content-end mb-2">
        <div class="chat-bubble chat-outgoing">
          <div><?= nl2br(htmlspecialchars($m['message'])) ?></div>
          <div class="chat-time">
            <?= date('h:i A', strtotime($m['created_at'])) ?>
          </div>
        </div>
      </div>
    <?php else: ?>
      <!-- INCOMING -->
      <div class="d-flex justify-content-start mb-2">
        <div class="chat-bubble chat-incoming">
          <div><?= nl2br(htmlspecialchars($m['message'])) ?></div>
          <div class="chat-time text-end">
            <?= date('h:i A', strtotime($m['created_at'])) ?>
          </div>
        </div>
      </div>
    <?php endif; ?>

  <?php endforeach; ?>
<?php endif; ?>