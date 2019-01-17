<?php
/**
 * Created by PhpStorm.
 * User: junhai
 * Date: 2019/1/16
 * Time: 19:13
 */

namespace JunhaiServer\Http\Builder;

final class Builder
{
    /**
     * data类型
     */
    public const DATA = [
        'body',
        'form_params',
        'json',
        'multipart',
        'query'
    ];

    public const REQUIRED_OPTION_KEYS = [
        'allow_redirects',
        'connect_timeout',
        'timeout',
        'version',
        'headers',
    ];

    public const ALLOW_REDIRECTS = [
        'max' => 5,
        'strict' => false,
        'referer' => true,
        'protocols' => ['http', 'https'],
        'track_redirects' => false,
    ];

    public const CONNECT_TIMEOUT = 5.0;

    public const TIMEOUT = 5.0;

    public const VERSION = 1.1;

    public const HEADERS = [];

    public const EXTRA_OPTION_KEYS = [
        'cert',
        'cookies',
        'debug',
        'decode_content',
        'stream',
        'verify',
        'http_errors'
    ];

    public const CERT = null;

    public const COOKIES = null;

    public const DEBUG = false;

    public const DECODE_CONTENT = true;

    public const STREAM = null;

    public const VERIFY = true;

    public const HTTP_ERRORS = true;
}