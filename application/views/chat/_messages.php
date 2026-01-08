<?php if (!empty($messages)): ?>
  <?php foreach($messages as $m): ?>
    <div class="d-flex mb-2 <?= !empty($m['is_me']) ? 'justify-content-end' : 'justify-content-start' ?>">
      <div class="p-2 rounded"
           style="max-width:75%;
                  background:<?= !empty($m['is_me']) ? '#dcf8c6' : '#f1f1f1' ?>;">
        <div><?= nl2br(htmlspecialchars($m['message'])) ?></div>
        <div class="small text-muted text-end">
          <?= date('h:i A', strtotime($m['created_at'])) ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
