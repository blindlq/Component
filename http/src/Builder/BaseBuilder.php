<?php

namespace JunhaiServer\Http\Builder;

abstract class BaseBuilder
{
    /**
     * 解析设置选项
     *
     * @param $builder_key
     * @return string
     */
    public static function resolveBuilderKey($builder_key)
    {
        $builder_key_arrs = explode("_",$builder_key);

        $builder_name = '';
        foreach ($builder_key_arrs as $builder_key_arr) {
            $builder_name = $builder_name . ucfirst($builder_key_arr);
        }

        return "set{$builder_name}";
    }
}