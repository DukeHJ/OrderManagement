<?php
require_once 'include.php';
?>
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title>华铸ERP信息管理 | 登录</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link href="vendor/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet"/>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="vendor/css/animate.min.css" rel="stylesheet"/>
    <link href="vendor/css/style.min.css" rel="stylesheet"/>
    <link href="vendor/css/style-responsive.min.css" rel="stylesheet"/>
    <link href="vendor/css/theme/default.css" rel="stylesheet" id="theme"/>
    <link href="vendor/bootstrap-validator/css/bootstrapValidator.min.css" rel="stylesheet"/>

    <script src="vendor/pace/pace.min.js"></script>
    <style type="text/css">
        .help-block,
        .input-lg {
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php include_once 'template/pageloader.php';?>

<div class="login-cover">
    <div class="login-cover-image"><img src="assets/img/login-bg/bg-1.jpg" data-id="login-cover-image" alt=""/></div>
    <div class="login-cover-bg"></div>
</div>

<div id="page-container" class="fade">
    <div class="login login-v2" data-pageload-addclass="animated flipInX">
        <div class="login-header">
            <div class="brand">
                华铸ERP订单管理系统
            </div>
            <div class="icon">
                <i class="fa fa-sign-in"></i>
            </div>
        </div>

        <div class="login-content">
            <form id="loginForm" class="margin-bottom-0 form-horizontal">
                <fieldset>
                    <div class="form-group m-b-20">
                        <div>
                            <input type="text" class="form-control input-lg" name="username" id="username"
                                   placeholder="用户名称"/>
                        </div>
                    </div>
                    <div class="form-group m-b-20">
                        <div>
                            <input type="password" class="form-control input-lg" name="password" id="password"
                                   placeholder="用户密码"/>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group  login-buttons">
                    <button type="submit" class="btn btn-success btn-block btn-lg">登陆</button>
                </div>
            </form>
        </div>
    </div>

    <ul class="login-bg-list">
        <li class="active"><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-1.jpg" alt=""/></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-2.jpg" alt=""/></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-3.jpg" alt=""/></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-4.jpg" alt=""/></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-5.jpg" alt=""/></a></li>
        <li><a href="#" data-click="change-bg"><img src="assets/img/login-bg/bg-6.jpg" alt=""/></a></li>
    </ul>

</div>

<script src="vendor/jquery/jquery-1.9.1.min.js"></script>
<script src="vendor/jquery/jquery-migrate-1.1.0.min.js"></script>
<script src="vendor/jquery-ui/ui/minified/jquery-ui.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--[if lt IE 9]>
<script src="vendor/crossbrowserjs/html5shiv.js"></script>
<script src="vendor/crossbrowserjs/respond.min.js"></script>
<script src="vendor/crossbrowserjs/excanvas.min.js"></script>
<script type="text/javascript" src="vendor/jquery-placeholder/jquery.placeholder.js"></script>
<script type="text/javascript">
    $(function () {
        $('input, textarea').placeholder();
    });
</script>
<![endif]-->
<script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/js/apps.min.js"></script>

<script src="vendor/js/login-v2.demo.min.js"></script>
<script src="vendor/bootstrap-validator/js/bootstrapValidator.min.js"></script>
<script src="js/alert_rewrite.js"></script>
<script>
    $(document).ready(function () {
        App.init();
        LoginV2.init();
    });
</script>

<script>
    $(document).ready(function () {
        $('#loginForm').bootstrapValidator({
            message: '不能为空',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {
                    validators: {
                        message: '不能为空',
                        notEmpty: {
                            message: '用户名不能为空'
                        },
                        /*stringLength: {
                         min: 2,
                         max: 10,
                         message: '用户名长度必须在2到10个字符之间'
                         },*/
                        regexp: {
                            regexp: /^[\u4e00-\u9fa5_a-zA-Z0-9]+$/,
                            message: '用户名只能由汉字、字母及数字组成'
                        }
                    }
                },
                password: {
                    message: '不能为空',
                    validators: {
                        notEmpty: {
                            message: '登陆密码不能为空'
                        },
                        /*stringLength: {
                         min: 3,
                         max: 10,
                         message: '登陆密码长度必须在3到10之间'
                         },*/
                        different: {
                            field: 'username',
                            message: '登陆密码不能和用户名相同'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: '登陆密码只能由字母、数字组成'
                        }
                    }
                }/*,
                 verify: {
                 validators: {
                 notEmpty: {
                 message: '验证码不能为空'
                 },

                 regexp: {
                 regexp: /^[a-zA-Z0-9]+$/,
                 message: '验证码只能由字母、数字组成'
                 },

                 remote: {
                 type: "GET",
                 url: 'doAction.php?act=checkVerify',
                 dataType: "json",
                 data: {verify: $("#verify").val()},
                 message: "验证码不正确",
                 delay: 500
                 }
                 }
                 }*/
            }
        })
            .on('success.form.bv', function (e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');
                $.post($form.attr('action'), $form.serialize(), function () {
                    $.ajax({
                        type: "GET",
                        url: "doAction.php?act=login",
                        data: {
                            username: $("#username").val(),
                            password: $("#password").val()
                        },
                        contentType: "application/json;charset=utf-8",
                        async: true,
                        success: function (data) {
                            if (data != 0 && data != 1) {
                                Modal.alert({msg: data, title: '标题', btnok: '确定', btncl: '取消'});
                            }
                            if (data == 0) {
                                Modal.alert({msg: '登录名或密码错误，请重新输入！', title: '标题', btnok: '确定', btncl: '取消'});
                            }
                            if (data == 1) {
                                window.location.href = 'index.php';
                            }
                        },
                        error: function (jqXHR) {
                            alert("发生错误" + jqXHR.status);
                        }
                    });
                });
            });
    });
</script>

</body>
</html>
