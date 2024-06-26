<?php

namespace Fimatec\Seiren;

use Fimatec\Seiren\Soap;

class Tools
{
    protected $config;
    protected $soap;
    protected $ns = 'seirentextil.com.br';
    public $lastRequest;
    public $url;

    /**
     * Construtor
     * @param \stdClass $config
     */
    public function __construct(\stdClass $config)
    {
        $this->config = $config;
        $this->url = 'http://romaneio.seirentextil.com.br/homol/wsseirenHomol/wsRomaneio.asmx';
        if ($config->tpamb == 1) {
            $this->url = 'http://romaneio.seirentextil.com.br/RomaneioWS/wsRomaneio.asmx';
        }
        $this->soap = new Soap($this->config->token, $this->url);
    }
    
    /**
     * Busca cores cadastradas na Seiren
     *
     * @return string
     */
    public function cores()
    {
        $operation = "WsCor";
        $msg = "<{$operation} xmlns=\"{$this->ns}\">"
            . "<CNPJ>{$this->config->cnpj}</CNPJ>"
            . "</{$operation}>";
        $this->lastRequest = $msg;
        return $this->soap->send($msg, $operation);
    }
    
    /**
     * Busca artigos cadastrados na Seiren
     *
     * @return string
     */
    public function artigos()
    {
        $operation = "WsArtigo";
        $msg = "<{$operation} xmlns=\"{$this->ns}\">"
            . "<CNPJ>{$this->config->cnpj}</CNPJ>"
            . "</{$operation}>";
        $this->lastRequest = $msg;
        return $this->soap->send($msg, $operation);
    }
    
    /**
     * Consulta os saldos
     *
     * @return string
     */
    public function saldos()
    {
        $operation = "WsConsultaSaldo";
        $msg = "<{$operation} xmlns=\"{$this->ns}\">"
            . "<CNPJ>{$this->config->cnpj}</CNPJ>"
            . "</{$operation}>";
        $this->lastRequest = $msg;
        return $this->soap->send($msg, $operation);
    }
    
    /**
     * Envia romaneio para o webservice
     *
     * @param \stdClass $std
     * @return string
     */
    public function enviaLote(Lote $lote)
    {
        $b64 = base64_encode($lote->render());
        $operation = "WsCadastraLote";
        $msg = "<{$operation} xmlns=\"{$this->ns}\">"
            . "<CNPJ>{$this->config->cnpj}</CNPJ>"
            . "<arquivoByte>{$b64}</arquivoByte>"
            . "</{$operation}>";
        $this->lastRequest = $msg;
        return $this->soap->send($msg, $operation);
    }

    /**
     * Envia lote em formato xml base64
     * @param string $xmlb64
     * @return string
     * @throws \Exception
     */
    public function enviaLoteXml(string $xmlb64)
    {
        $operation = "WsCadastraLote";
        $msg = "<{$operation} xmlns=\"{$this->ns}\">"
            . "<CNPJ>{$this->config->cnpj}</CNPJ>"
            . "<arquivoByte>{$xmlb64}</arquivoByte>"
            . "</{$operation}>";
        $this->lastRequest = $msg;
        return $this->soap->send($msg, $operation);
    }
}
