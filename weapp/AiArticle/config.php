<?php

use think\App;
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海南赞赞网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: 小虎哥 <1105415366@qq.com>
 * Date: 2018-06-23
 */


return array(
    'code' => 'AiArticle', // 插件标识
    'name' => 'Ai文章自动更新', // 插件名称
    'version' => 'v1.0.0', // 插件版本号
    'min_version' => 'v1.7.0', // CMS最低版本支持
    'author' => '学乎者也', // 开发者
    'description' => 'Ai 自动生成文章，定时自动更新，支持多语言1', // 插件描述
    'litpic'    => '/weapp/AiArticle/logo.png',
    'scene' => '0',  // 使用场景 0 PC+手机 1 手机 2 PC
    'subroot' => 'on',
    // 'install_target' => '_self',
    'permission' => [],
    'management' => [],
);
