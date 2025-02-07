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

namespace weapp\AiArticle\logic;

use think\Db;

/**
 * 业务逻辑
 */
class AiArticleLogic
{
    /**
     * 析构函数
     */
    function __construct()
    {

    }

    /**
     * 封装OpenAI的对话接口
     *
     * @param string $apiKey OpenAI API密钥
     * @param string $message 用户输入的消息
     * @param string $model 模型名称，默认为gpt-3.5-turbo
     * @return string 模型生成的回复
     */
    function chatWithOpenAI($apiKey, $message, $model = 'gpt-3.5-turbo')
    {
        // OpenAI API端点
        $url = 'https://api.openai.com/v1/chat/completions';

        // 请求头
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ];

        // 请求体
        $data = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                ['role' => 'user', 'content' => $message],
            ],
        ];

        // 初始化cURL会话
        $ch = curl_init($url);

        // 设置cURL选项
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 执行cURL会话并获取响应
        $response = curl_exec($ch);

        // 检查是否有错误发生
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "Error: " . $error_msg;
        }

        // 关闭cURL会话
        curl_close($ch);

        // 解析响应
        $responseData = json_decode($response, true);

        // 检查响应是否有效
        if (isset($responseData['choices'][0]['message']['content'])) {
            return $responseData['choices'][0]['message']['content'];
        } else {
            return "Error: Unable to get a valid response from OpenAI.";
        }
    }
    /**
     * 查询OpenAI的余额
     *
     * @param string $apiKey OpenAI API密钥
     * @return string 账户余额信息
     */
    function getOpenAIBalance($apiKey)
    {
        // OpenAI API端点
        $url = 'https://api.openai.com/v1/dashboard/billing/credit_grants';

        // 请求头
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ];

        // 初始化cURL会话
        $ch = curl_init($url);

        // 设置cURL选项
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // 执行cURL会话并获取响应
        $response = curl_exec($ch);

        // 检查是否有错误发生
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return "Error: " . $error_msg;
        }

        // 关闭cURL会话
        curl_close($ch);

        // 解析响应
        $responseData = json_decode($response, true);

        // 检查响应是否有效
        if (isset($responseData['data'][0]['total_granted'])) {
            return "Total Granted: " . $responseData['data'][0]['total_granted'] . " | Total Used: " . $responseData['data'][0]['total_used'] . " | Total Available: " . $responseData['data'][0]['total_available'];
        } else {
            return "Error: Unable to get balance information from OpenAI.";
        }
    }
}
