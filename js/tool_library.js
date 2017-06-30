/*$(".ddxzh").click(function () {

 $.ajax({
 type: "GET",
 url: "doAction.php",
 data:{act:'track_single_pro',ddxzh:$(this).html()},
 success: function (data) {
 $("#tmp").html(data);
 Modal.alert({
 msg: $("#tmp").html(),
 title: '标题',
 btnok: '确定',
 btncl:'取消'
 });
 },
 error: function (jqXHR) {
 alert("发生错误：" + jqXHR.status);
 }
 });
 });*/

$(document).ready(function () {
    $(document).on("click", ".ddxzh", function () {
        $(this).parents(".info_div").children(".tool_div").toggle();
    });
    $(document).on("click", ".ddbh", function () {
        $(this).parents(".info_div").children(".tool_div2").toggle();
    });
    $(".info_div").click(function () {
        $(this).children(".tool_div").css("display", "none");
        $(this).children(".tool_div2").css("display", "none");
    });
});

$(document).ready(function () {
    $(".track_single_pro").click(function () {
        $.ajax({
            type: "GET",
            url: "doAction.php",
            data: {act: 'track_single_pro', ddxzh: $(this).parents(".info_div").children(".ddxzh").html()},
            success: function (data) {
                $("#tmp").html(data);
                Modal.alert({
                    msg: $("#tmp").html(),
                    title: '跟踪单件过程',
                    btnok: '确定',
                    btncl: '取消'
                });
            },
            error: function (jqXHR) {
                alert("发生错误：" + jqXHR.status);
            }
        });
    });
});

$(document).ready(function () {
    $(".track_xz_overview").click(function () {
        $.ajax({
            type: "GET",
            url: "doAction.php",
            data: {act: 'track_xz_overview', ddxzh: $(this).parents(".info_div").children(".ddxzh").html()},
            success: function (data) {
                $("#tmp").html(data);
                Modal.alert({
                    msg: $("#tmp").html(),
                    title: '跟踪细则一览',
                    btnok: '确定',
                    btncl: '取消'
                });
            },
            error: function (jqXHR) {
                alert("发生错误：" + jqXHR.status);
            }
        });
    });
});

$(document).ready(function () {
    $(".track_xz_pro_r").click(function () {
        $.ajax({
            type: "GET",
            url: "doAction.php",
            data: {act: 'track_xz_pro_r', ddbh: $(this).parents(".info_div").children(".ddbh").html()},
            success: function (data) {
                $("#tmp").html(data);
                Modal.alert({
                    msg: $("#tmp").html(),
                    title: '跟踪细则进度比',
                    btnok: '确定',
                    btncl: '取消'
                });
            },
            error: function (jqXHR) {
                alert("发生错误：" + jqXHR.status);
            }
        });
    });
});


$(document).ready(function () {
    $(".track_xz_pro").click(function () {
        $.ajax({
            type: "GET",
            url: "doAction.php",
            data: {act: 'track_xz_pro',ddbh: $(this).parents(".info_div").children(".ddbh").html()},
            success: function (data) {
                $("#tmp").html(data);
                Modal.alert({
                    msg: $("#tmp").html(),
                    title: '跟踪细则进度',
                    btnok: '确定',
                    btncl: '取消'
                });
            },
            error: function (jqXHR) {
                alert("发生错误：" + jqXHR.status);
            }
        });
    });
});