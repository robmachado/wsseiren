<?php

namespace Fimatec\Seiren;

class Lote
{
    protected $dom;
    protected $node;
    protected $std;

    public function __construct(\stdClass $std)
    {
        $this->std = $std;
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $this->node = $dom->createElement('lotes');
        $this->dom = $dom;
    }
    
    public function render()
    {
        foreach($this->std->lote as $lote) {
            $lot = $this->dom->createElement('Lote');
            $lot->appendChild($this->dom->createElement('NR_Nota_Fiscal', $lote->numero));
            $lot->appendChild($this->dom->createElement('DT_Emissao', $lote->emissao));
            $lot->appendChild($this->dom->createElement('OP_Tipo_Lote', $lote->tipo));
            $lot->appendChild($this->dom->createElement('NR_Cnpj_Faccionista', $lote->faccionista));
            
            $roms = $this->dom->createElement('Romaneios');
            foreach($lote->romaneio as $r) {
                $rom = $this->dom->createElement('Romaneio');
                $rom->appendChild($this->dom->createElement('NR_Romaneio', $r->numero));
                $rom->appendChild($this->dom->createElement('DC_Artigo', $r->artigo));
                $rom->appendChild($this->dom->createElement('DC_Cor', $r->cor));
                $rom->appendChild($this->dom->createElement('OP_Tipo', $r->tipo));
                $rom->appendChild($this->dom->createElement('NR_Cod_Produto', $r->codigo));
                $rom->appendChild($this->dom->createElement('NR_Largura', $r->largura));
                $rom->appendChild($this->dom->createElement('NR_Gramatura', $r->gramatura));
                $rom->appendChild($this->dom->createElement('DC_Obs', $r->obs));
                $pcs = $this->dom->createElement('Romaneio');
                foreach($r->peca as $p) {
                    $pc = $this->dom->createElement('Peca');
                    $pc->appendChild($this->dom->createElement('NR_Peca', $p->numero));
                    $pc->appendChild($this->dom->createElement('NR_Peso', $p->peso));
                    $pc->appendChild($this->dom->createElement('NR_Comprimento', $p->comprimento));
                    $pc->appendChild($this->dom->createElement('DC_Maquina', $p->maquina));
                    $pc->appendChild($this->dom->createElement('DC_Maquina_Lote', $p->lote));
                    $pcs->appendChild($pc);
                }
                $rom->appendChild($pcs);
                $roms->appendChild($rom);
            }
            $lot->appendChild($roms);
            $this->node->appendChild($lot);
        }
        $this->dom->appendChild($this->node);
        return $this->dom->saveXML();
    }
    
    
}