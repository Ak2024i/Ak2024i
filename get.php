<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <title>  学习平台自助查单补单系统        </title>
        <link href="assets/imgage/favicon.ico" rel="shortcut icon"/>
        <!-- Bootstrap Core CSS -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="assets/css/index.css" rel="stylesheet"/>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
            <script src="assets/js/html5shiv.min.js"></script>
            <script src="assets
            	
            	
            	
            	/js/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .cm-kfqy{
          background-color: #fff;
          padding: 1px 3px;
          padding-left: 10px;
          display: block;
          color: #000 !important;
          border-radius: 4px;
        }
        .cm-kfqy:hover{
          background-color: #f0f0f0;
          padding: 1px 3px;
          padding-left: 10px;
          width: 100%;
          display: block;
          color: #000 !important;
          border-radius: 4px;
        }
        </style>
    </head>
    <body id="page-top">
        <div id="app">
            <div class="col-lg-4 col-md-7 col-sm-10" style="float: none;  margin: auto; padding-top: 50px">
                <!--html公告代码 开始-->                                                         
                <!--html公告代码 结束-->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{title}}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    {{inputName}}
                                </div>
                                <input class="form-control" type="text" v-model="username"/>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified form-group">
                            <a class="btn btn-block btn-success" v-bind:html="btnName" v-on:click="query()">
                                {{btnName}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default" v-show="userInfo.show">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{userInfo.title}}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>学生姓名</th>
                                    <th>网课账号</th>
                                    <th>学校名称</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{userInfo.name}}
                                    </td>
                                    <td>
                                        {{userInfo.user}}
                                    </td>
                                    <td>
                                        {{userInfo.school}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default" v-show="orderInfo.show">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{orderInfo.title}}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default" v-for="(item,index) in orderInfo.list" v-bind:key="index">
                                <a class="cm-kfqy collapsed" data-parent="#accordion" data-toggle="collapse" :href="'#collapseOne'+index">
                                    <h4>{{item.kcname}}</h4>
                                </a>
                                <div class="panel-collapse collapse in" :id="'collapseOne'+index">
                                    <div class="panel-body"> 
                                    	课程名称：{{item.kcname}}<br/>
	                                        下单时间：{{item.addtime}} <br/>
	                                        更新时间：{{item.update_time}}<br/>
	                                        课程开始时间：{{item.courseStartTime}}<br/>
	                                        课程结束时间：{{item.courseEndTime}}<br/>
	                                        考试开始时间：{{item.examStartTime}}<br/>
	                                        考试结束时间：{{item.examEndTime}}<br/>
	                                        登录状态：{{item.loginstatus}}<br/>
	                                        订单状态：{{item.status}}<br/>
	                                        课程进度：
                                        <div class="progress">
                                            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" class="progress-bar progress-bar-info" role="progressbar" v-bind:style="'width:'+(item.chapterCount/item.unfinishedChapterCount*100)+'%;'">
                                                <span class="sr-only">
                                                    {{item.chapterCount/item.unfinishedChapterCount*100}}% 完成（信息）
                                                </span>
                                            </div>
                                        </div>
                                        是否补单：
                                        <button class="btn btn-success btn-xs" v-on:click="fill(item.id)">
                                            补单
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/js/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>


<script>
	/*本页面查询进度并非实时进度，具体以登录app查询为准！
如挤登后务必需要到本页面操作一下补单。
下单后如果查不到订单请等待几小时后查询
漏课程请咨询下单网站客服
请勿无脑补单 提交次数过多并不会有啥翻倍效果
每天下午可能为订单提交高峰期 补单容易失败 换个时间提交即可
*/
new Vue({
    el: '#app',
    data: {
        title: '网课自助售后查询',
        inputName: '网课账号',
        btnName: '查询信息',
        list: {},
        username: '',
        is_load: false,
        userInfo: {
            show: false,
            title: '学生信息（请核对后是本人再继续操作）',
            name: '',
            user: '',
            school: '',
            type: 0
        },
        orderInfo: {
            show: false,
            title: '订单信息(详情或补单请单击课程名展开)',
            list: {}
        }
    },
    methods: {
        query: function() {
            //console.log(this.username);
            if (this.username == "") {
            	layer.msg("请输入查询账号！");              
                this.btnName = '重新查询信息';
                return false;
            }
            var that = this;
            that.userInfo.show = false;
            that.orderInfo.show = false;
            that.orderInfo.list = {};
            that.load();
            $.ajax({
                type: "POST",
                url: "api.php?act=chadan",
                data: {username: this.username},
                dataType: 'json',
                success: function(data) {
                    that.load();
                    if (typeof data.data == 'object') {
                        if (data.data.length > 0) that.userInfo.name = data.data[0].name;
                        if (data.data.length > 0) that.userInfo.school = data.data[0].school;
                        that.userInfo.user = that.username;
                        that.userInfo.show = true;
                        if (data.data.length > 0) {
                            that.orderInfo.type = data.type;
                            that.orderInfo.list = data.data;
                            that.orderInfo.show = true;
                        }
                    } else {
                        layer.msg("未查询到相关订单信息！");
                    }
                },
                error: function(e) {
                    console.log(e);
                    layer.alert('服务器错误，请稍后再试！');
                }
            });
        },
        fill: function(id) {
            var wktype = this.orderInfo.type;
            $.ajax({
                type: "POST",
                url: "api.php?act=budan",
                data: {id:id},
                dataType: 'json',
                success: function(data) {
                    if (data.code == 1) {
                        layer.alert(data.msg,{icon:1});
                    } else {
                        layer.alert(data.msg,{icon:2,title:'马保国：'});
                    }
                },
                error: function(e) {
                    console.log(e);
                    layer.alert('服务器错误，请稍后再试！');
                }
            });
        },
        load: function() {
            if (this.is_load === false) {
                this.btnName = '查询中..';
            } else {
                this.btnName = '重新查询信息';
            }
            this.is_load = !this.is_load;
        }
    }
});
</script>
    </body>
</html>