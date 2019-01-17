<?php

namespace JunhaiServer\Http\Builder;

class DataBuilder extends BaseBuilder
{
    /**
     * 设置body
     *
     * @param $body
     * @return array
     */
    public static function setBody(array $body):array
    {
        return [
            'body' => string($body['resources']),
        ];
    }

    /**
     * 设置form_parms
     *
     * @param array $form_prams
     * @return array
     */
    public static function setFormParams(array $form_prams):array
    {
        return [
            'form_params' => $form_prams['resources'],
        ];
    }

    /**
     * 设置json
     *
     * @param array $json
     * @return array
     */
    public static function setJson(array $json):array
    {
        return [
            'json' => $json['resources'],
        ];
    }

    /**
     * 设置multipart
     *
     * @param array $multipart
     * @return array
     */
    public static function setMultipart(array $multipart):array
    {
        return [
            'multipart' => $multipart['resources'],
        ];
    }

    /**
     * 设置query
     *
     * @param array $query
     * @return array
     */
    public static function setQuery(array $query):array
    {
        return [
            'query' => $query['resources'],
        ];
    }

    public static function format(string $data_format, array $data_builder):array
    {
        switch ($data_format) {
            case 'body':
                return static::setBody($data_builder['body']);
                break;
            case 'form_params':
                return static::setFormParams($data_builder['form_params']);
                break;
            case 'json':
                return static::setJson($data_builder['json']);
                break;
            case 'multipart':
                return static::setMultipart($data_builder['multipart']);
                break;
            case 'query':
                return static::setQuery($data_builder['query']);
                break;
            default:
                break;
        }

    }
}
