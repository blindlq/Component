<?php

namespace JunhaiServer\Http;

use GuzzleHttp\Client;
use JunhaiServer\Http\Builder\Builder;
use JunhaiServer\Http\Builder\DataBuilder;
use JunhaiServer\Http\Builder\ExtraBuilder;
use JunhaiServer\Http\Builder\RequiredBuilder;
use Psr\Http\Message\ResponseInterface;



class Request
{
    /**
     * 请求url地址
     *
     * @var string
     */
    private $url;

    /**
     * 请求方法
     *
     * @var string
     */
    private $method;

    /**
     * 默认请求构建项
     *
     * @var Builder
     */
    private $builders;

    /**
     * 请求参数格式
     *
     * @var array
     */
    private $data_format;

    /**
     *guzzle配置
     *
     * @var array
     */
    private $guzzle_options;

    /**
     * 请求数据
     *
     * @var array
     */
    private $data;

    /**
     * Guzzle Client
     *
     * @var Client
     */
    private $client;

    public function getBuilder()
    {
        return $this->builders;
    }

    public function setBuilder($builders)
    {
        $this->builders = $builders;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = mb_strtoupper($method);
        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setDataFormat($data_format)
    {
        $this->data_format = $data_format;
        return $this;
    }


    public function getDataFormat()
    {
        return $this->data_format;
    }

    public function getGuzzleOptions()
    {
        return $this->guzzle_options;
    }

    public function setClient()
    {
        $this->client = new Client();
    }

    public function getClient()
    {
        return $this->client;
    }

    public function __construct()
    {
        $this->setClient();
    }

    /**
     * @return $this
     * @throws Exceptions\RequiredException
     */
    public function initConfigOptions()
    {
        $required = $this->resolveRequireOptions();
        $extra = $this->resolveExtraOptions();
        $data = $this->resolveDataOptions();

        $this->guzzle_options = array_merge($required,$extra,$data);
        return $this;
    }

    /**
     * @return array
     * @throws Exceptions\RequiredException
     */
    protected function resolveRequireOptions()
    {
        return RequiredBuilder::resolveBuilder($this->builders);
    }

    protected function resolveExtraOptions()
    {
        return ExtraBuilder::resolveBuilder($this->builders);
    }

    protected function resolveDataOptions()
    {

        if (!in_array($this->data_format,Builder::DATA)) {
            $this->data_format = 'form_params';
            $this->method = 'POST';
        }

        $this->data = DataBuilder::format($this->data_format,$this->builders);
        return $this->data;
    }


    public function request()
    {
        return $this->unwrapResponse(
            $this->endpoint($this->getClient(),$this->url,$this->method,$this->guzzle_options)
        );
    }

    public function endpoint($client,$url,$method,$options)
    {
        if ($method === 'GET') {
            return $this->get($client,$url,$options);
        } else {
            return $client->request($method,$url,$options);
        }
    }

    protected function get($client,$url,$options)
    {
        $parse_resource = parse_url($url);
        if (isset($parse_resource['query']) && isset($options['query'])) {
            return $client->request('GET', $url . '&' . http_build_query($options['query']));
        } else {
            return $client->request('GET', $url, ['query' => $options['query']]);
        }
    }

    protected function unwrapResponse(ResponseInterface $response)
    {
        $content_type = $response->getHeaderLine('Content-Type');
        $contents = $response->getBody()->getContents();

        if (false !== stripos($content_type, 'json') || stripos($content_type, 'javascript')) {
            return json_decode($contents, true);
        } elseif (false !== stripos($content_type, 'xml')) {
            return json_decode(json_encode(simplexml_load_string($contents)), true);
        } elseif (!is_null(json_decode($contents, true))) {
            return json_decode($contents, true);
        }

        return $contents;
    }




}