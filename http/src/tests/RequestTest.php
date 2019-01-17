<?php

namespace JunhaiServer\Http;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testSetMethod()
    {
        $request = new Request();

        $request->setMethod("POST");

        $this->assertSame("POST", $request->getMethod());
    }

    public function testSetUrl()
    {
        $request = new Request();
        $request->setUrl("https://www.baidu.com");

        $this->assertSame("https://www.baidu.com", $request->getUrl());
    }

    public function testDataFormat()
    {
        $request = new Request();
        $request->setDataFormat("body");

        $this->assertSame("body", $request->getDataFormat());
    }

    public function testSetOptions()
    {
        $builders = json_decode('
        {
        "method":"POST",
        "uri":{"static":null,"dynamic":null},
        "options":{
            "allow_redirects":{"is_allow":true,"max":10,"strict":true,"referer":true,"protocols":["http","https"],"track_redirects":true},
            "connect_timeout":{"connect_timeout":5},
            "timeout":{"timeout":5},
            "version":{"version":1.1},
            "headers":{"Accept":"application/json","User-Agent":"junhai/server"},
            "body":{"is_on":false,"type":"string","resources":"string"},
            "form_params":{"is_on":false,"content_type":"application/x-www-form-urlencoded","resources":null},
            "json":{"is_on":false,"content_type":"application/json","resources":null},
            "multipart":{"is_on":false,"content_type":"multipart/form-data","resources":null},
            "query":{"is_on":false,"resources":null},
            "cert":{"is_on":false,"path":"string","password":null},
            "cookies":{"is_on":false,"jar":null},
            "debug":{"is_on":false},
            "decode_content":{"is_on":true,"decode_content":"gzip"},
            "stream":{"is_on":false},
            "verify":{"is_on":false,"ssl_cafile":null},
            "http_errors":{"is_on":false}}}', true);

        $request = new Request();
        $request->setBuilder($builders["options"]);

        $this->assertSame($builders["options"], $request->getBuilder());
    }

}