<div class="modal fade" id="leadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Заявка</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="lead/create" id="leadForm">
                    <div class="form-group">
                        <label class="control-label">Выбор региона</label>
                        <select class="form-control" id="regions">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Выбор группы</label>
                        <select class="form-control" id="groups">
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Выбор типа</label>
                        <select class="form-control" id="types">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Сообщение</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="leadCreate">Создать</button>
            </div>
        </div>
    </div>
</div>
<?php if ($_SESSION['user']):?>
    <button id="createBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#leadModal">Создать заявку</button>
<?php endif;?>
<a href="/lead/list" class="btn btn-info" role="button">Перейти к списку</a>

<script>

</script>