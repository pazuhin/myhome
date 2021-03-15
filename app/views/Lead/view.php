<div class="d-flex w-100 justify-content-between" style="flex-direction: column">
    <h5 class="mb-1">Заявка номер : <?=$leadInfo['id'];?></h5>
    <h5 class="mb-1">Пользователь : <?=$leadInfo['name'];?></h5>
    <small>
        <?php $date = new DateTime($leadInfo['created_at']); echo $date->format('Y-m-d H:i:s');?>
    </small>
    <?php if($_SESSION['user']['role'] === 'admin'):?>
    <form>
        <label for="statusSelect">Статус</label>
        <div class="container" style="display:flex;">
            <div class="form-group-status">
                <select class="form-control" id="statusSelect">
                    <option selected value="<?=array_search($statuses[$leadInfo['status']],$statuses)?>"><?=$statuses[$leadInfo['status']] ?></option>
                    <?php foreach ($statuses as $key => $status):?>
                        <?php if($key != $leadInfo['status']):?>
                            <option name="status" value="<?=$key?>"><?= $status ?></option>
                        <?php endif;?>
                    <?php endforeach;?>
                </select>
            </div>
            <a style="margin-left: 20px;" id="btnStatus" class="btn btn-default" data-id="<?=$leadInfo['id']; ?>">Сменить</a>
        </div>
    </form>
    <?php else:?>
        <small style="display:flex;">Статус :<?= $statuses[$leadInfo['status']]; ?></small>
    <?php endif;?>
</div>
<span class="lead-info d-flex">
                <small><?= $leadInfo['region_name'] . ' .'; ?></small>
                <small><?= $leadInfo['group_name']. ' .'; ?></small>
                <small><?= $leadInfo['type_name']; ?></small>
            </span>
<p class="mb-1">Сообщение: <?= $leadInfo['message']; ?></p>

<a href="<?=($_SESSION['user']['role'] === 'admin') ? '/admin' : '/lead/list';?>" class="btn btn-info" role="button">Вернуться к списку</a>