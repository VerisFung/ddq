/* 
* @Author: Veris
* @Date:   2015-08-13 21:05:07
* @Last Modified by:   Veris
* @Last Modified time: 2015-08-15 17:32:26
*/
var xmlhttp;
var current_id=-1;
var new_id=-1;
if(window.XMLHttpRequest){
    xmlhttp=new XMLHttpRequest();    
} else {
    try{
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(err){
        try{
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(err){
            alert('你他妈用的什么鸟浏览器！');
        }
    }
}

function sendData(){
    user=document.getElementsByTagName('input')['user'].value;
    contents=document.getElementsByTagName('input')['contents'].value;

    xmlhttp.open('POST','api.php?action=insertMsg',false);
    xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    xmlhttp.send('user='+user+'&contents='+contents);
    if(xmlhttp.readyState==4 && xmlhttp.status==200){
        document.getElementsByTagName('input')['contents'].value='';
        if(xmlhttp.responseText!=1){
            alert('发送失败！');
        }
    }
}

function getData(){
    if(new_id!=-1 && current_id<new_id){
        xmlhttp.open('POST','api.php?action=selectMsg',false);
        xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        xmlhttp.send('current_id='+current_id);
        msgWindow=document.getElementsByTagName('textarea')['msgWindow'];
        if(xmlhttp.responseText!='null'){
            var obj = JSON.parse(xmlhttp.responseText);
            for(var i=0;i<obj.length;i++){
                msgWindow.value+='('+obj[i].time+')'+obj[i].user+'：'+obj[i].contents+'\n';
            }
            msgWindow.scrollTop=msgWindow.scrollHeight;
        }
        current_id=new_id;
    }
    getNewId();
}

function getNewId(){
    xmlhttp.open('GET','api.php?action=getNewId',false);
    xmlhttp.send();
    if(xmlhttp.responseText=='null'){
        new_id=-1;
    } else {
        new_id=xmlhttp.responseText;
    }
}

function init(){
    getNewId();
    current_id=new_id-10;//初始化显示消息数
}
