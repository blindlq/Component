<?php

namespace JunhaiServer\Http\Builder;

class ExtraBuilder extends BaseBuilder
{
    public static function resolveBuilder(array $builders=[]):array
    {
        $builder = [];

        foreach (Builder::EXTRA_OPTION_KEYS as $extra) {
            if (isset($builders[$extra]) && $builders[$extra]['is_on'] == true) {
                $function_name = static::resolveBuilderKey($extra);
                $builder[$extra] = static::$function_name($builders[$extra]);
            }
        }

        return $builder;
    }

    /**
     * 设置cert
     *
     * @param array $builder
     * @return array
     */
    public static function setCert(array $builder):array
    {
        return [
            'cert' => [
                $builder['path'] ?? '',
                $builder['password'] ?? '',
            ]
        ];
    }

    /**
     * 设置cookies
     *
     * @param array $builder
     * @return array
     */
    public static function setCookies(array $builder):array
    {
        return [
            'cookie' => null
        ];
    }

    /**
     * 设置debug
     *
     * @param array $builder
     * @return array
     */
    public static function setDebug(array $builder):array
    {
        $debug = $builder['debug'] ?? Builder::DEBUG ;
        return [
            'debug' => (bool)$debug,
        ];
    }

    /**
     * 设置decodeContent
     *
     * @param array $builder
     * @return string
     */
    public static function setDecodeContent(array $builder):bool
    {
        return $builder['decode_content'] ?? Builder::DECODE_CONTENT ;
    }

    /**
     * 设置stream
     *
     * @param array $builder
     * @return bool
     */
    public static function setStream(array $builder):bool
    {
        return $builder['verify'] ?? Builder::VERIFY ;
    }

    /**
     * 设置httpErrors
     *
     * @param array $builder
     * @return bool
     */
    public static function  setHttpErrors(array $builder):bool
    {
        return $builder['http_errors'] ?? Builder::HTTP_ERRORS ;
    }
}