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
    //AI 的模型名字
    private $AiModel;
    //调用AI 的具体模型
    private $ChatModel;
    //API 密钥
    private $apiKey;

    /**
     * 析构函数
     * @param string $AiModel AI 的模型名字
     * @param string $ChatModel 调用AI 的具体模型
     * @param string $apiKey API 密钥
     */
    public function __construct($AiModel, $ChatModel, $apiKey)
    {
        $this->AiModel = $AiModel;
        $this->ChatModel = $ChatModel;
        $this->apiKey = $apiKey;
    }
    function getMessage($message)
    {
        switch ($this->AiModel) {
            case 'OpenAI':
                return $this->chatWithOpenAI($message);
                break;
            case 'DeepSeek':
                return $this->chatWithDeepSeek($message);
                break;
            default:
                return "Error: Invalid AI model.";
                break;
        }
    }

    /**
     * 封装DeepSeek的对话接口
     *  https://api-docs.deepseek.com/zh-cn/api/create-chat-completion
     * @param string $apiKey DeepSeek API密钥
     * @param string $message 用户输入的消息
     * @param string $model 模型名称，默认为deepseek-chat
     * @return string 模型生成的回复
     */
    function chatWithDeepSeek($message)
    {
        if (empty($this->ChatModel)) {
            $this->ChatModel = 'deepseek-chat';
        }
        // DeepSeek API端点，需根据实际情况修改
        $url = 'https://api.deepseek.com/v1/chat/completions';

        // 请求头
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];

        // 请求体
        $data = [
            'model' => $this->ChatModel,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => '你是一位经验丰富的 SEO 专家，擅长撰写符合 Google 搜索引擎搜索习惯的文章，以提高文章在 Google 上的收录率和排名。请遵循以下准则撰写文章：
1. 文章内容要围绕用户提供的主题展开，具有深度和专业性，为读者提供有价值的信息。
2. 使用自然、流畅的语言，避免堆砌关键词，但要合理地分布相关关键词，以提高文章的相关性。
3. 文章结构清晰，包含引言、正文和结论，每个部分都要有明确的主题。
4. 采用适当的标题标签（如 H1、H2、H3 等）来组织文章，增强可读性和搜索引擎友好性。
5. 文章长度应根据主题的复杂性和深度来确定，一般不少于 800 字，以提供足够的内容供搜索引擎索引。
6. 注意语法和拼写错误，保证文章的质量。
7. 请严格按照文章格式生成，格式为：【标题开始】(标题)【标题结束】，然后换行，【关键词开始】（SEO关键词，多个使用半角逗号隔开）【关键词结束】，[SEO描述开始]（SEO描述，字数在100字左右）【SEO描述结束】，然后换行，[正文开始]（正文内容）【正文结束】.其中正文使用 HTML 格式，如：<p>正文内容</p>。如果有生成多篇文章，需再最开头加上【多篇文章】,再每一篇的开头加上【第几篇开始】，结尾加上【第几篇结束】。'
                ],
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

        $ch = curl_init($url);
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
        // return $responseData;
        // 检查响应是否有效
        if (isset($responseData['choices'][0]['message']['content'])) {
            $articleContent = $responseData['choices'][0]['message']['content'];
            $result = $this->cleanData($articleContent);
            // return $articleContent;
            return $result;
        } else {
            // 打印错误信息
            return "Error: Unable to get a valid response from DeepSeek.Key:" . $this->apiKey . "Model:" . $this->ChatModel . "AiModel:" . $this->AiModel . "";
        }
    }


    /**
     * 封装OpenAI的对话接口
     *
     * @param string $apiKey OpenAI API密钥
     * @param string $message 用户输入的消息
     * @param string $model 模型名称，默认为gpt-3.5-turbo
     * @return string 模型生成的回复
     */
    function chatWithOpenAI($message)
    {
        if (empty($this->ChatModel)) {
            $this->ChatModel = 'gpt-3.5-turbo';
        }
        // OpenAI API端点
        $url = 'https://api.openai.com/v1/chat/completions';

        // 请求头
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];

        // 请求体
        $data = [
            'model' => $this->AiModel,
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
    
    //清洗数据
    function cleanData($articleContent)
    {
        $result = [];
        if (strpos($articleContent, '【多篇文章】') !== false) {
            // 去除 【多篇文章】 标记
            $articleContent = str_replace('【多篇文章】', '', $articleContent);
            // 匹配所有文章
            $pattern = '/【第(\d+)篇开始】.*?【标题开始】(.*?)【标题结束】.*?【关键词开始】(.*?)【关键词结束】.*?【SEO描述开始】(.*?)【SEO描述结束】.*?(.*?)【第\1篇结束】/s';

            preg_match_all($pattern, $articleContent, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $result[] = [
                    'id' => $match[1], // 文章编号
                    'title' => $match[2], // 标题
                    'keywords' => $match[3], // 关键词
                    'description' => $match[4], // SEO描述
                    'content' => $match[5], // 正文内容
                ];
            }
        
        } else {
            // 单篇文章处理
            preg_match('/【标题开始】(.*?)【标题结束】/', $articleContent, $titleMatches);
            preg_match('/【关键词开始】(.*?)【关键词结束】/', $articleContent, $keywordsMatches);
            preg_match('/【SEO描述开始】(.*?)【SEO描述结束】/', $articleContent, $descriptionMatches);
            preg_match('/【正文开始】(.*?)【正文结束】/s', $articleContent, $contentMatches);

            $title = isset($titleMatches[1]) ? $titleMatches[1] : '';
            $keywords = isset($keywordsMatches[1]) ? $keywordsMatches[1] : '';
            $description = isset($descriptionMatches[1]) ? $descriptionMatches[1] : '';
            $content = isset($contentMatches[1]) ? $contentMatches[1] : '';

            $result[] = [
                'title' => $title,
                'keywords' => $keywords,
                'description' => $description,
                'content' => $content
            ];
        }
        return $result;
    }
}
