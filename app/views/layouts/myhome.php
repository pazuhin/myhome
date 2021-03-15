<!DOCTYPE html>
<html>
<head>
    <base href="/">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
<body>
<div class="top-header">
    <div class="container">
        <div class="top-header-main">
            <div class="col-md-6 top-header-left">
                <div class="drop">
                    <div class="btn-group">
                        <a class="dropdown-toggle" data-toggle="dropdown">Account <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php if (!empty($_SESSION['user'])):?>
                                <li>Добро пожаловать, <?=$_SESSION['user']['name']?></li>
                                <li><a href="user/logout">Выйти</a></li>
                            <?php else:?>
                                <li><a href="user/login">Войти</a></li>
                                <li><a href="user/signup">Регистрация</a></li>
                            <?php endif;?>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if (isset($_SESSION['errors']) || isset($_SESSION['error'])):?>
                    <div class="alert alert-danger">
                        <?=$_SESSION['errors']; unset($_SESSION['errors']); unset($_SESSION['error']);?>
                    </div>
                <?php elseif (isset($_SESSION['success'])):?>
                    <div class="alert alert-success">
                        <?=$_SESSION['success']; unset($_SESSION['success'])?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <?=$content;?>
</div>

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/validator.js"></script>
<script src="js/main.js"></script>
</body>
</html>