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

namespace weapp\AiArticle\model;

use think\Model;
use think\Db;
/**
 * 模型
 */
class ArticleModel extends Model
{
    /**
     * 数据表名，不带前缀
     */

    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }
     /**
     * 后置操作方法
     * 自定义的一个函数 用于数据保存后做的相应处理操作, 使用时手动调用
     * @param int $aid 产品id
     * @param array $post post数据
     * @param string $opt 操作
     */
    public function afterSave($aid, $post, $opt)
    {
        $post['aid'] = $aid;
        $addonFieldExt = !empty($post['addonFieldExt']) ? $post['addonFieldExt'] : array();
        $FieldModel = new \app\admin\model\Field;
        $FieldModel->dealChannelPostData($post['channel'], $post, $addonFieldExt);
        
        // 处理外贸链接
        if (is_dir('./weapp/Waimao/')) {
            $waimaoLogic = new \weapp\Waimao\logic\WaimaoLogic;
            $waimaoLogic->update_htmlfilename($aid, $post, $opt);
        } else {
            $foreignLogic = new \app\admin\logic\ForeignLogic;
            $foreignLogic->update_htmlfilename($aid, $post, $opt);
        }

        // --处理TAG标签
        $this->savetags($aid, $post['typeid'], $post['tags'], $post['arcrank'], $opt,$post['lang']);

        if ('edit' == $opt) {
            // 清空sql_cache_table数据缓存表 并 添加查询执行语句到mysql缓存表
            Db::name('sql_cache_table')->execute('TRUNCATE TABLE '.config('database.prefix').'sql_cache_table');
            model('SqlCacheTable')->InsertSqlCacheTable(true);
        } else {
            // 处理mysql缓存表数据
            if (isset($post['arcrank']) && -1 == $post['arcrank'] /*&& -1 == $post['old_arcrank']*/ && !empty($post['users_id'])) {
                // 待审核
                model('SqlCacheTable')->UpdateDraftSqlCacheTable($post, $opt);
            } else if (isset($post['arcrank'])) {
                // 已审核
                $post['old_typeid'] = intval($post['attr']['typeid']);
                model('SqlCacheTable')->UpdateSqlCacheTable($post, $opt, 'article');
            }
        }
        model('Arctype')->hand_type_count(['aid'=>[$aid]]);//统计栏目文档数量
    }
    
    /**
     *  插入Tags
     *
     * @access    public
     * @param     int  $aid  文档AID
     * @param     int  $typeid  栏目ID
     * @param     string  $tag  tag标签
     * @return    void
     */
    public function savetags($aid = 0, $typeid = 0, $tag = '', $arcrank = 0, $opt = 'add',$lang)
    {
        $tag = strip_tags(htmlspecialchars_decode($tag));

        if ($opt == 'add') {
            $tag = str_replace('，', ',', $tag);
            $tags = explode(',', $tag);
            $tags = array_map('trim', $tags);
            $tags = array_unique($tags);

            foreach($tags as $tag)
            {
                $tag = trim($tag);
                if($tag != stripslashes($tag))
                {
                    continue;
                }
                $this->InsertOneTag($tag, $aid, $typeid,$arcrank,$lang);
            }
        } else if ($opt == 'edit') {
            $this->UpdateOneTag($aid, $typeid, $tag,$arcrank);
        }

        \think\Cache::clear('taglist');
    }

    /**
     *  插入一个tag
     *
     * @access    public
     * @param     string  $tag  标签
     * @param     int  $aid  文档AID
     * @param     int  $typeid  栏目ID
     * @return    void
     */
    private function InsertOneTag($tag, $aid, $typeid = 0, $arcrank = 0,$lang = "")
    {
        $tag = trim($tag);
        if (empty($tag)) {
            return true;
        }
        if (empty($typeid)) {
            $typeid = 0;
        }
        $rs = false;
        $addtime = getTime();
        if(empty($lang)){
            $lang = get_admin_lang();
        }
        $row = Db::name('tagindex')->where([
                'tag'   => $tag,
                'lang'  => $lang,
            ])->find();
        if (empty($row)) {
            $rs = $tid = Db::name('tagindex')->insertGetId([
                'tag' => $tag,
                'typeid' => $typeid,
                'seo_title' => '',
                'seo_keywords' => '',
                'seo_description' => '',
                'total' => 1,
                'weekup' => $addtime,
                'monthup' => $addtime,
                'lang' => $lang,
                'add_time' => $addtime,
                'update_time' => $addtime,
            ]);
        } else {
            $rs = Db::name('tagindex')->where([
                'tag' => $tag,
                'lang' => $lang,
            ])->update([
                'total' => Db::raw('total + 1'),
                'update_time' => $addtime,
                'lang' => $lang,
            ]);
            $tid = $row['id'];
        }

        if ($rs) {
            Db::name('taglist')->insert([
                'tid' => $tid,
                'aid' => $aid,
                'typeid' => $typeid,
                'tag' => $tag,
                'arcrank' => $arcrank,
                'lang' => $lang,
                'add_time' => $addtime,
                'update_time' => $addtime,
            ]);
        }
    }


}