<?php 


class Exporters
{

    static function alephseq($r)
    {

        $author_number = count($r['author']);
                                        
        $record = [];
        $record[] = "000000001 FMT   L BK";
        $record[] = "000000001 LDR   L ^^^^^nab^^22^^^^^Ia^4500";
        $record[] = '000000001 BAS   L $$a04';
        $record[] = "000000001 008   L ^^^^^^s^^^^^^^^^^^^^^^^^^^^^^000^0^^^^^d";
        if (isset($r['doi'])) {
            $record[] = '000000001 0247  L $$a'.$r["doi"].'$$2DOI';         
        } else {
            $record[] = '000000001 0247  L $$a$$2DOI';
        }
        $record[] = '000000001 040   L $$aUSP/SIBI';
        $record[] = '000000001 0410  L $$a';
        $record[] = '000000001 044   L $$a'.$r["country"].'';
        if ($author_number > 1) {
            if (isset($r['author'][0]["nomeParaCitacao"])) {
                $record[] = '000000001 1001  L $$a'.$r['author'][0]["nomeParaCitacao"].'$$d$$1$$4$$5$$7$$8$$9';
            } else {
                $record[] = '000000001 1001  L $$a'.$r['author'][0]["person"]["name"].'$$d$$1$$4$$5$$7$$8$$9';                
            }                                            
            for ($i = 1; $i < $author_number; $i++) {
                if (isset($r['author'][$i]["nomeParaCitacao"])) {
                    $record[] = '000000001 7001  L $$a'.$r['author'][$i]["nomeParaCitacao"].'$$d$$1$$4$$5$$7$$8$$9';
                } else {
                    $record[] = '000000001 7001  L $$a'.$r['author'][$i]["person"]["name"].'$$d$$1$$4$$5$$7$$8$$9';
                }
            }
        } else {
            if (isset($r['author'][0]["nomeParaCitacao"])) {
                $record[] = '000000001 1001  L $$a'.$r['author'][0]["nomeParaCitacao"].'$$d$$1$$4$$5$$7$$8$$9';
            } else {
                $record[] = '000000001 1001  L $$a'.$r['author'][0]["person"]["name"].'$$d$$1$$4$$5$$7$$8$$9';
            }
        }                                            
        $record[] = '000000001 24510 L $$a'.$r["name"].'';                                            
        if (isset($r["trabalhoEmEventos"])) {  
            $record[] = '000000001 260   L $$a'.((isset($r["trabalhoEmEventos"]["cidadeDaEditora"]) && $r["trabalhoEmEventos"]["cidadeDaEditora"])? $r["trabalhoEmEventos"]["cidadeDaEditora"] : '').'$$b'.((isset($r["trabalhoEmEventos"]["nomeDaEditora"]) && $r["trabalhoEmEventos"]["nomeDaEditora"])? $r["trabalhoEmEventos"]["nomeDaEditora"] : '').'$$c'.$r["datePublished"].'';
        } else {
            $record[] = '000000001 260   L $$a$$b'.((isset($r["publisher"]["organization"]["name"])? $r["publisher"]["organization"]["name"] : '')).'$$c'.$r["datePublished"].'';
        }        
        $record[] = '000000001 300   L $$ap. '.((isset($r["pageStart"])?$r["pageStart"]:"")).'-'.((isset($r["pageEnd"])?$r["pageEnd"]:"")).'';

        if (isset($r['doi'])) {
            $record[] = '000000001 500   L $$aDisponível em: <https://doi.org/'.$r["doi"].'>. Acesso em: '.date('d M Y').'';
        } else {
            $record[] = '000000001 500   L $$a';
        }

        if (isset($r["artigoPublicado"])) {
            $record[] = '000000001 5101  L $$aIndexado no:';
        }
        
        if (isset($r["sponsor"]["funder"])) {
            foreach ($r["sponsor"]["funder"] as $funder) {
                if (count($funder["award"]) > 0) {
                    $funder_string = '$$f'.implode("\$\$f", $funder["award"]).'';
                } else {
                    $funder_string = "";
                }
                $record[] = '000000001 536   L $$a'.$funder["name"].''.$funder_string.'';
            }
            
        }              
        
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';
        
        if (isset($r["trabalhoEmEventos"])) {
            if (empty($r["trabalhoEmEventos"]["cidadeDoEvento"])) {
                $r["trabalhoEmEventos"]["cidadeDoEvento"] = "Não informado";
            }

            $record[] = '000000001 7112  L $$a'.$r["trabalhoEmEventos"]["nomeDoEvento"].'$$d('.((isset($r["trabalhoEmEventos"]["anoDeRealizacao"]) && $r["trabalhoEmEventos"]["anoDeRealizacao"])? $r["trabalhoEmEventos"]["anoDeRealizacao"] : '').'$$c'.$r["trabalhoEmEventos"]["cidadeDoEvento"].')';
            
            $record[] = '000000001 7730  L $$t'.((isset($r["trabalhoEmEventos"]["tituloDosAnaisOuProceedings"]) && $r["trabalhoEmEventos"]["tituloDosAnaisOuProceedings"])? $r["trabalhoEmEventos"]["tituloDosAnaisOuProceedings"] : '').'$$x'.((isset($r["trabalhoEmEventos"]["isbn"]) && $r["trabalhoEmEventos"]["isbn"])? $r["trabalhoEmEventos"]["isbn"] : '').'$$hv. , n. , p.'.((isset($r["trabalhoEmEventos"]["paginaInicial"]) && $r["trabalhoEmEventos"]["paginaInicial"])? $r["trabalhoEmEventos"]["paginaInicial"] : '').'-'.((isset($r["trabalhoEmEventos"]["paginaFinal"]) && $r["trabalhoEmEventos"]["paginaFinal"])? $r["trabalhoEmEventos"]["paginaFinal"] : '').', '.((isset($r["trabalhoEmEventos"]["anoDeRealizacao"]) && $r["trabalhoEmEventos"]["anoDeRealizacao"])? $r["trabalhoEmEventos"]["anoDeRealizacao"] : '').'';
        }
        
        if (isset($r["isPartOf"])) {
            $record[] = '000000001 7730  L $$t'.$r["isPartOf_name"].'$$x'.((isset($r["isPartOf"]["ISSN"])? $r["isPartOf"]["ISSN"] : '')).'$$hv.'.((isset($r["volume"])? $r["volume"] : '')).', n. '.((isset($r["serie"])? $r["serie"] : '')).', p.'.((isset($r["pageStart"])? $r["pageStart"] : '')).'-'.((isset($r["pageEnd"])? $r["pageEnd"] : '')).', '.$r["datePublished"].'';
        }                                            
        
        
        if (isset($r['doi'])) {                                            
            $record[] = '000000001 8564  L $$zClicar sobre o botão para acesso ao texto completo$$uhttps://doi.org/'.$r["doi"].'$$3DOI';           
        } else {
            $record[] = '000000001 8564  L $$zClicar sobre o botão para acesso ao texto completo$$u$$3DOI';
        }                          
        
        if (isset($r["trabalhoEmEventos"])) {
            $record[] = '000000001 945   L $$aP$$bTRABALHO DE EVENTO$$c10$$j'.$r["datePublished"].'$$l';
        }
        if (isset($r["isPartOf"])) {
            $record[] = '000000001 945   L $$aP$$bARTIGO DE PERIODICO$$c01$$j'.$r["datePublished"].'$$l';
        }                                            
        $record[] = '000000001 946   L $$a';   
        
        //sort($record);

        $record_blob = implode("\\n", $record);

        return $record_blob;

    }    

}




?>