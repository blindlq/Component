<?php

return [
        'workflows' => [
                'field' => 'step',
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