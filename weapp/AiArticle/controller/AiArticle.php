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
 * Date: 2018-06-28
 */

namespace weapp\AiArticle\controller;

use think\Page;
use think\Db;
use app\common\controller\Weapp;
use weapp\AiArticle\logic\AiArticleLogic;
use weapp\AiArticle\model\AiArticleModel;

/**
 * 插件的控制器
 */
class AiArticle extends Weapp
{
    /**
     * 实例化模型
     */
    private $model;

    /**
     * 实例化对象
     */
    private $db;
    private $lang;
    private $conf;
    private $articleLists;
    private $langSwitchOn;

    /**
     * 插件基本信息
     */
    private $weappInfo;

    /**
     * 构造方法
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new AiArticleModel;
        $this->db = Db::name('WeappAiArticle');
        $this->conf = Db::name('WeappAiArticleConf');

        /*获取当前系统是否为多语言*/
        $this->langSwitchOn = false;
        if (is_language()) {
            $this->langSwitchOn = true;
        }
        /*--end*/
        /* 获取当前多语言状态 */
        $this->assign('langSwitchOn', $this->langSwitchOn);
        /*获取当前系统语言*/
        $this->lang = $_GET['lang'];
        $this->assign('lang', $this->lang);
        /*插件基本信息*/
        $this->weappInfo = $this->getWeappInfo();
        $this->assign('weappInfo', $this->weappInfo);
        /*--end*/
    }

    /**
     * 插件使用指南
     */
    public function doc()
    {
        return $this->fetch('doc');
    }

    /**
     * 系统内置钩子show方法（没用到这个方法，建议删掉）
     * 用于在前台模板显示片段的html代码，比如：QQ客服、对联广告等
     *
     * @param  mixed  $params 传入的参数
     */
    public function show($params = null)
    {
        $list = $this->db->select();
        $this->assign('list', $list);
        echo $this->fetch('show');
    }

    /**
     * 插件后台管理 - 列表
     */
    public function index()
    {
        echo 111;
        
        $message = request()->get('msg');
        // $message = '我需要你帮我写5篇关于遮阳篷的文章，字数在400字左右';
        $response = $ai->getMessage($message);
        dump($response);
        // echo $response;
        exit;

        $list = array();
        $keywords = input('keywords/s');

        $map = array();
        if (!empty($keywords)) {
            $map['title'] = array('LIKE', "%{$keywords}%");
        }

        $count = $this->db->where($map)->count('id');// 查询满足要求的总记录数
        $pageObj = new Page($count, config('paginate.list_rows'));// 实例化分页类 传入总记录数和每页显示的记录数
        $list = $this->db->where($map)->order('id desc')->limit($pageObj->firstRow . ',' . $pageObj->listRows)->select();
        $pageStr = $pageObj->show(); // 分页显示输出
        $this->assign('list', $list); // 赋值数据集
        $this->assign('pageStr', $pageStr); // 赋值分页输出
        $this->assign('pager', $pageObj); // 赋值分页对象

        return $this->fetch('index');
    }

    /**
     * 插件后台管理 - 新增
     */
    public function add()
    {
        if (IS_POST) {
            $post = input('post.');
            /*组装存储数据*/
            $nowData = array(
                'created_time' => getTime(),
                'updated_time' => getTime(),
            );
            $saveData = array_merge($post, $nowData);
            /*--end*/
            $insertId = $this->db->insert($saveData);
            if (false !== $insertId) {
                adminLog('新增' . $this->weappInfo['name'] . '：' . $post['title']); // 写入操作日志
                $this->success("操作成功", weapp_url('AiArticle/AiArticle/index'));
            } else {
                $this->error("操作失败");
            }
            exit;
        }

        $conf = M('weapp_ai_article_conf')->find();
        if (empty($conf)) {
            $this->error('请先配置插件！', weapp_url('AiArticle/AiArticle/conf'));
            exit;
        }
        $this->assign('conf', $conf);

        //获取eyoucms中为文章模型的所有的栏目列表
        $articleTypeList = Db::name('arctype')->where(array('lang' => $this->lang))->field('id,parent_id,topid,typename,lang')->where('channeltype=1')->select();
        $treeNow = $this->buildTree($articleTypeList, 0);
        //生成 HTML 格式的 select option 列表
        $treeNow = $this->selectTree($treeNow);
        //获取eyoucms中为文章模型的所有的栏目列表结束
        //获取当前系统是否为多语言
        if ($this->langSwitchOn) {
            $articleTypeList2 = Db::name('arctype')->where('lang', 'neq', $this->lang)->field('id,parent_id,topid,typename,lang')->where('channeltype=1')->select();
            $tree = $this->buildTree($articleTypeList2, 0);
            //生成 HTML 格式的 select option 列表
            $tree = $this->selectTree($tree);
            $this->assign('tree', $tree);
        }


        //获取当前系统是否为多语言结束
        $this->assign('articleTypeList', $treeNow);
        return $this->fetch('add');
    }

    /**
     * 插件后台管理 - 编辑
     */
    public function edit()
    {
        if (IS_POST) {
            $post = input('post.');
            $post['id'] = eyIntval($post['id']);
            if (!empty($post['id'])) {

                /*------------这里可以实现存储数据之前的额外逻辑 start-------------*/

                /*处理LOGO的本地上传与远程*/
                $is_remote = !empty($post['is_remote']) ? $post['is_remote'] : 0;
                $logo = '';
                if ($is_remote == 1) {
                    $logo = $post['logo_remote']; // 远程链接
                } else {
                    $logo = $post['logo_local']; // 本地上传链接
                }
                $post['logo'] = $logo;
                /*--end*/

                /*--------------------------------end------------------------------*/

                /*组装存储数据*/
                $nowData = array(
                    'typeid' => empty($post['typeid']) ? 1 : $post['typeid'],
                    'url' => trim($post['url']),
                    'update_time' => getTime(),
                );
                $saveData = array_merge($post, $nowData);
                /*--end*/

                $r = $this->db->where(array('id' => $post['id']))->update($saveData);
                if ($r) {
                    adminLog('编辑' . $this->weappInfo['name'] . '：' . $post['title']); // 写入操作日志
                    $this->success("操作成功!", weapp_url('AiArticle/AiArticle/index'));
                }
            }
            $this->error("操作失败!");
        }

        $id = input('id/d', 0);
        $row = $this->db->find($id);
        if (empty($row)) {
            $this->error('数据不存在，请联系管理员！');
            exit;
        }

        /*同时拥有本地上传与远程URL的逻辑处理*/
        if (is_http_url($row['logo'])) {
            $row['is_remote'] = 1;
            $row['logo_remote'] = $row['logo'];
        } else {
            $row['is_remote'] = 0;
            $row['logo_local'] = $row['logo'];
        }
        /*--end*/

        $this->assign('row', $row);

        return $this->fetch('edit');
    }

    /**
     * 删除文档
     */
    public function del()
    {
        $id_arr = input('del_id/a');
        $id_arr = eyIntval($id_arr);
        if (!empty($id_arr) && IS_POST) {
            $result = $this->db->where("id", 'IN', $id_arr)->select();
            $title_list = get_arr_column($result, 'title');

            $r = $this->db->where("id", 'IN', $id_arr)->delete();
            if ($r !== false) {
                adminLog('删除' . $this->weappInfo['name'] . '：' . implode(',', $title_list));
                $this->success("操作成功!");
            }
        }
        $this->error("操作失败!");
    }

    /**
     * 插件配置添加或者编辑
     */
    public function conf()
    {
        if (IS_POST) {
            $post = input('post.');
            $post['updated_time'] = getTime();
            $text = '编辑';
            // $this->success("操作成功!", weapp_url('AiArticle/AiArticle/conf'),$post);
            if (!empty($post['id'])) {
                $r = M('weapp_ai_article_conf')->where(array('id' => $post['id']))->update($post);
            } else {
                $post['created_time'] = getTime();
                $text = '新增';
                $r = M('weapp_ai_article_conf')->insert($post);
            }
            if ($r) {
                \think\Cache::clear('hooks');
                adminLog($text . $this->weappInfo['name'] . '：插件配置'); // 写入操作日志å
                $this->success("操作成功!", weapp_url('AiArticle/AiArticle/conf'));
            }
            $this->error("操作失败!");
        }

        $row = M('weapp_ai_article_conf')->find();
        $this->assign('row', $row);
        return $this->fetch('conf');
    }


    /**
     * 把一维数组生成带有层级关系的多维数组，需要加入层级关系的字段名
     * 
     *
     * @param array $elements The flat list of categories.
     * @param int $parentId The parent ID to start building the tree from.
     * @return array The tree structure of categories.
     */
    private function buildTree($elements, $parentId = 0, $level = 0)
    {
        $tree = array();
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $element['level'] = $level;
                $children = $this->buildTree($elements, $element['id'], $level + 1);
                if ($children) {
                    $element['children'] = $children;

                }
                $tree[] = $element;
            }
        }
        return $tree;
    }

    /**
     * 把带有层级关系的多维数组，生成 HTML 格式的 select option 列表
     *
     *
     * @param array $tree 多维数组
     *
     * @param int $level 层级
     *
     **/
    private function selectTree($tree, $level = 0)
    {
        $html = '';
        $nbsp = str_repeat('&nbsp;', $level * 4);
        foreach ($tree as $node) {
            $html .= '<option data-lang="' . $node['lang'] . '" value="' . $node['id'] . '">' . $nbsp . $node['typename'] . '</option>';
            if (!empty($node['children'])) {
                $html .= $this->selectTree($node['children'], $level + 1);
            }
        }
        return $html;
    }


}