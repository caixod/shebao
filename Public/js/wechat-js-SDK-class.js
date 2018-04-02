/**
 * Created by Administrator on 2017/4/12.
 */
$("<script>")
    .attr({ rel: "script",
        type: "text/javascript",
        src: "https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"
    })
    .appendTo("head");
$("<link>")
    .attr({ rel: "stylesheet",
        type: "text/css",
        href: "https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
    })
    .appendTo("head");

var wechat = wechat || {};
wehchat.prototype = {

    /*debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
    appId: '', // 必填，公众号的唯一标识
    timestamp: 0, // 必填，生成签名的时间戳
    nonceStr: '', // 必填，生成签名的随机串
    signature: '',// 必填，签名，见附录1
    jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2*/
    //初始化，加载微信JS-SDK
    init:function(){
        $("<script>")
            .attr({ rel: "script",
                type: "text/javascript",
                src: "http://res.wx.qq.com/open/js/jweixin-1.2.0.js"
            })
            .appendTo("head");
        $.ajax({

        });
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: '', // 必填，公众号的唯一标识
            timestamp: 0, // 必填，生成签名的时间戳
            nonceStr: '', // 必填，生成签名的随机串
            signature: '',// 必填，签名，见附录1
            jsApiList: [] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });

    },


}