var sWeek = new Array("日","一","二 ","三","四","五","六"); //声明数组存储一周七天
var myDate = new Date();    // 当天的日期
var sYear = myDate.getFullYear();    // 年
var sMonth = myDate.getMonth()+1;    // 月
var sDate= myDate.getDate();         // 日
var sDay= sWeek[myDate.getDay()];   // 根据得到的数字星期，利用数组转换成汉字星期
var h=myDate.getHours();   //小时
var m=myDate.getMinutes();  //分钟
var s=myDate.getSeconds();  //秒钟
//输入日期和星期
var yyyy=sYear;
var mm=formatTwoDigits(sMonth);  //格式化月份，如果不足两位前补0
var dd=formatTwoDigits(sDate);  //格式化天数，如果不足两位前补0
h=formatTwoDigits(h);  //格式化小时，如果不足两位前补0
m=formatTwoDigits(m);  //格式化分钟，如果不足两位前补0
s=formatTwoDigits(s);  //格式化秒钟，如果不足两位前补0
//如果输入数是1位数，在十位数上补0
function formatTwoDigits(s) {
  if (s<10) return "0"+s;
  else return s;
}