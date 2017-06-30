/*
 一、字符串函数
 1.不为空约束带提醒:  cons_notnull(notnull)
 2.是否为空判断：isnotnull(notnull),isnull(notnull)
 3.字符串检测函数：myin(word,string), mynotin(word,string)
 4.去掉字符串前后空格：mytrim(str)
 二、数据库取值函数
 1.sql数据库中的某一列： gf_execsql(mysql)
 三、其他函数
 1.其他约束逻辑判断带提醒：cons_others(check,warming)
 2.enter键转化tab键函数： $target.bind('keydown', function (e)
 3.浏览器类型判断：myBrowser()

 */

/*cons_notnull(notnull)不为空逻辑判断+alert+获取焦点*/
function cons_notnull(notnull) {
    var myarr = new Array();
    myarr = notnull.split(",");
    for (var i in myarr) {
        var getval = document.getElementById(myarr[i]).value;
        if (getval == '') {
            Modal.alert(
                {
                    msg: myarr[i] + '不能为空！',
                    title: '标题',
                    btnok: '确定',
                    btncl: '取消'
                });
            document.getElementById(myarr[i]).focus();
            return false;
        }
    }
    return true;
}

/*isnotnull(notnull)不为空*/
function isnotnull(notnull) {
    var getval = document.getElementById(notnull).value;
    if (getval == '')  return false;
    else  return true;
}
//isnull(notnull)为空
function isnull(notnull) {
    var getval = document.getElementById(notnull).value;
    if (getval == '')  return true;
    else  return false;
}
//myin(word, string)myin字符串存在检测in
function myin(word, string) {
    var myarr = new Array();
    myarr = string.split(",");
    for (var i in myarr) {//if (trim(myarr[i])==trim(word))
        if (mytrim(myarr[i]) == mytrim(word))
            return true;
    }
    return false;
}
//mynotin(word, string)字符串不存在检测notin
function mynotin(word, string) {
    var myarr = new Array();
    myarr = string.split(",");
    for (var i in myarr) {
        if (mytrim(myarr[i]) == mytrim(word)) return false;
    }
    return true;
}
//cons_others(check, warming)其他约束：逻辑 + 错误提醒
function cons_others(check, warming) {
    if (check) return true;
    else {
        alert(warming);
        return false;
    }
}
//mytrim(str)去掉字符串前后空格
function mytrim(str) {

    return str.replace(/(^\s*)|(\s*$)/g, "");

}
//n位流水号，s不足10 ^ n补0
function formatDigits(s, n) {
    if (s < Math.pow(10, n)) {
        var sdigit = Math.floor(Math.log(s) / Math.log(10))
        for (var i = 1; i < n - sdigit; i++) {
            s = "0" + s;
        }
        return s;
    }
    else return s;
}

//gf_execsql(mysql)sql语句获取sql字符串
function gf_execsql(mysql) {

    var result = "";
    $.ajax({
        type: "get",
        url: "execsql.php",
        data: {sql: mysql, nocache: new Date().getTime()},
        contentType: "application/json;charset=utf-8",
        async: false,//同步
        success: function (data) {
            result = data;
        }, failure: function () {
            alert("请求失败");
        }
    });
    return result.replace(/(^\s*)|(\s*$)/g, "");
    // alert(result);
}

function gf_execsql2(mysql, lzmc, lmcc1, lmcc2, lmcc3) {
    lmcc2 = lmcc2 || '', lmcc3 = lmcc3 || ''
    var result = "";
    $.ajax({
        type: "get",
        url: "execsql2.php",
        data: {sql: mysql, lmc1: lmcc1, lmc2: lmcc2, lmc3: lmcc3, lzc: lzmc, nocache: new Date().getTime()},
        contentType: "application/json;charset=utf-8",
        async: false,
        success: function (data) {
            result = data;
        }, failure: function () {
            alert("请求失败");
        }
    });
    return result.replace(/(^\s*)|(\s*$)/g, "");
    // alert(result);
}


//gf_pyzm(word)字符串拼音首字母
function gf_pyzm(word) {

    var result = "false";
    $.ajax({
        type: "get",
        url: "getpinyin.php",
        data: {pyzm: word, nocache: new Date().getTime()},
        contentType: "application/json;charset=utf-8",
        async: false,//同步
        success: function (data) {
            result = data;
        }, failure: function () {
            alert("请求失败");
        }
    });
    return result.replace(/(^\s*)|(\s*$)/g, "");
    // alert(result);
}
//enter转tab
jQuery(document).ready(function () {
    //按Enter鍵直接Tab
    var $target = $("input");
    $target.bind('keydown', function (e) {
        var key = e.which;
        if (key == 13) {
            e.preventDefault();
            var nxtIdx = $target.index(this) + 1;
            if ($target.eq(nxtIdx).attr("type") == "submit") {
                $target.eq(nxtIdx).click();
            } else {
                $target.eq(nxtIdx).focus();
            }
        }
    });
    //End
});
jQuery(document).ready(function ($) {
    $.fn.update = function (value) {
        $(this).each(function () {
            if (value != this.value) {
                this.value = value;
                this.onchange();
            }
        });
    };
});

//  myBrowser()判断浏览器类别
function myBrowser() {
    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
    var isOpera = userAgent.indexOf("Opera") > -1;
    if (isOpera) {
        return "Opera"
    }
    ; //判断是否Opera浏览器
    if (userAgent.indexOf("Firefox") > -1) {
        return "FF";
    } //判断是否Firefox浏览器
    if (userAgent.indexOf("Chrome") > -1) {
        return "Chrome";
    }
    if (userAgent.indexOf("Safari") > -1) {
        return "Safari";
    } //判断是否Safari浏览器
    if (userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera) {
        return "IE";
    } //判断是否IE浏览器
}

function isNull(data) {
    return (data == 0 || data == "" || data == undefined || data == null) ? 0 : 1;
}
function CheckBH(nubmer) {
    var re = /^[0-9a-zA-Z]*$/g;  //判断字符串是否为数字和字母组合     //判断正整数 /^[1-9]+[0-9]*]*$/
    if (!re.test(nubmer)) {
        return false;
    } else {
        return true;
    }
}


