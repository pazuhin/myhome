<a href="/" class="btn btn-info" role="button" style="margin-bottom: 20px;">На главную</a>
<?php if ($leads): ?>
    <div class="list-group">
        <?php foreach ($leads as $lead): ?>
            <a href="/lead/view?id=<?= $lead['id'] ?>" style="margin-bottom: 5px;"
               class="list-group-item list-group-item-action flex-column align-items-start active">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Заявка номер : <?= $lead['id']; ?></h5>
                    <h5 class="mb-1">Пользователь : <?= $lead['name']; ?></h5>
                    <small>
                        <?php $date = new DateTime($lead['created_at']);
                        echo $date->format('Y-m-d H:i:s'); ?>
                    </small>
                </div>
                <span class="lead-info d-flex">
                    <small><?= $lead['region_name'] . ' .'; ?></small>
                    <small><?= $lead['group_name'] . ' .'; ?></small>
                    <small><?= $lead['type_name']; ?></small>
                </span>
                <p class="mb-1"><?= $lead['message']; ?></p>
                <small>Статус: <?= $lead['status']; ?></small>
            </a>
        <?php endforeach; ?>
        <?php echo $pagination; ?>
    </div>
<? else: ?>
<?php echo 'Нет созданных заявок';?>
<?php endif;?>
