<?php
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海南赞赞网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: 小虎哥 <1105415366@qq.com>
 * Date: 2018-4-3
 */

namespace weapp\Suibian\logic;

use think\Db;

/**
 * 业务逻辑
 */
class SuibianLogic
{
    // 析构函数
    function  __construct()
    {
        // 当前时间戳
        $this->times = getTime();
        // 广告链接
        $this->ad_link_db = Db::name('weapp_applets_ad_link');
        // 页面路由
        $this->page_paths_db = Db::name('weapp_applets_page_paths');
        // 广告内容
        $this->ad_content_db = Db::name('weapp_applets_ad_content');
        // 广告位
        $this->ad_position_db = Db::name('weapp_applets_ad_position');
    }

    // 获取广告内容链接名称
    public function getAdContentLinkNames($list = [], $terminal = '')
    {
        // 如果为空则返回结束
        if (empty($list)) return $list;

        // 链接ID分组
        $aids = $typeids = $linkids = [];
        foreach ($list as $key => $value) {
            // 商品列表
            if (3 === intval($value['host_id'])) {
                $aids[] = $value['link_id'];
            }
            // 商品分类
            else if (4 === intval($value['host_id'])) {
                $typeids[] = $value['link_id'];
            }
            // 系统内置
            else if (in_array($value['host_id'], [1, 2]) && !empty($value['link_id'])) {
                $linkids[] = $value['link_id'];
            }
        }

        // 商品数据
        $archivesList = !empty($aids) ? Db::name('archives')->where(['aid'=>['IN', $aids]])->getAllWithIndex('aid') : [];
        // 商品分类数据
        $arctypeList = !empty($typeids) ? Db::name('arctype')->where(['id'=>['IN', $typeids]])->getAllWithIndex('id') : [];
        // 系统内置数据
        $linkList = !empty($linkids) ? $this->ad_link_db->where(['link_id'=>['IN', $linkids]])->getAllWithIndex('link_id') : [];

        // 处理数据
        foreach ($list as $key => $value) {
            $value['link_paths'] = '';
            $value['link_names'] = '';
            // 商品列表
            if (3 === intval($value['host_id'])) {
                $value['link_names'] = !empty($archivesList[$value['link_id']]) ? $archivesList[$value['link_id']]['title'] : '';
                if (!empty($archivesList[$value['link_id']])) {
                    if (isWeixinApplets() || (!empty($terminal) && 'applets' == $terminal)) {
                        $value['link_paths'] = "/otherpages/archives/product/view?aid=" . $value['link_id'];
                    } else {
                        $archivesInfo = $archivesList[$value['link_id']];
                        $data = array_merge($archivesList[$archivesInfo['aid']], $archivesInfo);
                        $value['link_paths'] = typeurl("home/Product/view", $data);
                    }
                }
            }
            // 商品分类
            if (4 === intval($value['host_id'])) {
                $value['link_names'] = !empty($arctypeList[$value['link_id']]) ? $arctypeList[$value['link_id']]['typename'] : '';
                if (!empty($arctypeList[$value['link_id']])) {
                    if (isWeixinApplets() || (!empty($terminal) && 'applets' == $terminal)) {
                        $value['link_paths'] = "/pages/category/list?typeid=" . $value['link_id'] . '&typeName=' . $value['link_names'];
                    } else {
                        $value['link_paths'] = typeurl("home/Product/lists", $arctypeList[$value['link_id']]);
                    }
                }
            }
            // 系统内置
            else if (in_array($value['host_id'], [1, 2]) && !empty($value['link_id'])) {
                $value['link_names'] = !empty($linkList[$value['link_id']]) ? $linkList[$value['link_id']]['link_names'] : '';
                if (!empty($linkList[$value['link_id']])) {
                    if (isWeixinApplets() || (!empty($terminal) && 'applets' == $terminal)) {
                        $value['link_paths'] = $linkList[$value['link_id']]['link_paths'];
                    } else {
                        $value['link_paths'] = $linkList[$value['link_id']]['link_url'];
                    }
                }
            }
            if (empty($terminal) || 'applets' != $terminal) $value['link_names'] = @msubstr(checkStrHtml($value['link_names']), 0, 12, true);

            $list[$key] = $value;
        }
        return $list;
    }
}
