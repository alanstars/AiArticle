<?php
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海口快推科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: 陈风任 <491085389@qq.com>
 * Date: 2019-1-7
 */

namespace app\common\model;

use think\Db;

/**
 * 小程序插件配置列表模型
 */
load_trait('controller/Jump');
class WeappAppletsConfigList
{
    use \traits\controller\Jump;

    // 构造函数
    public function __construct()
    {
        $this->times = getTime();
        $this->appletsConfigListDb = Db::name('weapp_applets_config_list');
    }

    // 小程序列表
    public function getAppletsConfigList()
    {
        $where = [];
        $list = $this->appletsConfigListDb->where($where)->order('add_time asc, applets_id asc')->select();
        foreach ($list as $key => $value) {
            $value['applets_config'] = !empty($value['applets_config']) ? unserialize($value['applets_config']) : [];
            $value['applets_type_name'] = '';
            // 微信小程序
            if (1 === intval($value['applets_type'])) {
                $value['applets_type_name'] = '微信小程序';
            }
            // 百度小程序
            else if (2 === intval($value['applets_type'])) {
                $value['applets_type_name'] = '百度小程序';
            }
            // 抖音小程序
            else if (3 === intval($value['applets_type'])) {
                $value['applets_type_name'] = '抖音小程序';
            }
            $list[$key] = $value;
        }
        // 返回数据
        return [
            'list' => $list,
        ];
    }

    // 小程序详情
    public function getAppletsConfigDetails($applets_id = 0, $applets_mark = '')
    {
        empty($applets_id) && $this->error('请选择编辑的小程序');
        $where = [
            'applets_id' => intval($applets_id)
        ];
        if (!empty($applets_mark)) $where['applets_mark'] = trim($applets_mark);
        $config = $this->appletsConfigListDb->where($where)->find();
        $config['applets_config'] = !empty($config['applets_config']) ? unserialize($config['applets_config']) : [];
        // 返回数据
        return [
            'config' => $config,
        ];
    }

    // 添加小程序
    public function updateSaveAppletsConfig($post = [], $save = 'insert')
    {
        // 基础判断
        empty($post['applets_type']) && $this->error('请选择小程序类型');
        empty($post['applets_name']) && $this->error('请填写小程序名称');
        // 小程序类型标识
        $appletsMark = '';
        // 小程序配置信息
        $appletsConfig = '';
        // 微信小程序
        if (1 === intval($post['applets_type'])) {
            // 获取标识和配置信息
            $appletsMark = 'weixin';
            $appletsConfig = !empty($post[$appletsMark]) ? $post[$appletsMark] : '';
            empty($appletsConfig) && $this->error('请填写微信小程序必填参数');
            empty($appletsConfig['appid']) && $this->error('请填写AppID');
            empty($appletsConfig['appsecret']) && $this->error('请填写AppSecret');
            // 验证 appid 和 appsecret 的真实性(用于登录)
            $this->verifyWeixinConfig($appletsConfig, 'token');
            // 验证 appid 和 mchid 和 apikey 的真实性(用于支付)
            if (!empty($appletsConfig['mchid']) && !empty($appletsConfig['apikey'])) $this->verifyWeixinConfig($appletsConfig, 'pay');
        }
        // 百度小程序
        else if (2 === intval($post['applets_type'])) {
            $appletsMark = 'baidu';
            $appletsConfig = !empty($post[$appletsMark]) ? $post[$appletsMark] : '';
            empty($appletsConfig) && $this->error('请填写微信小程序必填参数');
            empty($appletsConfig['appid']) && $this->error('请填写AppID');
            empty($appletsConfig['appkey']) && $this->error('请填写AppKey');
            empty($appletsConfig['appsecret']) && $this->error('请填写AppSecret');
            // 验证 appkey 和 appsecret 的真实性(用于登录)
            $this->verifyBaiduConfig($appletsConfig, 'token');
        }
        // 抖音小程序
        else if (3 === intval($post['applets_type'])) {
            $appletsMark = 'toutiao';
            $appletsConfig = !empty($post[$appletsMark]) ? $post[$appletsMark] : '';
            empty($appletsConfig) && $this->error('请填写微信小程序必填参数');
            empty($appletsConfig['appid']) && $this->error('请填写AppID');
            empty($appletsConfig['appsecret']) && $this->error('请填写AppSecret');
            // 验证 appid 和 appsecret 的真实性(用于登录)
            $this->verifyToutiaoConfig($appletsConfig, 'token');
            // 验证 appid 和 salt 的真实性(用于支付)
            if (!empty($appletsConfig['appid']) && !empty($appletsConfig['salt'])) $this->verifyToutiaoConfig($appletsConfig, 'pay');
        }
        // 新增小程序配置信息
        if ('insert' == $save) {
            $insert = [
                'applets_type' => intval($post['applets_type']),
                'applets_mark' => !empty($appletsMark) ? trim($appletsMark) : '',
                'applets_name' => trim($post['applets_name']),
                'applets_config' => !empty($appletsConfig) ? serialize($appletsConfig) : '',
                'add_time' => $this->times,
                'update_time' => $this->times,
            ];
            $result = $this->appletsConfigListDb->insertGetId($insert);
            if (!empty($result)) $this->success('添加成功');
        }
        // 更新小程序配置信息
        else if ('update' == $save) {
            $where = [
                'applets_id' => intval($post['applets_id']),
                'applets_type' => intval($post['applets_type']),
            ];
            $update = [
                'applets_name' => trim($post['applets_name']),
                'applets_config' => !empty($appletsConfig) ? serialize($appletsConfig) : '',
                'update_time' => $this->times,
            ];
            $result = $this->appletsConfigListDb->where($where)->update($update);
            if (!empty($result)) $this->success('更新成功');
        }

        $this->error('操作失败');
    }

    // 删除小程序
    public function delAppletsConfig($post = [])
    {
        if (!empty($post['applets_id'])) {
            $where = [
                'applets_id' => intval($post['applets_id']),
            ];
            $result = $this->appletsConfigListDb->where($where)->delete(true);
            !empty($result) && $this->success('删除成功');
        }
        $this->error('删除失败');
    }

    // 验证微信配置
    private function verifyWeixinConfig($config = [], $type = '')
    {
        if ('token' == trim($type)) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$config['appid']."&secret=".$config['appsecret'];
            $result = json_decode(httpRequest($url), true);
            if (!empty($result['errcode'])) {
                if ($result['errcode'] == 40164) {
                    preg_match_all('#(\d{1,3}\.){3}\d{1,3}#i', $result['errmsg'], $matches);
                    $ip = !empty($matches[0][0]) ? $matches[0][0] : '';
                    $ipTips = "<font color='red'>请将IP: {$ip} 加入微信小程序的IP白名单里！</font>";
                    $this->error($ipTips);
                } else {
                    if (stristr($result['errmsg'], 'appid')) {
                        $result['errmsg'] = '小程序AppID配置不正确';
                    } else if (stristr($result['errmsg'], 'appsecret')) {
                        $result['errmsg'] = '小程序AppSecret配置不正确';
                    } 
                    $this->error($result['errmsg']);
                }
            }
        }
        else if ('pay' == trim($type)) {
            $result = model('ShopPublicHandle')->getWechatAppletsPay('', $this->times, 1, 2, $config);
            if ($result['return_code'] == 'FAIL' && !empty($result['return_msg'])) $this->error($result['return_msg']);
        }
    }

    // 验证抖音配置
    private function verifyToutiaoConfig($config = [], $type = '')
    {
        if ('token' == trim($type)) {
            $result = getToutiaoAccessToken($config['appid'], $config['appsecret'], $config['salt'], false);
            if (empty($result['code'])) $this->error($result['msg']);
        }
        else if ('pay' == trim($type)) {
            $tikTokModel = new \app\common\model\TikTok($config);
            $result = $tikTokModel->getTikTokAppletsPay(1, $this->times, 1, 1);
            if (empty($result['success'])) $this->error($result['err_tips']);
        }
    }

    // 验证百度配置
    private function verifyBaiduConfig($config = [], $type = '')
    {
        if ('token' == trim($type)) {
            $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id={$config['appkey']}&client_secret={$config['appsecret']}&scope=smartapp_snsapi_base";
            $result = json_decode(httpRequest($url), true);
            if (empty($result['access_token']) && !empty($result['error']) && !empty($result['error_description'])) {
                if (stristr($result['error_description'], 'client id')) {
                    $result['error_description'] = '百度AppKey配置不正确';
                } else if (stristr($result['error_description'], 'authentication')) {
                    $result['error_description'] = '百度AppSecret配置不正确';
                }
                $this->error($result['error_description']);
            }
        }
        else if ('pay' == trim($type)) {

        }
    }
}