<?php

namespace Fimatec\Seiren;

class Soap
{
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $token;
    /**
     * @var string
     */
    protected $ns = 'seirentextil.com.br';
    /**
     * @var int
     */
    protected $soaptimeout = 10;
    /**
     * @var int
     */
    protected $soapprotocol = 0;
    /**
     * @var string
     */
    protected $soaperror;
    /**
     * @var array
     */
    protected $soapinfo;

    /**
     * Construtor
     *
     * @param string $token
     * @param string $url
     */
    public function __construct($token, $url)
    {
        $this->token = $token;
        $this->url = $url;
    }

    /**
     * Envia a mensagem a api da SEIREN
     * @param string $msg
     * @param string $operation
     * @return string
     * @throws \Exception
     */
    public function send($msg, $operation)
    {
        $action = "{$this->ns}/{$operation}";
        $envelope = "<soap:Envelope "
            . "xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\""
            . " xmlns:seir=\"{$this->ns}\""
            . ">"
            . "<soap:Header>"
            . "<seir:AuthHeader>"
            . "<seir:Token>{$this->token}</seir:Token>"
            . "</seir:AuthHeader>"
            . "</soap:Header>"
            . "<soap:Body>"
            . $msg
            . "</soap:Body>"
            . "</soap:Envelope>";
        
        $msgSize = strlen($envelope);

        $parameters = [
            "Accept-Encoding: gzip,deflate",
            "Content-Type: application/soap+xml;charset=UTF-8;action=\"{$action}\"",
            "Content-Length: {$msgSize}"
        ];
        try {
            $oCurl = curl_init();
            curl_setopt($oCurl, CURLOPT_URL, $this->url);
            curl_setopt($oCurl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, $this->soaptimeout);
            curl_setopt($oCurl, CURLOPT_TIMEOUT, $this->soaptimeout + 20);
            curl_setopt($oCurl, CURLOPT_HEADER, 1);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, $this->soapprotocol);
            curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($oCurl, CURLOPT_POST, true);
            curl_setopt($oCurl, CURLOPT_POSTFIELDS, $envelope);
            curl_setopt($oCurl, CURLOPT_HTTPHEADER, $parameters);
            $response = curl_exec($oCurl);
            $this->soaperror = curl_error($oCurl);
            $ainfo = curl_getinfo($oCurl);
            if (is_array($ainfo)) {
                $this->soapinfo = $ainfo;
            }
            $headsize = curl_getinfo($oCurl, CURLINFO_HEADER_SIZE);
            $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
            curl_close($oCurl);
            $this->responseHead = trim(substr($response, 0, $headsize));
            $this->responseBody = trim(substr($response, $headsize));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        if ($this->soaperror != '') {
            throw new \Exception($this->soaperror);
        }
        if ($httpcode != 200) {
            throw new \Exception("HTTP Error code: $httpcode - " . $this->getFaultString($this->responseBody));
        }
        return $this->responseBody;
    }

    /**
     * Extract faultstring form response if exists
     *
     * @param string $body
     * @return string
     */
    private function getFaultString($body)
    {
        if (empty($body)) {
            return '';
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($body);
        $faultstring = '';
        $nodefault = !empty($dom->getElementsByTagName('fault')->item(0))
            ? $dom->getElementsByTagName('fault')->item(0)
            : '';
        if (!empty($nodefault)) {
            $faultstring = $nodefault->nodeValue;
        }
        return htmlentities($faultstring, ENT_QUOTES, 'UTF-8');
    }
}
