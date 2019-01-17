<?php

namespace JunhaiServer\Http\Builder;

use JunhaiServer\Http\Exceptions\RequiredException;

class RequiredBuilder extends Base
{
    /**
     * 解析builder
     *
     * @param array $builders
     * @return array
     * @throws RequiredException
     */
    public static function resolveBuilder(array $builders=[]):array
    {
        $builder = [];
        foreach (Builder::REQUIRED_OPTION_KEYS as $required) {
            if (isset($builders[$required])) {
                $function_name = static::resolveBuilderKey($required);
                $builder[$required] = static::$function_name($builders[$required]);
            } else {
                throw new RequiredException("必须配置项{$required}不存在",100);
            }
        }

        return $builder;
    }


    public static function setAllowRedirects(array $builder=[]):array
    {
        if (!$builder) {
            return Builder::ALLOW_REDIRECTS ;
        }

        if (isset($builder['is_allow']) && $builder['is_allow'] === false) {
            return [];
        }

        $_builder = [];
        //strict: (bool, 默认为false) 设置成 true
        // 使用严格模式重定向 严格RFC模式重定向表示使用POST请求重定向POST请求
        // 大部分浏览器使用GET请求重定向POST请求
        $_builder['strict'] = Builder::ALLOW_REDIRECTS["strict"];
        if (isset($builder['strict']) && is_bool($builder['strict'])) {
            $_builder['strict'] = $builder['strict'];
        }
        //referer: (bool, 默认为true) 设置成 false
        // 重定向时禁止添加Refer头信息
        $_builder['referer'] = Builder::ALLOW_REDIRECTS["referer"];
        if (isset($builder['referer']) && is_bool($builder['referer'])) {
            $_builder['referer'] = $builder['referer'];
        }

        //track_redirects: (bool) 当设置成 true 时，每个重定向的URI将会按序被跟踪头信息
        $_builder['track_redirects'] = Builder::ALLOW_REDIRECTS["track_redirects"];
        if (isset($builder['track_redirects']) && is_bool($builder['track_redirects'])) {
            $_builder['track_redirects'] = $builder['track_redirects'];
        }

        //max: (int, 默认为5) 允许重定向次数的最大值
        $_builder['max'] = Builder::ALLOW_REDIRECTS["max"];
        if (isset($builder['max']) && $builder['max']) {
            $_builder['max'] = $builder['max'];
        }

        $_builder['protocols'] = Builder::ALLOW_REDIRECTS["protocols"];
        if (isset($builder['protocols']) && is_array($builder['protocols'])) {
            $_builder['protocols'] = $builder['protocols'];
        }

        return $_builder;
    }

    /**
     * 设置连接超时时间
     *
     * @param $builder
     * @return float
     */
    public static function setConnectTimeout(array $builder):int
    {
        $connect_time = Builder::CONNECT_TIMEOUT;;

        if (isset($builder['connect_timeout'])) {
            if ($builder['connect_timeout'] < 5) {
                $connect_time = $builder['connect_timeout'];
            }
        }

        return intval($connect_time);
    }

    /**
     *设置请求超时时间
     *
     * @param array $builder
     * @return string
     */
    public static function setTimeout(array $builder):int
    {
        $time_out = Builder::TIMEOUT;

        if (isset($builder['timeout'])) {
            if ($builder['timeout'] < 5) {
                $time_out = $builder['timeout'];
            }
        }

        return intval($time_out);
    }

    /**
     * 设置http版本
     *
     * @param array $builder
     * @return int
     */
    public static function setVersion(array $builder):int
    {
        $version = Builder::VERSION;

        if (isset($builder['version'])) {
            $version = $builder['version'];
        }

        return intval($version);
    }

    /**
     * 设置请求头
     *
     * @param array $builder
     * @return array
     */
    public static function setHeaders(array $builder):array
    {
        return $builder;
    }
}