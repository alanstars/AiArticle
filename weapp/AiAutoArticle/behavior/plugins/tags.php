<?php

// 应用行为扩展定义文件
return array(
    // 模块初始化
    'module_init'  => array(
        'weapp\\AiAutoArticle\\behavior\\plugins\\AiAutoArticleBehavior',
    ),
    // 操作开始执行
    'action_begin' => array(
        'weapp\\AiAutoArticle\\behavior\\plugins\\AiAutoArticleBehavior',
    ),
    // 视图内容过滤
    'view_filter'  => array(
        'weapp\\AiAutoArticle\\behavior\\plugins\\AiAutoArticleBehavior',
    ),
    // 日志写入
    'log_write'    => array(
        'weapp\\AiAutoArticle\\behavior\\plugins\\AiAutoArticleBehavior',
    ),
    // 应用结束
    'app_end'      => array(
        'weapp\\AiAutoArticle\\behavior\\plugins\\AiAutoArticleBehavior',
    ),
);
