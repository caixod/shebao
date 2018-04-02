// JavaScript Document
function SetHome(obj,vrl){
    try{
        obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl);
    }
    catch(e){
        if(window.netscape) {
            try {
                netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
            }
            catch (e) {
                alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。");
            }
            var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage',vrl);
        }else{
            alert("您的浏览器不支持，请按照下面步骤操作：1.打开浏览器设置。2.点击设置网页。3.输入："+vrl+"点击确定。");
        }
    }
}
// 加入收藏 兼容360和IE6
function shoucang(sTitle,sURL)
{
    try
    {
        window.external.addFavorite(sURL, sTitle);
    }
    catch (e)
    {
        try
        {
            window.sidebar.addPanel(sTitle, sURL, "");
        }
        catch (e)
        {
            alert("加入收藏失败，请使用Ctrl+D进行添加");
        }
    }
}

//搜索
function hdfrm(){
    var kw = $("#keyword").val()
    if(kw=='' || kw=='search...'){
        alert("请输入搜索关键词")
        return false
    }
}
//验证码
function chimg(){
    var im = document.getElementById('codeimg').src
    im = im+"1";
    document.getElementById('codeimg').src = im;
    return false
}

//订单提交
function ddfrm(){
    var name = $("#username").val()
    var phone = $("#phone").val()
    var phone2 = parseInt(phone);
    if(name==''){
        alert("请填写您的姓名")
        return false;
    }
    if(phone==''){
        alert("请填写您的联系电话")
        return false;
    }
    if(isNaN(phone2)){
        alert("联系电话必须为数字")
        return false;
    }
}
