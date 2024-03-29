<?php

namespace Fimatec\Seiren;

class Lote
{
    /**
     * var \DOMDocument
     */
    protected $dom;
    /**
     * @var \DOMElement|false
     */
    protected $node;
    /**
     * @var \stdClass
     */
    protected $std;

    /**
     * Construtor
     *
     * @param \stdClass $std
     * @throws \DOMException
     */
    public function __construct(\stdClass $std)
    {
        $this->std = $std;
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $this->node = $dom->createElement('lotes');
        $this->dom = $dom;
    }

    /**
     * Renderiza os dados em XML
     *
     * @return array|string|string[]
     * @throws \DOMException
     */
    public function render()
    {
        foreach ($this->std->lote as $lote) {
            $lot = $this->dom->createElement('Lote');
            $lot->appendChild($this->dom->createElement('NR_Nota_Fiscal', $lote->numero));
            $lot->appendChild($this->dom->createElement('DT_Emissao', $lote->emissao));
            $lot->appendChild($this->dom->createElement('OP_Tipo_Lote', $lote->tipo));
            $lot->appendChild($this->dom->createElement('NR_Cnpj_Faccionista', $lote->faccionista ?? ''));
            foreach ($lote->romaneio as $r) {
                $rom = $this->dom->createElement('Romaneio');
                $rom->appendChild($this->dom->createElement('NR_Romaneio', $r->numero));
                $rom->appendChild($this->dom->createElement('DC_Artigo', $r->artigo));
                $rom->appendChild($this->dom->createElement('DC_Cor', $r->cor));
                $rom->appendChild($this->dom->createElement('OP_Tipo', $r->tipo));
                $rom->appendChild($this->dom->createElement('NR_Cod_Produto', $r->codigo));
                $rom->appendChild($this->dom->createElement('NR_Largura', number_format($r->largura, 2, ',', '')));
                $rom->appendChild($this->dom->createElement('NR_Gramatura', round($r->gramatura, 0)));
                $rom->appendChild($this->dom->createElement('DC_Obs', $r->obs));
                foreach ($r->peca as $p) {
                    $pc = $this->dom->createElement('Peca');
                    $pc->appendChild($this->dom->createElement('NR_Peca', $p->numero));
                    $pc->appendChild($this->dom->createElement('NR_Peso', number_format($p->peso, 2, ',', '')));
                    $pc->appendChild($this->dom->createElement('NR_Comprimento', round($p->comprimento, 0)));
                    $pc->appendChild($this->dom->createElement('DC_Maquina', $p->maquina));
                    $pc->appendChild($this->dom->createElement('DC_Maquina_Lote', $p->lote));
                    if (isset($p->titulo)) {
                        $pc->appendChild($this->dom->createElement('DC_Titulagem', $p->titulo));
                    }
                    $rom->appendChild($pc);
                }
                $lot->appendChild($rom);
            }
            if (isset($lote->status)) {
                $lot->appendChild($this->dom->createElement('ID_STATUS', $lote->status));
            }
            if (isset($lote->chave)) {
                $lot->appendChild($this->dom->createElement('Chave_XML', $lote->chave));
            }
            $this->node->appendChild($lot);
        }
        $this->dom->appendChild($this->node);
        $xml = $this->dom->saveXML($this->dom->documentElement);
        return str_replace('<NR_Cnpj_Faccionista/>', '<NR_Cnpj_Faccionista></NR_Cnpj_Faccionista>', $xml);
    }
}
