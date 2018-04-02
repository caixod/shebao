/*
    @Name：uploader v1.2 html5上传组件
    @Author：坚强di理由
    @Site：http://blog.csdn.net/qczxl
    @License：LGPL
 */
;(function($){
    var uploader = function(options) {
        if(window.File && window.FileList && window.FileReader && window.Blob) {
            this.settings = $.extend({}, uploader.defaults, options);
            this.fileFilter    = [];
            this.failureFilter = [];
            this.upNum      = 0;  //已上传文件的总数量
            this.sNum       = 0;  //单次上传成功的数量
            this.eNum       = 0;  //单次上传失败的数量
            this.index      = 0;  //初始文件索引
            this.totalSize  = 0;  //选择文件总大小k
            this.up         = 0;  //标识是否正在上传
            this.rExt       = /\.([^.]+)$/;
            this.selindex   = 0;
            this.mapping    = {};
            this.onInit();
        } else {
            this.settings.upBox.html('您的浏览器版本过低，请升级浏览器，或更换浏览器！');
        }
    };
    uploader.prototype = {
        //初始化
        onInit : function() {
            var box   = this.settings.upBox,
                html,
                border='';
            //没有上传的对象盒子
            if(box === null || !box.size()) {
                return;
            }
            this.settings.allowExt = this.settings.allowExt.toLowerCase();
            html = '<input accept="'+this.settings.allowExt+'" type="file" '+(this.settings.multiple === true ? 'multiple' : '')+' />';
            //往上传对象盒子追加内容
            switch(this.settings.skin) {
                case 1:
                    html += '<div class="setupload">' +
                                '<p class="btn_box"><span class="btn_up selfile">'+this.settings.text+'</span><i></i></p>' +
                                '<p class="drag">或者将图片拖到此处</p>' +
                            '</div>';
                    border = 'style="border-top:0px none;"';        
                    break;
                case 2:
                    //没有找到绑定点击事件的元素
                    if(!box.find('.selfile').size()) {
                        return;
                    }
                    break;
                default:
                    return;
            }
            html += '<div class="preview" '+border+'></div>' + 
                    '<div class="operating"><span class="status_info"></span>';
            if(!this.settings.auto) {
                html += '<span class="btn_up">开始上传</span>';
            }
            html += '</div>';
            box.addClass('qc');
            box.append(html);
            //预览盒子
            this.viewObj    = box.find('.preview');
            //上传按钮及上传队列信息盒子
            this.operObj    = box.find('.operating');
            //上传控件
            this.fileLabel  = box.find("input[type='file']");
            this.onEvent();
        },
        //绑定事件
        onEvent : function() {
            var box  = this.settings.upBox,
                self = this;
            //转移点击事件到file控件上
            box.find(".selfile").click(function(){
                if(self.up) {
                    self.alert('文件正在上传，请等待此次上传完毕！');
                } else {
                    self.fileLabel.click(); 
                }
            });
            //file控件的选择事件
            this.fileLabel.bind("change",function(e){ self.getFiles(e); });
            //监听预览框中的删除事件
            this.viewObj.on('click', '.del', function(){ self.del(this); });
            //绑定上传事件到上传按钮
            if(!this.settings.auto) {
                box.find('.btn_up').click(function(){ self.uploadFile(); });
            }
            //拖拽事件绑定
            if(box.find('.drag').size()) {
                var dr = box.find('.drag').get(0);
                //拖来拖去
                dr.addEventListener("dragover", function(e) { self.dragHover(e) }, false);
                //拖离
                dr.addEventListener("dragleave", function(e) { self.dragHover(e) }, false);
                //拖放
                dr.addEventListener("drop", function(e) { self.getFiles(e); }, false);
            }

        },
        //拖来拖去与拖离事件
        dragHover : function(e) {
            e.stopPropagation(); // 阻止冒泡
            e.preventDefault();  //阻止浏览器的默认行为
            if(e.type === 'dragover') {
                this.settings.upBox.find('.drag').css('border-color','red');
            } else {
                this.settings.upBox.find('.drag').css('border-color','#DDD');
            }
        },
        //选择文件
        getFiles : function(e) {
            var box = this.settings.upBox;
            if(box.find('.drag').size()) {
                e.stopPropagation();
                e.preventDefault();
                box.find('.drag').css('border-color','#DDD');
            }
            this.files = e.target.files || e.dataTransfer.files;
            //选择完获取文件前回调，可用于检测是否超出允许上传的数量
            if(typeof this.settings.onBeforeGetFiles === 'function') {
                this.flog = this.settings.onBeforeGetFiles(this.files.length,this.fileFilter.length,this.upNum);
            }
            //外部没有检测或检测数量通过
            if(this.flog !== false) {
                //把选择的文件追加到上传队列
                this.checkFilter();
            }
        },
        //检测文件类型及大小
        checkFilter : function() {
            var file,
                ext,
                flog = true;
            if(this.selindex < this.files.length) {
                file = this.files[this.selindex];
                this.selindex++;
                ext = this.rExt.exec( file.name ) ? RegExp.$1.toLowerCase() : '';
                //检测文件类型是否合法
                if(!ext || this.settings.allowExt.indexOf(ext) === -1) {
                    flog = false;
                    this.alert('“'+file.name+'”文件类型不正确！允许上传类型为（'+this.settings.allowExt+'）');
                }
                //检测文件大小是否合法
                if (flog && file.size > this.settings.maxSize) {
                    flog = false;
                    this.alert('“' + file.name +'”过大，应小于'+ this.bytesToSize(this.settings.maxSize));
                }
                if(flog) {
                    if(this.hashString(file)) {
                        //添加文件索引
                        file.index = this.index++;
                        file.ext   = ext;
                        this.fileFilter.push(file);
                        this.previewImg(file);
                        this.totalSize += file.size;
                    } else {
                        this.alert('“' + file.name +'”重复了');
                        this.checkFilter();
                    }
                } else {
                    this.checkFilter();
                }
            } else {
                if(this.fileFilter.length > 0) {
                    this.selindex = 0;
                    //是否自动上传
                    if(this.settings.auto) {
                        this.uploadFile();
                    } else {
                        this.settings.upBox.find('.btn_up').show();
                    }
                }
            }
        },
        //获取预览文件的预览图片
        previewImg : function(file) {
            var self = this,
                ext  = file.ext;
            if('jpg,jpeg,png,gif,bmp'.indexOf(ext) === -1) {
                var fileImgSrc;
                switch(ext) {
                    case 'txt':
                        fileImgSrc = 'txt.png';
                        break;
                    case 'rar':
                        fileImgSrc = 'rar.png';
                        break;
                    case 'zip':
                        fileImgSrc = 'zip.png';
                        break;
                    case 'ppt':
                        fileImgSrc = 'ppt.png';
                        break;
                    case 'xls':
                        fileImgSrc = 'xls.png';
                        break;
                    case 'pdf':
                        fileImgSrc = 'pdf.png';
                        break;
                    case 'psd':
                        fileImgSrc = 'psd.png';
                        break;
                    case 'ttf':
                        fileImgSrc = 'ttf.png';
                        break;
                    case 'swf':
                        fileImgSrc = 'swf.png';
                        break;
                    default:
                        fileImgSrc = 'file.png';
                }
                self.previewHtml(file, '../img/'+fileImgSrc);
            } else {
                var reader = new FileReader();
                reader.onload = function(e) {
                    self.previewHtml(file, e.target.result);
                };
                reader.readAsDataURL(file);
            }
        },
        //处理预览内容
        previewHtml : function(file, img) {
            if(typeof this.settings.onPreview === 'function') {
                this.settings.onPreview(file, img);
            } else {
                var html = '<ul class="wait up'+file.index+'">' +
                                '<li><img src="' + img + '" /><i></i></li>' +
                                '<li><span class="status">等待上传</span><span data-index="'+ file.index +'" class="del"></span></li>' +
                            '</ul>';
                this.viewObj.append(html);
                //处理一些隐藏的元素
                if(this.viewObj.is(":hidden")) {
                    this.viewObj.show();
                    this.operObj.show();
                }
                this.statusinfo(0);
            }
            this.checkFilter();
        },
        //开始上传
        uploadFile : function() {
            var self = this,
                btn_up = this.operObj.find('.btn_up'),
                xhr,
                file,
                data;
            if(window.location.host === '') {
                this.alert('上传功能需要在服务器环境下测试');
                return;
            }
            if(this.fileFilter[0]) {
                if(!this.up) {
                    this.up = 1;
                    this.totalNum = this.fileFilter.length;
                }
                if(!btn_up.is(":hidden")){
                    btn_up.hide();
                }
                file = this.fileFilter[0];
                this.statusObj = this.viewObj.find('.up'+file.index+ ' .status');
                xhr = new XMLHttpRequest();
                if (xhr.upload) {
                    //上传中
                    xhr.upload.addEventListener("progress", function(e) {
                        self.progress(file, e.loaded, e.total);
                    }, false);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if(xhr.status === 200) {
                                data = JSON.parse(xhr.responseText);
                                if(data.error > 0) {
                                    self.failure(file, data.info);
                                } else {
                                    self.success(file, data.info);
                                }
                            } else {
                                self.failure(file, '找不到上传URL地址');
                            }
                            //成功或失败都删除队列
                            self.fileFilter.shift();
                            //继续上传
                            self.uploadFile();
                        }
                    };
                    xhr.open("POST", self.settings.upUrl, true);
                    xhr.setRequestHeader("X_FILENAME", encodeURIComponent(file.name)); 
                    var f = new FormData();
                    f.append(file.name, file);
                    xhr.send(f);
                }
            } else if(this.up) {
                //记录总上传成功数量
                self.upNum += self.sNum;
                if(self.viewObj.html() !== '') {
                    self.statusinfo(2);
                    self.viewObj.find('.wait').addClass('removed-item');
                    setTimeout(function(){
                        self.viewObj.find('.wait').remove();
                        if(self.viewObj.html() === '') {
                            self.viewObj.hide();
                            self.operObj.hide();
                        }
                    },1200);
                }
                //初始化变量
                self.fileLabel.val("");
                self.up   = 0;
                self.sNum = 0;
                self.eNum = 0;
            }
        },
        //上传中
        progress : function(file, loaded, total) {
            if(typeof this.settings.onProgress === 'function') {
                this.settings.onProgress(file, loaded, total);
            } else {
                this.statusObj.html(parseFloat((loaded / total * 100).toFixed(1)) + '%');
            }
        },
        //有成功返回
        success : function(file, response) {
            this.sNum++;  //本次成功上传数量
            if(this.viewObj.html() !== '') {
                this.statusObj.html('<font color="green">上传成功</font>');
                this.statusinfo(1);
            } 
            if(typeof this.settings.onSuccess === 'function') {
                this.settings.onSuccess(file, response);
            }
        },
        //处理上传失败
        failure : function(file, response) {
            this.eNum++;
            if(this.viewObj.html() !== '') {
                this.statusObj.html('<font color="red">上传失败</font>');
                this.statusinfo(1);
                this.failureFilter.push(file);
                var obj = this.viewObj.find('.up'+file.index);
                obj.removeClass('wait');
                obj.addClass('failure');
            }
            if(typeof this.settings.onFailure === 'function') {
                this.settings.onFailure(file, response);
            }
        },
        //移除页面元素
        del : function(obj) {
            var parent = $(obj).parent().parent(),
                self   = this;
            if(parent.hasClass('wait')) {    
                this.fileFilter = this.unset($(obj).attr('data-index'));
                this.statusinfo(0);
            }
            parent.addClass('removed-item');
            setTimeout(function(){
                parent.remove();
                if(!self.fileFilter.length) {
                    self.viewObj.hide();  //预览盒子
                    self.operObj.hide(); //上传按钮与上传队列信息盒子
                }
            },1200);   
        },
        //移除指定上传队列
        unset : function(index) {
            var arrFile = [];
            for (var i = 0, file; file = this.fileFilter[i]; i++) {
                if (file.index !== parseInt(index)) {
                    arrFile.push(file);
                } else {
                    this.totalSize = this.totalSize - file.size;
                    this.hashString(file,1);
                }
            }
            return arrFile;
        },
        //上传队列信息
        statusinfo : function(type) {
            var str = '',self=this;
            if(type === 0) {
                str = this.fileFilter.length > 0 ? '选中'+this.fileFilter.length+'个文件，共'+this.bytesToSize(this.totalSize) : '';
            } else if(type === 1) {
                str = '共'+this.totalNum+'个文件，已上传'+this.sNum+'个'+(this.eNum > 0 ? '，失败'+this.eNum+'个' : '');
            } else if(type === 2) {
                str = '已成功上传'+this.sNum+'个文件'+(this.eNum > 0 ? '，'+this.eNum+'个文件上传失败，<span class="again">重新上传</span>失败文件或<span class="ignore">忽略</span>' : '');
            }
            this.operObj.find('.status_info').html(str);
            this.operObj.find('.again').click(function(){
                if(self.failureFilter.length > 0) {
                    self.fileFilter = self.failureFilter;
                    self.failureFilter = [];
                    self.viewObj.find('.failure').addClass('wait');
                    self.viewObj.find('.wait').removeClass('failure');
                    self.viewObj.find('.wait .status').html('等待上传');
                    self.uploadFile();
                }
            });
            this.operObj.find('.ignore').click(function(){
                self.failureFilter = [];
                self.viewObj.find('.failure').addClass('removed-item');
                setTimeout(function(){
                    self.viewObj.html('');
                    self.viewObj.hide();
                    self.operObj.find('.status_info').html('');
                    self.operObj.hide();
                },1200);
            });
        },
        //去除重复
        hashString : function(file, type) {
            var hash = 0,
                i = 0,
                str = file.name + file.size + file.lastModifiedDate,
                len = str.length;
            type = type || 0;
            for ( ; i < len; i++ ) {
                hash  += str.charCodeAt( i );
            }
            hash += file.size;
            if ( this.mapping[ hash ] ) {
                if(type === 1) {
                    delete this.mapping[ hash ];
                }
                return false;
            }
            this.mapping[ hash ] = true;
            return true;
        },
        //格式化文件大小, 输出成带单位的字符串
        bytesToSize : function(size) {
            var unit;
            var units = [ 'B', 'K', 'M', 'G', 'TB' ];
            while ( (unit = units.shift()) && size >= 1024 ) {
                size = size / 1024;
            }
            return (unit === 'B' ? size : parseFloat(size.toFixed(2))) + unit;
        },
        //弹框回调
        alert : function(msg) {
            if(typeof this.settings.onAlert === 'function') {
                this.settings.onAlert(msg);
            } else {
                alert(msg);
            }
        }
    };
    uploader.defaults = {
        //参数集合
        'upBox'             :  null,                             //上传盒子
        'upUrl'             :  '',                               //上传地址
        'multiple'          :  true,                             //上传模式 false单  true批量
        'maxSize'           :  1024*1024,                        //允许上传文件的最大大小，单位bytes
        'allowExt'          :  '.jpg,.jpeg,.png,.gif,.bmp',      //允许上传的文件类型
        'auto'              :  false,                            //是否自动上传
        'skin'              :  1,                                //上传样式  1默认  2自定义
        'text'              :  '选择图片',                       //默认时的按钮文字
        //事件集合
        'onBeforeGetFiles'  :  null,                             //验证上传数量回调
        'onPreview'         :  null,                             //预览
        'onProgress'        :  null,                             //上传中
        'onSuccess'         :  null,                             //上传成功
        'onFailure'         :  null,                             //上传失败
        'onAlert'           :  null,                             //弹框回调
    };
    $.uploader = function(options) {
        return new uploader(options);
    };
})(window.jQuery || window.Zepto);