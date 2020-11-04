<?php

namespace Fimatec\Seiren;

class Standardize
{
    protected $rootTagList = [
        'artigos',
        'cors',
        'cores',
        'retornos'
    ];
    protected $json;
    protected $node;
    protected $std;
    protected $key;
    protected $errors;
    
    public function __construct()
    {
        $this->errors = json_decode(
            file_get_contents(__DIR__ . '/../storage/errors.json'),
            true
        );
    }

    public function toStd($xml = null)
    {
        $xml = str_replace(' xmlns="seirentextil.com.br"', '', $xml);
        if (empty($xml)) {
            return null;
        }
        $this->whichIs($xml);
        $sxml = simplexml_load_string($this->node);
        $this->json = str_replace(
            '@attributes',
            'attributes',
            json_encode($sxml, JSON_PRETTY_PRINT)
        );
        $std = json_decode($this->json);
        //return $std;
        $func = 'translate' . ucfirst($this->key);
        return $this->$func($std);
    }
    
    protected function translateArtigos(\stdClass $std)
    {
        $resp = [];
        foreach ($std->Artigo as $item) {
            $resp[] = (object) [
                'codigo' => $item->DC_Artigo,
                'largura' => $item->NR_Largura,
                'gramatura' => $item->NR_Gramatura
            ];
        }
        return $resp;
    }
    
    protected function translateCors($std)
    {
        $resp = [];
        foreach ($std->Cor as $item) {
            $resp[] = (object) [
                'cor' => $item->DC_Cor
            ];
        }
        return $resp;
    }
    
    protected function translateCores($std)
    {
        $resp = [];
        foreach ($std->SaldoArtigoCor as $item) {
            $resp[] = (object) [
                'codigo' => $item->Artigo,
                'local' => $item->Divisao,
                'cor' => $item->Cor,
                'pecas' => $item->Pecas,
                'peso' => $item->Peso
            ];
        }
        return $resp;
    }
    
    protected function translateRetornos($std)
    {
        $resp = [];
        if (is_array($std->Retorno)) {
            foreach ($std->Retorno as $ret) {
                $code = $ret->Codigo;
                if ($code > 999) {
                    //houve algum erro
                    $resp[] = (object) [
                        'erro' => $code,
                        'desc' => $this->errors[$code],
                    ];
                }
            }
        } else {
            $code = $std->Retorno->Codigo;
            if ($code > 999) {
                //houve algum erro
                $resp[] = (object) [
                    'erro' => $code,
                    'desc' => $this->errors[$code],
                ];
            } else {
                $resp[] = (object) [
                    'lote' => $std->Retorno->Lote->ID_Lote,
                    'nf' =>  $std->Retorno->Lote->NR_Nota_Fiscal,
                    'desc' => 'Sucesso lote registrado',
                ];   
            }
        }    
        return $resp;
    }
    
    

    public function whichIs($xml)
    {
        if (!$this->isXML($xml)) {
            throw new InvalidArgumentException(
                "O argumento passado não é um XML válido."
            );
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        foreach ($this->rootTagList as $key) {
            $node = !empty($dom->getElementsByTagName($key)->item(0))
                ? $dom->getElementsByTagName($key)->item(0)
                : '';
            if (!empty($node)) {
                $this->node = $dom->saveXML($node);
                $this->key = $key;
                return $key;
            }
        }
        throw new \InvalidArgumentException(
            "Este xml não pertence ao wsSeirem."
        );
    }
    
    public function isXML($content) {
        $content = trim($content);
        if (empty($content)) {
            return false;
        }
        if (stripos($content, '<!DOCTYPE html>') !== false
           || stripos($content, '</html>') !== false
        ) {
            return false;
        }
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        simplexml_load_string($content);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return empty($errors);
    }
}