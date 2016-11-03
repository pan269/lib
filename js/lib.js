//获取当前链接传参 x.html?e=xx
function getQueryString(e) {
  var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)");
  var a = window.location.search.substr(1).match(t);
  if (a != null) return a[2];
  return ""
}

/*打印对象*/
function writeObj(obj){ 
	var description = ""; 
	for(var i in obj){ 
	var property=obj[i]; 
	description+=i+" = "+property+"\n"; 
	} 
	alert(description); 
} 