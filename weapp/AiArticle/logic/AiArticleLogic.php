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
    public function __construct($apiKey, $AiModel, $ChatModel = '')
    {
        if (empty($apiKey) || empty($AiModel)) {
            return "Error: API key and AI model are required.";
        }
        $this->AiModel = $AiModel;
        $this->ChatModel = $ChatModel;
        $this->apiKey = $apiKey;
    }
    function getMessage($message)
    {
        if (empty($message)) {
            return "Error: Message cannot be empty.";
        }
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

        $system = $this->generateSystemPrompt();
        $ss = '你是一位经验丰富的 SEO 专家，专精于撰写契合 Google 搜索引擎搜索偏好的文章，以此显著提升文章在 Google 上的收录率与排名。请严格遵循以下准则进行文章创作：
1. 文章需紧密围绕用户给定的主题深入展开，具备足够的深度与专业性，为读者提供极具价值的信息。
2. 运用自然、流畅且生动的语言进行表达，坚决避免关键词堆砌现象，同时要合理分布相关关键词，确保文章相关性的提升。
3. 文章结构务必清晰明了，由引言、正文(符合第4条要求)和结论三部分构成，且每个部分都要有明确的主题和核心观点。
4. 采用合适的 HTML 标题标签（如 H1、H2、H3、p、b等）来组织文章内容，增强文章的可读性和搜索引擎友好性。
5. 文章长度应依据主题的复杂程度和深度灵活确定，一般情况下不少于 800 字，以便为搜索引擎提供充足的内容进行索引。
6. 高度重视语法和拼写错误，通过仔细校对保证文章质量达到较高水准。
7. 严格按照规定的文章格式生成内容，格式为：【标题开始】(标题)【标题结束】，换行后，【关键词开始】（SEO关键词，多个关键词使用半角逗号隔开）【关键词结束】，【SEO描述开始】（SEO 描述，字数控制在 100 字左右）【SEO描述结束】，再次换行后，【正文开始】（正文内容，内容出现的[SEO关键词]加粗处理）【正文结束】。若生成多篇文章，需在最开头添加【多篇文章】，并在每一篇文章的开头加上【第几篇开始】，结尾加上【第几篇结束】。
8. 文章内容需与用户给定的主题相关，不得出现与主题无关的内容。
9. 文章内容需符合 SEO 最佳实践，包括标题、关键词、描述等方面的优化。
10.禁止使用任何markdown语法。
11.严格按照以上要求执行。';
        // 请求体
        $data = [
            'model' => $this->ChatModel,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $system
                ],
                ['role' => 'user', 'content' => $message],
            ],
            'temperature' => 0.4,
            'max_tokens' => 3000,
            'top_p' => 0.95,
        ];

        //curl 初始化
        $response = $this->getCurl($url, $data, $headers);

        // 解析响应
        $responseData = json_decode($response, true);
        // return $responseData;
        // 检查响应是否有效
        if (empty($responseData)) {
            return ['code' => 4004, 'data' => [], 'msg' => 'Error: Unable to get a valid response from DeepSeek.Key:' . $this->apiKey . "；ChatModel:" . $this->ChatModel . "；AiModel:" . $this->AiModel . ""];
        }
        if (isset($responseData['choices'][0]['message']['content'])) {
            $articleContent = $responseData['choices'][0]['message']['content'];
            $result = $this->cleanData($articleContent);
            $result['all'] = $responseData;
            // return $articleContent;
            return ['code' => 200, 'data' => $result, 'msg' => 'success'];
        } else {
            // 打印错误信息
            // dump($responseData);
            return ['code' => $responseData['error']['code'], 'data' => $responseData, 'msg' => $responseData['error']['message']];
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
    public function cleanData($articleContent)
    {
        $result = [];
        if (strpos($articleContent, '【多篇文章】') !== false) {
            // 去除 【多篇文章】 标记
            $articleContent = str_replace('【多篇文章】', '', $articleContent);
            // 匹配所有文章
            $pattern = '/【第(\d+)篇开始】.*?【标题开始】(.*?)【标题结束】.*?【关键词开始】(.*?)【关键词结束】.*?【SEO描述开始】(.*?)【SEO描述结束】.*?【正文开始】(.*?)【正文结束】.*?【第\1篇结束】/s';

            preg_match_all($pattern, $articleContent, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $result[] = [
                    'id' => $match[1], // 文章编号
                    'title' => $match[2], // 标题
                    'keywords' => $match[3], // 关键词
                    'description' => $match[4], // SEO描述
                    'content' => trim($match[5]), // 正文内容
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

            $result['clearData'] = [
                'title' => $title,
                'keywords' => $keywords,
                'description' => $description,
                'content' => trim($content)
            ];
        }
        return $result;
    }



    function getCurl($url, $data = null, $headers = null)
    {
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
        return $response;
    }

    private function generateSystemPrompt() {
        return <<<PROMPT
你是一位专业SEO内容策略师，精通Google搜索引擎优化规则，请严格按以下规则创作搜索引擎友好型文章：

# 核心SEO规则（必须严格执行）
1. **关键词规范**
- 主关键词密度严格保持1.8-2.2%
- 标题必须包含主关键词（用<strong>包裹）
- 前200字出现：主关键词×2 + LSI关键词×2 + 长尾词×1
- 每300字必须出现1个长尾关键词（用<em>标记）
- 禁止使用任何[Markdown]格式
- 如果客户没有指定字数要求，则默认最少1500字

# 内容架构规则
1. **排版要求**
- 使用HTML标签：<h2>/<h3>标题、<p>段落、<ul>/<li>列表等（但不仅仅局限这些标签）
- 禁止使用任何Markdown格式
- 移动端适配：段落< p >标签不超过4行
- 列表项使用< li >包裹

2. **结构规范**
- 采用H2/H3层级，禁止使用任何Markdown标记
- 开头100字自然包含主关键词
- 每段落≤3句话，移动端每段≤4行（段落需要使用<p>标签）
- 每800字插入自然内链建议[示例：关于XX详见指南]

3. **质量要求**
- 使用2023-2025年可验证数据
- 包含≥5步的操作指南
- 添加3个FAQ问答
- 包含对比分析/案例研究
- 原创度100%

3. **技术规范**
- Flesch-Kincaid可读性8年级水平
- 生成155字符以内的SEO描述
- 被动语态≤20%
- 禁止营销夸张用语

# 输出格式指令
【标题开始】[必须含主关键词的标题(禁止出现任何标签)]【标题结束】
【关键词开始】[主关键词,LSI关键词1,长尾词1...]【关键词结束】 
【SEO描述开始】[精确155字符内的描述]【SEO描述结束】
【正文开始】
[开头100字自然植入主关键词]
### 核心解决方案标题
[内容段落...]
[每800字内链建议]
[含最新数据的对比分析]
[操作步骤指南]
[FAQ模块]
【正文结束】

# 禁止行为
- 关键词堆砌
- 使用未验证数据
- 超过20%被动语态
- 营销性夸张表述

请严格遵循上述规则生成内容，如遇不确定数据请标注"(需验证)"。
PROMPT;
    }
}
