<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use Fimatec\Seiren\Standardize;

/*
$xml = stripslashes('<?xml version=\"1.0\" encoding=\"utf-8\"?>'
        . '<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">'
        . '<soap:Body>'
        . '<WsCadastraLoteResponse xmlns=\"seirentextil.com.br\">'
        . '<xml><retornos><Retorno><Codigo>1019</Codigo><Local><NR_Nota_Fiscal>56790</NR_Nota_Fiscal><Local_Tag>NR_Nota_Fiscal</Local_Tag><Local_Valor>56790</Local_Valor></Local><Erro><Erro_Tag>NR_Cnpj_Faccionista</Erro_Tag><Erro_Valor /></Erro></Retorno></retornos></xml></WsCadastraLoteResponse></soap:Body></soap:Envelope>');


$xml = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
    <soap:Body>
        <WsCadastraLoteResponse xmlns="seirentextil.com.br">
           <xml>
              <retornos>
                  <Retorno>
                        <Codigo>1019</Codigo>
                        <Local>
                            <NR_Nota_Fiscal>56791</NR_Nota_Fiscal>
                            <Local_Tag>NR_Nota_Fiscal</Local_Tag>
                            <Local_Valor>56791</Local_Valor>
                        </Local>
                        <Erro>
                            <Erro_Tag>NR_Cnpj_Faccionista</Erro_Tag>
                            <Erro_Valor />
                        </Erro>
                    </Retorno>
                    <Retorno>
                        <Codigo>1028</Codigo>
                        <Local>
                            <NR_Nota_Fiscal>56791</NR_Nota_Fiscal>
                            <Local_Tag>NR_Romaneio</Local_Tag>
                            <Local_Valor>Null</Local_Valor>
                        </Local>
                        <Erro>
                            <Erro_Tag>DC_Artigo</Erro_Tag>
                            <Erro_Valor>2470BCB00</Erro_Valor>
                        </Erro>
                    </Retorno>
                </retornos>
            </xml>
        </WsCadastraLoteResponse>
    </soap:Body>
</soap:Envelope>';
*/

$xml = stripcslashes('<?xml version=\"1.0\" encoding=\"utf-8\"?><soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"><soap:Body><WsCadastraLoteResponse xmlns=\"seirentextil.com.br\"><xml><retornos><Retorno><Codigo>1</Codigo><Lote><ID_Lote>6045</ID_Lote><NR_Nota_Fiscal>56761</NR_Nota_Fiscal><NR_Cnpj_Faccionista /></Lote></Retorno></retornos></xml></WsCadastraLoteResponse></soap:Body></soap:Envelope>');

$st = new Standardize();
$std = $st->toStd($xml);
echo "<pre>";
print_r($std);
echo "</pre>";


