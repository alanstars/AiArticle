<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:44:"./application/admin/template/weapp/index.htm";i:1724661384;s:77:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/layout.htm";i:1721609742;s:80:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/theme_css.htm";i:1721637128;s:73:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/weapp/bar.htm";i:1692667950;s:77:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/footer.htm";i:1680508820;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-capable" content="yes">
<!-- Apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" media="screen"/>
<link href="/public/plugins/layui/css/layui.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css">
<link href="/public/static/admin/css/main.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css">
<link href="/public/static/admin/css/page.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css">
<link href="/public/static/admin/font/css/font-awesome.min.css?v=<?php echo $version; ?>" rel="stylesheet" />
<link href="/public/static/admin/font/css/iconfont.css?v=<?php echo $version; ?>" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="/public/static/admin/font/css/font-awesome-ie7.min.css?v=<?php echo $version; ?>">
<![endif]-->
<script type="text/javascript">
    var eyou_basefile = "<?php echo \think\Request::instance()->baseFile(); ?>";
    var module_name = "<?php echo MODULE_NAME; ?>";
    var GetUploadify_url = "<?php echo url('Uploadimgnew/upload'); ?>";
    // 插件专用旧版上传图片框
    if ('Weapp@execute' == "<?php echo CONTROLLER_NAME; ?>@<?php echo ACTION_NAME; ?>") {
      GetUploadify_url = "<?php echo url('Uploadify/upload'); ?>";
    }
    var __root_dir__ = "";
    var __lang__ = "<?php echo $admin_lang; ?>";
    var __seo_pseudo__ = <?php echo (isset($global['seo_pseudo']) && ($global['seo_pseudo'] !== '')?$global['seo_pseudo']:1); ?>;
    var __web_xss_filter__ = <?php echo (isset($global['web_xss_filter']) && ($global['web_xss_filter'] !== '')?$global['web_xss_filter']:0); ?>;
    var __is_mobile__ = <?php echo (isset($is_mobile) && ($is_mobile !== '')?$is_mobile:0); ?>;
    var __security_ask_open__ = <?php echo (isset($global['security_ask_open']) && ($global['security_ask_open'] !== '')?$global['security_ask_open']:0); ?>;
</script>
<link href="/public/static/admin/js/jquery-ui/jquery-ui.min.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css"/>
<link href="/public/static/admin/js/perfect-scrollbar.min.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css"/>
<!-- <link type="text/css" rel="stylesheet" href="/public/plugins/tags_input/css/jquery.tagsinput.css?v=<?php echo $version; ?>"> -->
<style type="text/css">html, body { overflow: visible;}</style>
<link href="/public/static/admin/css/diy_style.css?v=<?php echo $version; ?>" rel="stylesheet" type="text/css" />
<?php if(file_exists(ROOT_PATH.'public/static/admin/css/theme_style.css')): ?>
    <link href="/public/static/admin/css/theme_style.css?v=<?php echo $version; ?>_<?php echo (isset($global['web_theme_style_uptime']) && ($global['web_theme_style_uptime'] !== '')?$global['web_theme_style_uptime']:0); ?>" rel="stylesheet" type="text/css">
<?php elseif(file_exists(APP_PATH.'admin/template/public/theme_css.htm') && function_exists('hex2rgba')): ?>
    <style type="text/css">
    /*官方内置样式表，升级会覆盖变动，请勿修改，否则后果自负*/

    /*左侧收缩图标*/
    #foldSidebar i { font-size: 24px;color:<?php echo $global['web_theme_color']; ?>; }
    /*左侧菜单*/
    .eycms_cont_left{ background:<?php echo $global['web_theme_color']; ?>; }
    .eycms_cont_left dl dd a:hover,.eycms_cont_left dl dd a.on,.eycms_cont_left dl dt.on{ background:<?php echo $global['web_assist_color']; ?>; }
    .eycms_cont_left dl dd a:active{ background:<?php echo $global['web_assist_color']; ?>; }
    .eycms_cont_left dl.jslist dd{ background:<?php echo $global['web_theme_color']; ?>; }
    .eycms_cont_left dl.jslist dd a:hover,.eycms_cont_left dl.jslist dd a.on{ background:<?php echo $global['web_assist_color']; ?>; }
    .eycms_cont_left dl.jslist:hover{ background:<?php echo $global['web_assist_color']; ?>; }
    /*栏目操作*/
    .cate-dropup .cate-dropup-con a:hover{ background-color: <?php echo $global['web_theme_color']; ?>; }
    /*按钮*/
    a.ncap-btn-green { background-color: <?php echo $global['web_theme_color']; ?>; }
    a:hover.ncap-btn-green { background-color: <?php echo $global['web_assist_color']; ?>; }
    .flexigrid .sDiv2 .btn:hover { background-color: <?php echo $global['web_theme_color']; ?>; }
    .flexigrid .mDiv .fbutton div.add{background-color: <?php echo $global['web_theme_color']; ?>; border: none;}
    .flexigrid .mDiv .fbutton div.add:hover{ background-color: <?php echo $global['web_assist_color']; ?>;}
    .flexigrid .mDiv .fbutton div.adds{color:<?php echo $global['web_theme_color']; ?>;border: 1px solid <?php echo $global['web_theme_color']; ?>;}
    .flexigrid .mDiv .fbutton div.adds:hover{ background-color: <?php echo $global['web_theme_color']; ?>;}
    /*选项卡字体*/
    .tab-base a.current,
    .tab-base a:hover.current {color:<?php echo $global['web_theme_color']; ?> !important;}
    .tab-base a.current:after,
    .tab-base a:hover.current:after {background-color: <?php echo $global['web_theme_color']; ?>;}
    .addartbtn input.btn:hover{ border-bottom: 1px solid <?php echo $global['web_theme_color']; ?>; }
    .addartbtn input.btn.selected{ color: <?php echo $global['web_theme_color']; ?>;border-bottom: 1px solid <?php echo $global['web_theme_color']; ?>;}
    /*会员导航*/
    .member-nav-group .member-nav-item .btn.selected{background: <?php echo $global['web_theme_color']; ?>;border: 1px solid <?php echo $global['web_theme_color']; ?>;box-shadow: -1px 0 0 0 <?php echo $global['web_theme_color']; ?>;}
    .member-nav-group .member-nav-item:first-child .btn.selected{border-left: 1px solid <?php echo $global['web_theme_color']; ?> !important;}
        
    /* 商品订单列表标题 */
   .flexigrid .mDiv .ftitle h3 {border-left: 3px solid <?php echo $global['web_theme_color']; ?>;} 
    
    /*分页*/
    .pagination > .active > a, .pagination > .active > a:focus, 
    .pagination > .active > a:hover, 
    .pagination > .active > span, 
    .pagination > .active > span:focus, 
    .pagination > .active > span:hover { border-color: <?php echo $global['web_theme_color']; ?>;color:<?php echo $global['web_theme_color']; ?>; }
    
    .layui-form-onswitch {border-color: <?php echo $global['web_theme_color']; ?> !important;background-color: <?php echo $global['web_theme_color']; ?> !important;}
    .onoff .cb-enable.selected { background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    .onoff .cb-disable.selected {background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    .pcwap-onoff .cb-enable.selected { background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    .pcwap-onoff .cb-disable.selected {background-color: <?php echo $global['web_theme_color']; ?> !important;border-color: <?php echo $global['web_theme_color']; ?> !important;}
    input[type="text"]:focus,
    input[type="text"]:hover,
    input[type="text"]:active,
    input[type="password"]:focus,
    input[type="password"]:hover,
    input[type="password"]:active,
    textarea:hover,
    textarea:focus,
    textarea:active { border-color:<?php echo hex2rgba($global['web_theme_color'],0.8); ?>;box-shadow: 0 0 0 1px <?php echo hex2rgba($global['web_theme_color'],0.5); ?> !important;}
    .input-file-show:hover .type-file-button {background-color:<?php echo $global['web_theme_color']; ?> !important; }
    .input-file-show:hover {border-color: <?php echo $global['web_theme_color']; ?> !important;box-shadow: 0 0 5px <?php echo hex2rgba($global['web_theme_color'],0.5); ?> !important;}
    .input-file-show:hover span.show a,
    .input-file-show span.show a:hover { color: <?php echo $global['web_theme_color']; ?> !important;}
    .input-file-show:hover .type-file-button {background-color: <?php echo $global['web_theme_color']; ?> !important; }
    .color_z { color: <?php echo $global['web_theme_color']; ?> !important;}
    a.imgupload{
        background-color: <?php echo $global['web_theme_color']; ?> !important;
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    /*专题节点按钮*/
    .ncap-form-default .special-add{background-color:<?php echo $global['web_theme_color']; ?>;border-color:<?php echo $global['web_theme_color']; ?>;}
    .ncap-form-default .special-add:hover{background-color:<?php echo $global['web_assist_color']; ?>;border-color:<?php echo $global['web_assist_color']; ?>;}
    
    /*更多功能标题*/
    .on-off_panel .title::before {background-color:<?php echo $global['web_theme_color']; ?>;}
    .on-off_panel .on-off_list-caidan .icon_bg .on{color: <?php echo $global['web_theme_color']; ?>;}
    .on-off_panel .e-jianhao {color: <?php echo $global['web_theme_color']; ?>;}
    
     /*内容菜单*/
    .ztree li a:hover{color:<?php echo $global['web_theme_color']; ?> !important;}
    .ztree li a.curSelectedNode{background-color: <?php echo $global['web_theme_color']; ?> !important; border-color:<?php echo $global['web_theme_color']; ?> !important;}
    .layout-left .on-off-btn {background-color: <?php echo $global['web_theme_color']; ?> !important;}

    /*框架正在加载*/
    .iframe_loading{width:100%;background:url(/public/static/admin/images/loading-0.gif) no-repeat center center;}
    
    .layui-btn-normal {background-color: <?php echo $global['web_theme_color']; ?>;}
    .layui-laydate .layui-this{background-color: <?php echo $global['web_theme_color']; ?> !important;}
    .laydate-day-mark::after {background-color: <?php echo $global['web_theme_color']; ?> !important;}
	
    /*上传框*/
    .upload-body .upload-con .image-header .image-header-l .layui-btn {
        background: <?php echo $global['web_theme_color']; ?> !important;
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-tab-brief>.layui-tab-title .layui-this {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-tab-brief>.layui-tab-title .layui-this:after {
        border-bottom-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .layui-layer-btn .layui-layer-btn0 {
        border-color: <?php echo $global['web_theme_color']; ?> !important;
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-btn-yes {
        background: <?php echo $global['web_theme_color']; ?> !important;
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .pagination li.active a {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-nav .item.active {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .group-item.active a {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .group-item.active {
        color: <?php echo $global['web_theme_color']; ?> !important;
        background-color: <?php echo hex2rgba($global['web_theme_color'],0.1); ?>;
    }
    .pagination li.active {
        border-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .layui-btn-normal {
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .image-list li.up-over .image-select-layer i {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-body .upload-con .image-list li .layer .close {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .upload-dirimg-con .ztree li a.curSelectedNode {
         background-color: #FFE6B0 !important; 
         border-color: #FFB951 !important; 
    }
    /*.plug-item-content .plug-item-bottm a, .plug-item-content .plug-status .yes {
        color: <?php echo $global['web_theme_color']; ?> !important;
    }*/
    .ncap-form-default dd.opt .layui-btn{
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .marketing_panel .title::before{
        background-color: <?php echo $global['web_theme_color']; ?> !important;
    }
    .marketing_panel .marketing_list ul.marketing-nav li a .button button {
        color: <?php echo $global['web_theme_color']; ?> !important;
        border: 1px solid <?php echo $global['web_theme_color']; ?> !important;
    }
</style>
<?php endif; ?>
<script type="text/javascript" src="/public/static/common/js/jquery.min.js?t=v1.7.0"></script>
<!-- <script type="text/javascript" src="/public/plugins/tags_input/js/jquery.tagsinput.js?v=<?php echo $version; ?>"></script> -->
<script type="text/javascript" src="/public/static/admin/js/jquery-ui/jquery-ui.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/plugins/layer-v3.1.0/layer.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery.cookie.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/admin.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery.validation.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/common.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/perfect-scrollbar.min.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/admin/js/jquery.mousewheel.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/plugins/layui/layui.js?v=<?php echo $version; ?>"></script>
<script type="text/javascript" src="/public/static/common/js/jquery.lazyload.min.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/admin/js/myFormValidate.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/admin/js/myAjax2.js?v=<?php echo $version; ?>"></script>
<script src="/public/static/admin/js/global.js?v=<?php echo $version; ?>0"></script>
</head>
<style>
    .icon-link_add {
        background-color: #fff;
        position: absolute;
        top: 5px;
        right: 6px;
        text-align: center;
        border: 1px solid #e1e1e1;
        border-radius: 50%;
        cursor: pointer;
    }
    .iconfont {
        font-family: "iconfont" !important;
        font-size: 16px;
        font-style: normal;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .e-jiahao2 {
        color: #adadad;
        font-weight: 700;
    }
    .e-jianhao {
        color: #3fa9e0;
        font-weight: 700;
    }
</style>
<body class="bodystyle" style="cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page min-hg-c-10">
    <div class="row-bar clearfix mb10">
            <div class="row-bar-l fl">
        <ul class="tab-base nc-row">
            <?php if(is_check_access(CONTROLLER_NAME.'@index') == '1'): ?>
            <li><a href="<?php echo url('Weapp/index'); ?>" class="tab <?php if(\think\Request::instance()->action() == 'index'): ?>current<?php endif; ?>"><span>我的插件</span></a></li>
            <?php endif; if(0 >= \think\Session::get('admin_info.role_id')): if(is_check_access(CONTROLLER_NAME.'@plugin') == '1'): if($weapp_plugin_open == '1'): ?>
                    <li><a href="<?php echo url('Weapp/plugin'); ?>" class="tab <?php if(\think\Request::instance()->action() == 'plugin'): ?>current<?php endif; ?>"><span>云插件库</span></a></li>
                    <?php endif; endif; if(is_check_access(CONTROLLER_NAME.'@mybuy') == '1'): ?>
                <li><a href="<?php echo url('Weapp/mybuy', ['install'=>0]); ?>" class="tab <?php if(\think\Request::instance()->action() == 'mybuy'): ?>current<?php endif; ?>"><span>已购买插件</span></a></li>
                <?php endif; endif; ?>
        </ul>
    </div>
        <div class="flexigrid fr">
            <form class="navbar-form form-inline" action="<?php echo url('Weapp/index'); ?>" method="get" onsubmit="layer_loading('正在处理');">
                <?php echo (isset($searchform['hidden']) && ($searchform['hidden'] !== '')?$searchform['hidden']:''); ?>
                <div class="ftitle">
                    <div class="sDiv2 fl" style="">
                        <input type="text" size="30" name="keywords" class="qsbox" placeholder="搜索应用名称..." autocomplete="off">
                        <input type="submit" class="btn" value="搜索">
            			<i class="iconfont e-sousuo"></i>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="flexigrid">
        <div class="plug-list">
            <?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>
            <div class="bDiv" style="height: auto;">
                <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <td class="no-data" align="center" axis="col0" colspan="50">
                                    <div class="no_row">
                                        <div class="no_pic"><img src="/public/static/admin/images/null-data.png"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="iDiv" style="display: none;"></div>
            </div>
            <?php else: ?>
                <script>
                    var update_admin_menu_url = "<?php echo url('Ajax/update_admin_menu', ['_ajax'=>1]); ?>";   //添加、删除入口地址
                    var is_founder = <?php echo (isset($is_founder) && ($is_founder !== '')?$is_founder:0); ?>;
                    $(function(){
                        //添加、取消成为栏目
                        $(".bodystyle").on('click','.e-jiahao2',function (){
                            if(is_founder !== 1){
                                return false;
                            }
                            var menu_id = $(this).data('menu_id');
                            var title = $(this).data('name');
                            var controller_name = "Weapp" ;
                            var action_name = "execute" ;
                            var param = $(this).data('param');
                            var target = $(this).data('target');
                            var icon = "iconfont e-chajian" ;
                            _this = this;
                            if($(this).hasClass('e-jianhao')) {  //原本为“已添加”，去除"我的菜单"，修改下面块为“未添加”模式，且显示
                                $.ajax({
                                    type: "POST",
                                    url: update_admin_menu_url,
                                    data: {title:title,controller_name:controller_name,action_name:action_name,menu_id:menu_id,icon:icon,param:param,target:target,type:2},
                                    dataType: 'json',
                                    success:function (res) {
                                        if(res.code == 1){
                                            //修改状态
                                            $(_this).removeClass('e-jianhao');
                                            //去除左侧菜单
                                            parent.$("."+controller_name+'_'+action_name+'_'+menu_id).remove();
                                        }
                                        return false;
                                    }
                                });
                            }else{          //原本为未添加，添加到我的菜单
                                $.ajax({
                                    type: "POST",
                                    url: update_admin_menu_url,
                                    data: {title:title,controller_name:controller_name,action_name:action_name,menu_id:menu_id,icon:icon,param:param,target:target,type:1,is_switch:0},
                                    dataType: 'json',
                                    success:function (res) {
                                        if(res.code == 1){
                                            //修改状态
                                            $(_this).addClass('e-jianhao');
                                            //添加左侧菜单
                                            var html = '<a data-child="0"  data-id="'+menu_id+ '" class="left_menu_'+menu_id+ ' '+controller_name+'_'+action_name+'_'+menu_id+'" id="'+controller_name+'_'+action_name+'"  data-menu_id="' + menu_id + '" href="javascript:void(0);" data-param="'+controller_name+'|'+action_name+param+'" data-target="'+target+'" >'
                                                +'<i class="'+icon+'"></i>'+title+'</a>';
                                            if (parent.$(".left_menu_2004")){
                                                parent.$(".left_menu_2004").before(html);
                                            }else{
                                                parent.$("#sub-menu").append(html);
                                            }
                                        }
                                        return false;
                                    }
                                });
                            }
                        });
                    });
                </script>
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
                <div class="plug-item-content">
                    <div class="plug-item-top">
                        <div class="plug-img">
                            <a href="<?php echo url('Weapp/execute',array('sm'=>$vo['code'],'sc'=>$vo['code'],'sa'=>'index')); ?>" <?php if(!empty($vo['config']['management']['href'])): ?> target="<?php echo (isset($vo['config']['management']['target']) && ($vo['config']['management']['target'] !== '')?$vo['config']['management']['target']:'_self'); ?>" <?php endif; ?>><img src="<?php echo get_default_pic($vo['config']['litpic']); ?>?v=<?php echo $vo['config']['version']; ?>" ></a>
                        </div>
                        <div class="plug-text">
                            <div class="plug-text-title">
                                <a class="title-l" href="<?php echo url('Weapp/execute',array('sm'=>$vo['code'],'sc'=>$vo['code'],'sa'=>'index')); ?>" <?php if(!empty($vo['config']['management']['href'])): ?> target="<?php echo (isset($vo['config']['management']['target']) && ($vo['config']['management']['target'] !== '')?$vo['config']['management']['target']:'_self'); ?>" <?php endif; ?>><?php echo $vo['name']; ?></a>
                                <?php echo (isset($RenewList[$vo['code']]['maturity_text']) && ($RenewList[$vo['code']]['maturity_text'] !== '')?$RenewList[$vo['code']]['maturity_text']:''); if(!(empty($is_founder) || (($is_founder instanceof \think\Collection || $is_founder instanceof \think\Paginator ) && $is_founder->isEmpty()))): if(!empty($vo['config']['management']['href'])): ?>
                                        <div class="icon-link_add">
                                            <div <?php if(in_array('1000'.$vo['id'],$menu_id_arr)): ?>title="取消导航显示" class="iconfont e-jiahao2 e-jianhao"<?php else: ?>title="加入导航显示"  class="iconfont e-jiahao2"<?php endif; ?> data-menu_id="1000<?php echo $vo['id']; ?>" data-name="<?php echo $vo['name']; ?>" data-param="<?php echo handle_weapp_url($vo['config']['management']['href']); ?>" data-target="<?php echo (isset($vo['config']['management']['target']) && ($vo['config']['management']['target'] !== '')?$vo['config']['management']['target']:'workspace'); ?>" ></div>
                                        </div>
                                    <?php else: ?>
                                        <div class="icon-link_add">
                                            <div <?php if(in_array('1000'.$vo['id'],$menu_id_arr)): ?>title="取消导航显示" class="iconfont e-jiahao2 e-jianhao"<?php else: ?>title="加入导航显示"  class="iconfont e-jiahao2"<?php endif; ?> data-menu_id="1000<?php echo $vo['id']; ?>" data-name="<?php echo $vo['name']; ?>" data-param="|sm|<?php echo $vo['code']; ?>|sc|<?php echo $vo['code']; ?>|sa|index" data-target="<?php echo (isset($vo['config']['management']['target']) && ($vo['config']['management']['target'] !== '')?$vo['config']['management']['target']:'workspace'); ?>" ></div>
                                        </div>
                                    <?php endif; endif; ?>
                            </div>
                            <div class="plug-text-versions">
                                <span>版本：<?php echo (isset($vo['config']['version']) && ($vo['config']['version'] !== '')?$vo['config']['version']:'未知'); ?></span>
                                <?php $weapp_upgrade_info = $weapp_upgrade[$vo['code']]; if($weapp_upgrade_info['code'] == '2'): ?>
                                <span>
                                    <textarea id="<?php echo $vo['code']; ?>_upgrade" class="none"><?php echo (isset($weapp_upgrade_info['msg']['upgrade']) && ($weapp_upgrade_info['msg']['upgrade'] !== '')?$weapp_upgrade_info['msg']['upgrade']:''); ?></textarea> 
                                    <textarea id="<?php echo $vo['code']; ?>_intro" class="none"><?php echo (isset($weapp_upgrade_info['msg']['intro']) && ($weapp_upgrade_info['msg']['intro'] !== '')?$weapp_upgrade_info['msg']['intro']:''); ?></textarea>
                                    <textarea id="<?php echo $vo['code']; ?>_notice" class="none"><?php echo (isset($weapp_upgrade_info['msg']['notice']) && ($weapp_upgrade_info['msg']['notice'] !== '')?$weapp_upgrade_info['msg']['notice']:''); ?></textarea>
                                    <a href="javascript:void(0);" class="a_upgrade red" data-version="<?php echo $vo['version']; ?>" data-code="<?php echo $vo['code']; ?>" data-status="<?php echo (isset($vo['status']) && ($vo['status'] !== '')?$vo['status']:'0'); ?>" data-name="<?php echo $vo['name']; ?>" onclick="weapp_upgrade(this);"><?php echo (isset($weapp_upgrade_info['msg']['tips']) && ($weapp_upgrade_info['msg']['tips'] !== '')?$weapp_upgrade_info['msg']['tips']:'[新版本更新]'); ?></a>
                                </span>
                                <?php endif; ?>
                            </div>  
                            <div class="plug-text-des">
                              <?php echo (isset($vo['config']['description']) && ($vo['config']['description'] !== '')?$vo['config']['description']:'暂无描述~'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="plug-item-bottm">
                        <?php if(empty($vo['status']) || (($vo['status'] instanceof \think\Collection || $vo['status'] instanceof \think\Paginator ) && $vo['status']->isEmpty())): if(empty($vo['is_buy']) || (($vo['is_buy'] instanceof \think\Collection || $vo['is_buy'] instanceof \think\Paginator ) && $vo['is_buy']->isEmpty())): if(is_check_access('Weapp@install') == '1'): ?>
                                <a href="javascript:void(0);" onclick="install(this);" data-id="<?php echo $vo['id']; ?>" class="btn blue">安装</a>
                                <?php endif; if(is_check_access('Weapp@del') == '1'): ?>
                                <a href="javascript:void(0);" data-url="<?php echo url('Weapp/del'); ?>" data-id="<?php echo $vo['id']; ?>" data-name="<?php echo $vo['name']; ?>" onClick="delfun(this);">删除</a>
                                <?php endif; else: if(is_check_access('Weapp@install') == '1'): ?>
                                <a href="javascript:void(0);" onclick="remoteInstall('<?php echo $vo['code']; ?>', '<?php echo $vo['min_version']; ?>');">安装</a>
                                <?php endif; if(is_check_access('Weapp@del_remote') == '1'): ?>
                                <a href="javascript:void(0);" data-url="<?php echo url('Weapp/del_remote'); ?>" data-id="<?php echo $vo['id']; ?>" data-menu_id="1000<?php echo $vo['id']; ?>" data-name="<?php echo $vo['name']; ?>" onClick="del_remote(this);">删除</a>
                                <?php endif; endif; else: if(is_check_access('Weapp@execute') == '1'): if(empty($vo['config']['management']['href'])): ?>
                                <a href="<?php echo url('Weapp/execute',array('sm'=>$vo['code'],'sc'=>$vo['code'],'sa'=>'index')); ?>">管理</a>
                                <?php else: ?>
                                <a href="<?php echo $vo['config']['management']['href']; ?>" target="<?php echo (isset($vo['config']['management']['target']) && ($vo['config']['management']['target'] !== '')?$vo['config']['management']['target']:'_self'); ?>">管理</a>
                                <?php endif; endif; if(is_check_access('Weapp@uninstall') == '1'): ?>
                                <a href="javascript:void(0);" onclick="uninstall(this);" data-id="<?php echo $vo['id']; ?>" data-menu_id="1000<?php echo $vo['id']; ?>" data-name="<?php echo $vo['name']; ?>">卸载</a>
                            <?php endif; endif; ?>

                        <div class="plug-status">
                            <?php if($vo['status'] == 1): ?>
                                <span style="cursor: pointer;" class="yes" <?php if(is_check_access('Weapp@disable') == '1'): ?>onClick="changeTableVal('weapp','id','<?php echo $vo['id']; ?>','status',this);"<?php endif; ?> data-value="-1" data-weapp_code="<?php echo $vo['code']; ?>" data-yestext="<i class='fa fa-check-circle'></i>已启用" data-notext="<i class='fa fa-ban'></i>已禁用"><i class="fa fa-check-circle"></i>已启用</span>
                            <?php else: ?>
                                <span style="cursor: pointer;" class="no" <?php if(is_check_access('Weapp@disable') == '1'): ?>onClick="changeTableVal('weapp','id','<?php echo $vo['id']; ?>','status',this);"<?php endif; ?> data-value="1" data-weapp_code="<?php echo $vo['code']; ?>" data-yestext="<i class='fa fa-check-circle'></i>已启用" data-notext="<i class='fa fa-ban'></i>已禁用"><i class="fa fa-ban"></i>已禁用</span>
                            <?php endif; if($vo['code'] == 'Diyminipro'): ?>
                            <script type="text/javascript">
                                $(function(){
                                    var diymimipro_status = "<?php echo $vo['status']; ?>";
                                    if ('1' == diymimipro_status) {
                                        $('#Diyminipro_theme_index', window.parent.document).show();
                                    } else {
                                        $('#Diyminipro_theme_index', window.parent.document).hide();
                                    }
                                });
                            </script>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
			<div class="flexigrid">
			<div class="footer-oper">
				<div class="fbuttonr">
				    <div class="pages">
				       <?php echo $page; ?>
				    </div>
				</div>
			    <div style="clear:both"></div>
			</div>
			</div>
        </div>
		
    </div>
</div>
<form name="form2" id="form2" method="post" action="">
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="code" value=""/>
    <input type="hidden" name="min_version" value=""/>
    <input type="hidden" name="thorough" value="1" />
</form>
<script>
    $(document).ready(function(){

        // 表格行点击选中切换
        $('#flexigrid > table>tbody >tr').click(function(){
            $(this).toggleClass('trSelected');
        });

        // 点击刷新数据
        $('.fa-refresh').click(function(){
            location.href = location.href;
        });
    });

    function weapp_upgrade(obj)
    {
        var name = $(obj).attr('data-name');
        var status = $(obj).attr('data-status');
        if (0 == status) {
            layer.alert('请先安装该插件！', {
                title:false,//name,
                icon: 0
            });
            return false;
        }

        var code = $(obj).attr('data-code');
        var v = $("#"+code+"_upgrade").val();    
        var intro = $("#"+code+"_intro").val();   
        intro += '<style type="text/css">.layui-layer-content{height:270px!important;text-align:left!important;}</style>';
        var notice = $("#"+code+"_notice").val(); 
        v = notice + intro + '<br/>' + v;
        //询问框
        layer.confirm(v, {
            shade: layer_shade,
            area: ['580px','400px'],
            move: false,
            title: '新版本更新',
            btnAlign:'r',
            closeBtn: 3,
            btn: ['升级','取消'], //按钮
            success: function () {
                $(".layui-layer-content").css('text-align', 'left');
            }
        }, function(){
            layer.closeAll();
            setTimeout(function(){
                upgrade(code); // 请求后台
            },200);
            
        }, function(index){  
            layer.close(index);
        });    
    }

    function upgrade(code){
        layer_loading('升级中');
        $.ajax({
            type : "GET",
            url  : "<?php echo url('Weapp/OneKeyUpgrade'); ?>",
            timeout : 360000, //超时时间设置，单位毫秒 设置了 1小时
            data : {code:code, _ajax:1},
            error: function(request) {
                layer.closeAll();
                layer.alert("升级失败！", {icon: 5, closeBtn: false, title:false}, function(){
                    window.location.reload();
                });
            },
            success: function(res) {
                if(1 == res.code){
                    $.ajax({
                        type : 'GET',
                        url : eyou_basefile+"?m=admin&c=Weapp&a=execute&sm="+code+"&sc="+code+"&sa=afterUpgrade&lang="+__lang__,
                        timeout : 360000, //超时时间设置，单位毫秒 设置了 1小时
                        data : {_ajax:1},
                        dataType : 'json',
                        success : function(res){
                            layer.closeAll();
                            layer.msg('已升级最新版本!', {time:1000}, function(){
                                window.location.reload();
                            });
                        },
                        error: function(e) {
                            layer.closeAll();
                            layer.msg('已升级最新版本!', {time:1000}, function(){
                                window.location.reload();
                            });
                        }
                    })
                }
                else{
                    layer.closeAll();
                    layer.alert(res.msg, {icon: 5, closeBtn: false, title:false}, function(){
                        window.location.reload();
                    });
                }
            }
        });
    }

    function install(obj)
    {
        var id = $(obj).attr('data-id');
        var form2 = $('#form2');
        form2.find('input[name=id]').val(id);
        var url = "<?php echo url('Weapp/install'); ?>";
        form2.attr('action', url);
        layer_loading('正在处理');
        form2.submit();
    }

    function uninstall(obj)
    {
        //询问框
        var confirm = layer.confirm('数据将不可恢复，是否卸载？', {
                shade: layer_shade,
                area: ['480px', '190px'],
                move: false,
                title: '提示',
                btnAlign:'r',
                closeBtn: 3,
                btn: ['确定', '取消'] ,//按钮
                success: function () {
                      $(".layui-layer-content").css('text-align', 'left');
                  }
            }, function(){
                layer.close(confirm);
                uninstall_true(obj);
            }, function(){
                layer.close(confirm);
            }
        );
        
        return false;
    }

    function uninstall_true(obj)
    {
        var id = $(obj).attr('data-id');

        layer_loading('正在处理');
        // 确定
        $.ajax({
            type : 'post',
            url : "<?php echo url('Weapp/uninstall'); ?>",
            data : {id:id, thorough:0, _ajax:1},
            dataType : 'json',
            success : function(res){
                layer.closeAll();
                if(res.code == 1){
                    layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                        var menu_id = $(obj).attr('data-menu_id');
                        $(".Weapp_execute_" + menu_id, window.parent.document).remove();
                        if ('_parent' == res.data.install_target) {
                            top.window.location.reload();
                        } else {
                            window.location.reload();
                        }
                    });
                }else{
                    layer.alert(res.msg, {icon: 5, title:false});
                }
            },
            error: function(e) {
                layer.closeAll();
                // 处理插件行为app_end影响到的卸载问题
                if (e.responseText.indexOf("\\behavior\\admin\\") >= 0 && e.responseText.indexOf("not found") >= 0) {
                    layer.msg('卸载成功', {icon: 1, time: 1000}, function(){
                        window.location.reload();
                    });
                } else {
                    layer.alert(e.responseText, {icon: 5, title:false});
                }
            }
        });
    }

    function delfun(obj){
        var name = $(obj).attr('data-name');
        layer.confirm('确认删除？', {
            area: ['480px', '190px'],
            shade: layer_shade,
            move: false,
            title: '提示',
            btnAlign:'r',
            closeBtn: 3,
            btn: ['确定','取消'] ,//按钮
            success: function () {
                  $(".layui-layer-content").css('text-align', 'left');
              }
        }, function(){
            layer_loading('正在处理');
            // 确定
            $.ajax({
                type : 'post',
                url : $(obj).attr('data-url'),
                data : {del_id:$(obj).attr('data-id'), _ajax:1},
                dataType : 'json',
                success : function(res){
                    layer.closeAll();
                    if(res.code == 1){
                        layer.msg(res.msg, {icon: 1, time: 1000}, function(){
                            var menu_id = $(obj).attr('data-menu_id');
                            $(".Weapp_execute_" + menu_id, window.parent.document).remove();
                            window.location.reload();
                        });
                    }else{
                        layer.alert(res.msg, {icon: 5, title:false});  //alert(res);
                    }
                }
            })
        }, function(index){
            layer.close(index);
        });
        return false;
    }

    function del_remote(obj){
        var name = $(obj).attr('data-name');
        layer.confirm('确认移除？', {
            area: ['480px', '190px'],
            shade: layer_shade,
            move: false,
            title: '提示',
            btnAlign:'r',
            closeBtn: 3,
            btn: ['确定','取消'] ,//按钮
            success: function () {
                  $(".layui-layer-content").css('text-align', 'left');
              }
        }, function(){
            layer_loading('正在处理');
            // 确定
            $.ajax({
                type : 'post',
                url : $(obj).attr('data-url'),
                data : {del_id:$(obj).attr('data-id'), _ajax:1},
                dataType : 'json',
                success : function(data){
                    layer.closeAll();
                    if(data.code == 1){
                        layer.msg(data.msg, {icon: 1});
                        window.location.reload();
                    }else{
                        layer.alert(data.msg, {icon: 5, title:false});  //alert(data);
                    }
                }
            })
        }, function(index){
            layer.close(index);
        });
        return false;
    }

    function jump() {
        location.reload()
    }

    function remoteInstall(code, min_version) {
        var form2 = $('#form2');
        form2.find('input[name=code]').val(code);
        form2.find('input[name=min_version]').val(min_version);
        var url = "<?php echo url('Weapp/remoteInstall'); ?>";
        form2.attr('action', url);
        layer_loading('远程安装');
        form2.submit();
    }
</script>

<div id="goTop">
    <a href="JavaScript:void(0);" id="btntop">
        <i class="fa fa-angle-up"></i>
    </a>
    <a href="JavaScript:void(0);" id="btnbottom">
        <i class="fa fa-angle-down"></i>
    </a>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#think_page_trace_open').css('z-index', 99999);
    });
</script>
</body>
</html>