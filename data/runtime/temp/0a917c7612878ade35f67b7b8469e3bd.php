<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:46:"./application/admin/template/article/index.htm";i:1722582444;s:77:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/layout.htm";i:1721609742;s:80:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/theme_css.htm";i:1721637128;s:75:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/article/bar.htm";i:1655708908;s:81:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/archives/tags_btn.htm";i:1713251000;s:81:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/archives/flag_btn.htm";i:1680508820;s:75:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/page.htm";i:1655708908;s:77:"/Users/alan/Projects/WWW/eyoucms/application/admin/template/public/footer.htm";i:1680508820;}*/ ?>
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

<body style="background-color: rgb(255, 255, 255); overflow: auto; cursor: default; -moz-user-select: inherit;">
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div class="page" style="box-shadow:none;">
    <!-- 
    <div class="fixed-bar">
        <div class="item-title">
            <a class="back_xin" href="javascript:history.back();" title="返回"><i class="iconfont e-fanhui"></i></a>
            <div class="subject">
                <h3>返回上一层</h3>
                <h5></h5>
            </div>
        </div>
    </div> -->
    <div class="flexigrid" style="min-height: 600px;">
        <div class="mDiv">
            <div class="ftitle">
                <!-- 扩展 -->
    <?php if(is_check_access(CONTROLLER_NAME.'@add') == '1'): ?>
        <div class="fbutton" style="float: none;">
            <input type="hidden" id="releaseUrl" value="<?php echo url(CONTROLLER_NAME.'/add', ['channel'=>\think\Request::instance()->param('channel'), 'typeid'=>\think\Request::instance()->param('typeid'), 'callback_url'=>$callback_url], true, $website_host); ?>">
            <a href="javascript:void(0);" onclick="<?php if(\think\Request::instance()->param('typeid') > '0'): ?>archivesRelease('<?php echo CONTROLLER_NAME; ?>', <?php echo (isset($shopOpen) && ($shopOpen !== '')?$shopOpen:'0'); ?>, '', <?php echo \think\Request::instance()->param('typeid'); ?>);<?php else: ?>quick_release(<?php echo (isset($is_arctype) && ($is_arctype !== '')?$is_arctype:'1'); ?>);<?php endif; ?>">
                <div class="add">
                    <?php if(CONTROLLER_NAME == 'Special'): ?>
                    <span><i class="layui-icon layui-icon-addition"></i>发布专题</span>
                    <?php else: ?>
                    <span><i class="layui-icon layui-icon-addition"></i>发布文档</span>
                    <?php endif; ?>
                </div>
            </a>
        </div>
    <?php endif; ?>

    <script type="text/javascript">
        function archivesRelease(controller, shopOpen, url, typeid) {
            // 提示是否前往商城中心
            var releaseUrl = url == '' || url === undefined || url === 'undefined' ? $('#releaseUrl').val() : url;
            if ('Product' == controller && 1 === parseInt(shopOpen)) {
                confirmRelease(releaseUrl, 'add');
                return false;
            } else if ('Archives' == controller && 1 === parseInt(shopOpen)) {
                var goodsTypeIds = "<?php echo (isset($goodsTypeIds) && ($goodsTypeIds !== '')?$goodsTypeIds:''); ?>";
                if (0 <= $.inArray(String(typeid), goodsTypeIds.split(','))) {
                    confirmRelease(releaseUrl, 'add');
                    return false;
                }
            }

            // 默认跳转路径
            window.location.href = releaseUrl;
        }

        function productEdit(obj, shopOpen, goodsID) {
            // 提示是否前往商城中心
            var releaseUrl = $(obj).attr('data-url');
            if (1 === parseInt(shopOpen)) {
                confirmRelease(releaseUrl, 'edit', goodsID);
                return false;
            }

            // 默认跳转路径
            window.location.href = releaseUrl;
        }

        var neverAgainPrompt = <?php echo (isset($neverAgainPrompt) && ($neverAgainPrompt !== '')?$neverAgainPrompt:0); ?>;
        function confirmRelease(url, opt, goodsID) {
            if (0 === parseInt(neverAgainPrompt)) {
                var btn1 = '前往商城中心';
                var btn2 = 'add' == opt ? '继续发布' : '继续编辑';
                var msg = '如需体验更好的商品发布请使用商城中心管理商品 <br/>' + '<label><input type="checkbox" id="neverAgainPrompt"> 不再提示</label>';
                layer.confirm(msg, {
                    move: false,
                    closeBtn: 3,
                    title: '提示',
                    btnAlign: 'r',
                    btn: [btn1, btn2],
                    shade: layer_shade,
                    area: ['480px', '190px'],
                    success: function () {
                        $(".layui-layer-content").css('text-align', 'left');
                    }
                }, function (index) {
                    // 是否确认永久不再提示
                    ajaxNeverAgainPrompt();

                    layer.close(index);
                    // 前往商城中心
                    var click_url = eyou_basefile + '?m=admin&c=ShopProduct&a=index';
                    if ('add' == opt) click_url = eyou_basefile + '?m=admin&c=ShopProduct&a=add';
                    if ('edit' == opt && goodsID) click_url = eyou_basefile + '?m=admin&c=ShopProduct&a=edit&id=' + goodsID;
                    top.$('#Shop_home').attr('data-click', true).attr('data-click_url', click_url).click();
                }, function (index) {
                    // 是否确认永久不再提示
                    ajaxNeverAgainPrompt();

                    layer.close(index);
                    // 默认跳转路径
                    window.location.href = url;
                });
            } else {
                window.location.href = url;
            }
        }

        // 是否确认永久不再提示
        function ajaxNeverAgainPrompt() {
            neverAgainPrompt = true == $('#neverAgainPrompt').is(':checked') ? 1 : 0;
            if (1 === parseInt(neverAgainPrompt)) {
                $.ajax({
                    url : "<?php echo url('System/neverAgainPrompt'); ?>",
                    type: "POST",
                    data: {neverAgainPrompt: neverAgainPrompt, _ajax: 1},
                });
            }
        }
        
        $(document).ready(function(){
            $('#searchForm select[name=flag]').change(function(){
                $('#searchForm').submit();
            });
        });

        function jump_is_release() {
            var is_release = $('#searchForm input[name=is_release]').val();
            if (1 == is_release) {
                $('#searchForm input[name=is_release]').val('');
            } else {
                $('#searchForm input[name=is_release]').val('1');
            }
            $('#searchForm').submit();
        }

        function quick_release(is_arctype) {
            if (is_arctype && 0 < is_arctype) {
                //iframe窗
                layer.open({
                    type: 2,
                    title: '快捷发布文档',
                    fixed: true, //不固定
                    shadeClose: false,
                    shade: layer_shade,
                    maxmin: false, //开启最大化最小化按钮
                    area: ['600px', '552px'],
                    content: "//<?php echo $website_host; ?><?php echo \think\Request::instance()->baseFile(); ?>?m=admin&c=Archives&a=release&iframe=2&lang=<?php echo \think\Request::instance()->param('lang'); ?>",
                    success: function(layero, index){
                        // var body = layer.getChildFrame('body', index);
                        // var gourl = $('.curSelectedNode').attr('href');
                        // if (!$.trim(gourl)) {
                        //     gourl = "<?php echo url('Archives/index_archives'); ?>";
                        // }
                        // body.find('input[name=gourl]').val(gourl);
                    }
                });
            } else {
                layer.alert('至少要新增一个栏目！', {shade:layer_shade, icon: 5, title: false, btn: ['进入栏目管理']}, function(index){
                    layer.close(index);
                    /*左侧菜单焦点定位*/
                    $('.eycms_cont_left .sub-menu a', window.parent.document).removeClass('on');
                    $('#Arctype_index', window.parent.document).addClass('on');
                    /*end*/
                    window.location.href = "<?php echo url('Arctype/index'); ?>";
                });
            }
        }
    </script>
            </div>
            <form class="navbar-form form-inline" id="searchForm" action="<?php echo url('Article/index'); ?>" method="get" onsubmit="layer_loading('正在处理');">
                <?php echo (isset($searchform['hidden']) && ($searchform['hidden'] !== '')?$searchform['hidden']:''); ?>
                <div class="sDiv">
                        <div class="sDiv2">  
        <select name="flag" class="select" style="margin:0px 5px;">
            <option value="">--属性--</option>
            <?php if(is_array($archives_flags) || $archives_flags instanceof \think\Collection || $archives_flags instanceof \think\Paginator): $i = 0; $__LIST__ = $archives_flags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['flag_fieldname']; ?>" <?php if(\think\Request::instance()->param('flag') == $vo['flag_fieldname']): ?>selected<?php endif; ?>><?php echo $vo['flag_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
    <?php if(!(empty($global['web_citysite_open']) || (($global['web_citysite_open'] instanceof \think\Collection || $global['web_citysite_open'] instanceof \think\Paginator ) && $global['web_citysite_open']->isEmpty()))): ?>
    <div class="sDiv2">  
        <select name="province_id" id="province_id" class="select" style="margin:0px 5px;" onchange="set_city_list(0);">
            <option value="0">全国</option>
            <?php $_result=get_site_province_list();if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['id']; ?>" <?php if(\think\Request::instance()->param('province_id') == $vo['id']): ?> selected="true" <?php endif; ?>><?php echo $vo['name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <select name="city_id" id="city_id" class="select" style="margin:0px 5px;display: none;" onchange="set_area_list(0);">
            <option value="">--请选择--</option>
        </select>
        <select name="area_id" id="area_id" class="select" style="margin:0px 5px;display: none;">
            <option value="">--请选择--</option>
        </select>
    </div>
    <script type="text/javascript">
        try {
            set_city_list(<?php echo (\think\Request::instance()->param('city_id') ?: 0); ?>);
            set_area_list(<?php echo (\think\Request::instance()->param('area_id') ?: 0); ?>);
        }catch(e){}
        $(document).ready(function(){
            $('#searchForm select[name=province_id],#searchForm select[name=city_id],#searchForm select[name=area_id]').change(function(){
                $('#searchForm').submit();
            });
        });
    </script>
    <?php endif; ?>
                    <div class="sDiv2">
                        <input type="hidden" name="typeid" id="typeid" value="<?php echo (\think\Request::instance()->param('typeid') ?: ''); ?>">
                        <input type="text" size="30" name="keywords" value="<?php echo \think\Request::instance()->param('keywords'); ?>" class="qsbox" placeholder="标题搜索...">
                        <input type="submit" class="btn" value="搜索">
                        <i class="iconfont e-sousuo"></i>
                    </div>
                </div>
            </form>
        </div>
        <div class="hDiv">
            <div class="hDivBox">
                <table cellspacing="0" cellpadding="0" style="width: 100%">
                    <thead>
                    <tr>
                        <th class="sign w40" axis="col0">
                            <div class="tc"><input type="checkbox" class="checkAll" autocomplete="off"></div>
                        </th>
                        <th abbr="article_title" axis="col3" class="w70">
                            <div class="tc">ID</div>
                        </th>
                        <th abbr="article_title" axis="col3" class="">
                            <div style="text-align: left; padding-left: 10px;" class="">标题</div>
                        </th>
                        <!-- <th abbr="article_time" axis="col6" class="w120">
                            <div class="tc">付费限制</div>
                        </th> -->
                        <th abbr="article_time" axis="col6" class="w120">
                            <div class="tc">所属栏目</div>
                        </th>
                        <th abbr="article_time" axis="col6" class="w50">
                            <div class="tc sort_style"><a href="<?php echo getArchivesSortUrl('arcrank'); ?>">审核&nbsp;<i <?php if(\think\Request::instance()->param('orderby') == 'arcrank'): if(\think\Request::instance()->param('orderway') == 'asc'): ?>class="asc"<?php else: ?>class="desc"<?php endif; endif; ?>></i></a></div>
                        </th>
                        <th abbr="article_time" axis="col6" class="w60">
                            <div class="tc">点击</div>
                        </th>
                        <th abbr="article_time" axis="col6" class="w100">
                            <div class="tc">发布时间</div>
                        </th>
                        <th axis="col1" class="w160">
                            <div class="tc">操作</div>
                        </th>
                        <th abbr="article_time" axis="col6" class="w60">
                            <div class="tc sort_style"><a href="<?php echo getArchivesSortUrl('sort_order'); ?>">排序&nbsp;<i <?php if(\think\Request::instance()->param('orderby') == 'sort_order'): if(\think\Request::instance()->param('orderway') == 'asc'): ?>class="asc"<?php else: ?>class="desc"<?php endif; endif; ?>></i></a></div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="bDiv" style="height: auto;">
            <div id="flexigrid" cellpadding="0" cellspacing="0" border="0">
                <table style="width: 100%;">
                    <tbody>
                    <?php if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>
                        <tr>
                            <td class="no-data" align="center" axis="col0" colspan="50">
                                <div class="no_row">
                                    <div class="no_pic"><img src="/public/static/admin/images/null-data.png"></div>
                                </div>
                            </td>
                        </tr>
                    <?php else: if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $k=>$vo): ?>
                        <tr>
                            <td class="sign">
                                <div class="tc w40"><input type="checkbox" name="ids[]" value="<?php echo $vo['aid']; ?>" autocomplete="off"></div>
                            </td>
                           
                            <td class="sort">
                                <div class="tc w70">
                                    <?php echo $vo['aid']; ?>
                                </div>
                            </td>
                            <td class="" style="width: 100%;">
                                <div class="tl" style="padding-left: 10px;">
                                    <?php if(!(empty($vo['is_litpic']) || (($vo['is_litpic'] instanceof \think\Collection || $vo['is_litpic'] instanceof \think\Paginator ) && $vo['is_litpic']->isEmpty()))): ?>
                                        <i class="fa fa-picture-o color_z" onmouseover="layer_tips=layer.tips('<img src=<?php echo $vo['litpic']; ?> class=\'layer_tips_img\'>',this,{tips: [3, '#fff'],skin:'layer-yourskin-mt0'});" onmouseout="layer.close(layer_tips);"></i>
                                    <?php endif; if(is_check_access(CONTROLLER_NAME.'@edit') == '1'): ?>
                                    <a href="<?php echo url('Article/edit',array('id'=>$vo['aid'], 'callback_url'=>$callback_url)); ?>" style="<?php if($vo['is_b'] == '1'): ?> font-weight: bold;<?php endif; ?>"><?php echo $vo['title']; ?></a>
                                    <?php else: ?>
                                    <?php echo $vo['title']; endif; $showArcFlagData = showArchivesFlagStr($vo); if(is_array($showArcFlagData) || $showArcFlagData instanceof \think\Collection || $showArcFlagData instanceof \think\Paginator): $i = 0; $__LIST__ = $showArcFlagData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;if($i == '1'): ?><span style="color: red;">[<?php endif; ?>
                                        <i style="font-size: 12px;"><?php echo $vo1['small_name']; ?></i>
                                        <?php if($i == count($showArcFlagData)): ?>]</span><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </div>
                            </td>
                            <!-- <td class="">
                                <div class="w120 tc">
                                    <span style="display: block;"><?php echo $vo['restric_type_text']; ?></span>
                                    <?php if(1 == $vo['restric_type']): ?>
                                    <span class="red">￥<?php echo $vo['users_price']; ?></span>
                                    <?php elseif(2 == $vo['restric_type']): ?>
                                    <span class="red"><?php echo $vo['arc_level_name']; if(!empty($vo['no_vip_pay']) && !empty($vo['users_price'])): ?>(非会员: ￥<?php echo $vo['users_price']; ?>)<?php endif; ?></span>
                                    <?php elseif(3 == $vo['restric_type']): ?>
                                    <span class="red"><?php echo $vo['arc_level_name']; ?>(￥<?php echo $vo['users_price']; ?>)</span>
                                    <?php endif; ?>
                                </div>
                            </td> -->
                            <td class="">
                                <div class="w120 tc ellipsis"><a href="<?php echo url('Article/index', array('typeid'=>$vo['typeid'], 'tab'=>3)); ?>" title="<?php echo $vo['typename']; ?>"><?php echo (isset($vo['typename']) && ($vo['typename'] !== '')?$vo['typename']:'<i class="red">数据出错！</i>'); ?></a></div>
                            </td>
                            <td>
                                <div class="tc w50">
                                    <?php if($vo['arcrank'] == -1): ?>
                                        <span class="no" <?php if(is_check_access(CONTROLLER_NAME.'@edit') == '1'): ?> data-typeid="<?php echo $vo['typeid']; ?>" data-seo_pseudo="<?php echo (isset($seo_pseudo) && ($seo_pseudo !== '')?$seo_pseudo:'1'); ?>" onclick="changeTableVal('archives','aid','<?php echo $vo['aid']; ?>','arcrank',this);" <?php endif; ?> ><i class="fa fa-ban"></i>否</span>
                                    <?php else: ?>
                                        <span class="yes" <?php if(is_check_access(CONTROLLER_NAME.'@edit') == '1'): ?> data-typeid="<?php echo $vo['typeid']; ?>" data-seo_pseudo="<?php echo (isset($seo_pseudo) && ($seo_pseudo !== '')?$seo_pseudo:'1'); ?>" onclick="changeTableVal('archives','aid','<?php echo $vo['aid']; ?>','arcrank',this);" <?php endif; ?> ><i class="fa fa-check-circle"></i>是</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="tc w60">
                                    <?php echo $vo['click']; ?>
                                </div>
                            </td>
                            <td>
                                <div class="w100 tc">
                                    <?php echo date('Y-m-d',$vo['add_time']); ?>
                                </div>
                            </td>
                            <td class="operation">
                                <div class="w160 tc">
                                    <?php if(is_check_access(CONTROLLER_NAME.'@edit') == '1'): ?>
                                    <a href="<?php echo url('Article/edit',array('id'=>$vo['aid'], 'callback_url'=>$callback_url)); ?>" class="btn blue">编辑</a>
                                    <i></i>
                                    <?php endif; if(is_check_access(CONTROLLER_NAME.'@del') == '1'): ?>
                                    <a class="btn red"  href="javascript:void(0);" data-url="<?php echo url('Article/del'); ?>" data-id="<?php echo $vo['aid']; ?>" <?php if($global['web_recycle_switch'] == '1'): ?> data-deltype="del" <?php else: ?> data-deltype="pseudo" <?php endif; ?> onClick="delfun(this);">删除</a>
                                    <i></i>
                                    <?php endif; ?>
                                    <a href="<?php echo $vo['arcurl']; ?>" target="_blank" class="btn blue">浏览</a>
                                </div>
                            </td>
                             <td class="sort">
                                <div class="w60 tc">
                                    <?php if(is_check_access(CONTROLLER_NAME.'@edit') == '1'): ?>
                                    <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'');" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="changeTableVal('archives','aid','<?php echo $vo['aid']; ?>','sort_order',this);"  size="4"  value="<?php echo $vo['sort_order']; ?>" />
                                    <?php else: ?>
                                    <?php echo $vo['sort_order']; endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="iDiv" style="display: none;"></div>
        </div>
        <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): ?>
        <div class="footer-oper">
            <span class="ml15">
                <input type="checkbox" class="checkAll" autocomplete="off">
            </span>
            <div class="nav-dropup">
                <button class="layui-btn layui-btn-primary dropdown-bt">批量操作<i class="layui-icon layui-icon-up"></i></button>
                <div class="dropdown-menus" style="display:none; <?php if(0 < $pager->totalRows && ($pager->totalRows < 4 || $pager->listRows < 4)): ?>top:28px;bottom:unset;border-bottom:1px solid rgba(0,0,0,.15);border-top:none;min-height: 250px;<?php endif; ?>">
                    <?php if(is_check_access('Archives@batch_attr') == '1'): ?>
                    <a href="javascript:void(0);" onclick="batch_attr(this, 'ids', '批量新增属性');" data-url="<?php echo url('Archives/batch_attr', ['opt'=>'add']); ?>">新增属性</a>
                    <a href="javascript:void(0);" onclick="batch_attr(this, 'ids', '批量删除属性');" data-url="<?php echo url('Archives/batch_attr', ['opt'=>'del']); ?>">删除属性</a>
                    <hr class="layui-bg-gray">
                    <?php endif; if(is_check_access('Archives@batch_copy') == '1'): ?>
                    <a href="javascript:void(0);" onclick="func_batch_copy(this, 'ids');" data-url="<?php echo url('Archives/batch_copy', array('typeid'=>\think\Request::instance()->param('typeid'))); ?>">复制文档</a>
                    <?php endif; if(is_check_access('Archives@move') == '1'): ?>
                    <a href="javascript:void(0);" onclick="func_move(this, 'ids');" data-url="<?php echo url('Archives/move', array('typeid'=>\think\Request::instance()->param('typeid'))); ?>">移动文档</a>
                    <?php endif; if(is_check_access(CONTROLLER_NAME.'@del') == '1'): ?>
                    <a href="javascript:void(0);" onclick="batch_del(this, 'ids');" data-url="<?php echo url('Article/del'); ?>" <?php if($global['web_recycle_switch'] == '1'): ?> data-deltype="del" <?php else: ?> data-deltype="pseudo" <?php endif; ?>>删除文档</a>
                    <?php endif; if(is_check_access('Archives@check') == '1'): ?>
                    <hr class="layui-bg-gray">
                    <a href="javascript:void(0);" onclick="batch_check(this, 'ids');" data-type="check" data-url="<?php echo url('Archives/check'); ?>">审核文档</a>
                    <a href="javascript:void(0);" onclick="batch_check(this, 'ids');" data-type="uncheck" data-url="<?php echo url('Archives/uncheck'); ?>">取消审核</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if(is_check_access('RecycleBin@archives_index') == '1'): if($global['web_recycle_switch'] != '1'): ?><a href="<?php echo url('RecycleBin/archives_index'); ?>" class="layui-btn layui-btn-primary" title="回收站">回收站</a><?php endif; endif; ?>
            <div class="fbuttonr">
    <div class="pages">
       <?php echo $page; ?>
    </div>
</div>
<div class="fbuttonr">
    <div class="total">
        <h5>共有<?php echo (isset($pager->totalRows) && ($pager->totalRows !== '')?$pager->totalRows:0); ?>条,每页显示
            <select name="pagesize" style="width: 60px;" onchange="ey_selectPagesize(this);">
                <option <?php if($pager->listRows == 20): ?> selected <?php endif; ?> value="20">20</option>
                <option <?php if($pager->listRows == 50): ?> selected <?php endif; ?> value="50">50</option>
                <option <?php if($pager->listRows == 100): ?> selected <?php endif; ?> value="100">100</option>
                <option <?php if($pager->listRows == 200): ?> selected <?php endif; ?> value="200">200</option>
            </select>
        </h5>
    </div>
</div>
        </div>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('input[name*=ids]').click(function(){
            if ($('input[name*=ids]').length == $('input[name*=ids]:checked').length) {
                $('.checkAll').prop('checked','checked');
            } else {
                $('.checkAll').prop('checked', false);
            }
        });
        $('input[type=checkbox].checkAll').click(function(){
            $('input[type=checkbox]').prop('checked',this.checked);
        });
    });
    
    $(document).ready(function(){

        // 表格行点击选中切换
        $('#flexigrid > table>tbody >tr').click(function(){
            $(this).toggleClass('trSelected');
        });

        // 点击刷新数据
        $('.fa-refresh').click(function(){
            location.href = location.href;
        });

        // 批量操作
        $(".dropdown-bt").click(function(){
            $(".dropdown-menus").slideToggle(200);
            event.stopPropagation();
        })
        $(document).click(function(){
            $(".dropdown-menus").slideUp(200);
            event.stopPropagation();
        })
    });

    var aids = '';
    function func_move(obj, name)
    {
        var a = [];
        var k = 0;
        aids = '';
        $('input[name^='+name+']').each(function(i,o){
            if($(o).is(':checked')){
                a.push($(o).val());
                if (k > 0) {
                    aids += ',';
                }
                aids += $(o).val();
                k++;
            }
        })
        if(a.length == 0){
            layer.alert('请至少选择一项', {
                shade: layer_shade,
                area: ['480px', '190px'],
                move: false,
                title: '提示',
                btnAlign:'r',
                closeBtn: 3,
                success: function () {
                      $(".layui-layer-content").css('text-align', 'left');
                  }
            });
            return;
        }

        var url = $(obj).attr('data-url');
        //iframe窗
        layer.open({
            type: 2,
            title: '移动文档',
            fixed: true, //不固定
            shadeClose: false,
            shade: layer_shade,
            maxmin: false, //开启最大化最小化按钮
            area: ['480px', '360px'],
            content: url
        });
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