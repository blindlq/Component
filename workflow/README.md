#工作流组件
##使用方法

* composer配置

```



```


* Laravel中使用

在 app/config中的providers数组内添加

```
JunhaiServer\Workflow\Laravel\WorkflowServiceProvider::class
```

在项目根目录下执行命令

```
php artisan vendor:publish --provider='JunhaiServer\Workflow\Laravel\WorkflowServiceProvider' --tag="config"
```

按照项目本身需要设置工作流

```
<?php

return [
        'workflows' => [//工作流名称
                'field' => 'step',//工作流状态字段
                //工作流的状态数组
                'places' => [
                    'draft',
                    'review',
                    'rejected',
                    'published',
                ],
                //状态过渡
                'transitions' => [
                    'to_review'=> [//过渡名
                        'form' => 'draft',//过渡起始状态（位置）
                        'to' => 'review',//过渡终点位置
                    ],
                    'publish'=> [
                        'form' => 'review',
                        'to' => 'published',
                    ],
                    'reject'=> [
                        'form' => 'review',
                        'to' => 'rejected',
                    ],
                ],
            ],


];
```

使用方式

```
    $workflow = app('workflow');
    $work->step = 'draft';
    //判断工作流在那个过渡阶段
    $workflow->can($work,'to_review');//True
    $workflow->can($work,'publish')//False
    //由当前状态根据过渡进入下一个状态
    $workflow->apply($work,'to_review');//此时work对象的step属性变为review
    
    $workflow->apply($work,'publish');//报错误异常
```