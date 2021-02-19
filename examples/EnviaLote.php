<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use Fimatec\Seiren\Tools;
use Fimatec\Seiren\Standardize;
use Fimatec\Seiren\Lote;

$config = (object) [
    'cnpj' => '99.999.999/0001-99',
    'token' => '65656-333-3-KL111E-45323FQ',
    'tpamb' => 2
];

$tools = new Tools($config);


$std = new \stdClass();
$std->lote[0] = new \stdClass();
$std->lote[0]->numero = 114;
$std->lote[0]->emissao = '2020-09-16';
$std->lote[0]->tipo = 1; //1-Próprio; 2-Serviço; 3-Comprado
$std->lote[0]->faccionista = ''; //Caso não seja Faccionista, enviar branco ou CNPJ do faccionista
$std->lote[0]->status = 0; //Campo opcional, caso queira enviar um lote com status "preparando" para ser revisado/alterado no portal. Atenção, neste caso precisa enviar através do botão "Enviar lote" do portal.
$std->lote[0]->chave = '12345678901234567890123456789012345678901234'; //Campo opcional (manter o envio do número da nota e data de emissão);

$std->lote[0]->romaneio[0] = new \stdClass();
$std->lote[0]->romaneio[0]->numero = '5511111';
$std->lote[0]->romaneio[0]->artigo = '2584BCB0';
$std->lote[0]->romaneio[0]->cor = '|PURGADO E FIXADO';
$std->lote[0]->romaneio[0]->tipo = 1; //1=Normal; 2= Devolução; 3=Retingimento
$std->lote[0]->romaneio[0]->codigo = '22584BCB02';
$std->lote[0]->romaneio[0]->largura = 1.70;
$std->lote[0]->romaneio[0]->gramatura = 110;
$std->lote[0]->romaneio[0]->obs = '';

$std->lote[0]->romaneio[0]->peca[0] = new \stdClass();
$std->lote[0]->romaneio[0]->peca[0]->numero = '203699934';
$std->lote[0]->romaneio[0]->peca[0]->peso = 14.01;
$std->lote[0]->romaneio[0]->peca[0]->comprimento = 141;
$std->lote[0]->romaneio[0]->peca[0]->maquina = '203';
$std->lote[0]->romaneio[0]->peca[0]->lote = '203699';
$std->lote[0]->romaneio[0]->peca[0]->titulo = '167/48';

$lote = new Lote($std);
$resp = $lote->render();

/*
$resp = $tools->enviaLote($lote);
file_put_contents('../storage/envia_response'.time().'.xml', $resp);

$std = (new Standardize())->toStd($resp);

echo "<pre>";
print_r($std);
echo "</pre>";
*/
header("Content-type: text/xml");
echo $resp;
