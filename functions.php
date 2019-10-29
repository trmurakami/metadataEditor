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
        $record[] = '000000001 008   L ^^^^^^s'.((isset($r["datePublished"])? $r["datePublished"] : '^^^^')).'^^^^^^^^^^^^^^^^^^000^0^^^^^d';
        if (isset($r['doi'])) {
            $record[] = '000000001 0247  L $$a'.$r["doi"].'$$2DOI';         
        } else {
            $record[] = '000000001 0247  L $$a$$2DOI';
        }
        $record[] = '000000001 040   L $$aUSP/SIBI';
        $record[] = '000000001 0410  L $$a';
        $record[] = '000000001 044   L $$a'.$r["country"].'';


        if (isset($r["author_0_person_name"])) {
            $record[] = '000000001 1001  L $$a'.$r["author_0_person_name"].'$$d$$0'.((isset($r["author_0_person_identifier_value"])? $r["author_0_person_identifier_value"] : '')).'$$1$$4$$5$$7$$8'.((isset($r["author_0_organization_name"])? $r["author_0_organization_name"] : '')).'$$9';
        }         
        
        $record[] = '000000001 24510 L $$a'.$r["name"].'';                                            
        if (isset($r["trabalhoEmEventos"])) {  
            $record[] = '000000001 260   L $$a'.((isset($r["trabalhoEmEventos"]["cidadeDaEditora"]) && $r["trabalhoEmEventos"]["cidadeDaEditora"])? $r["trabalhoEmEventos"]["cidadeDaEditora"] : '').'$$b'.((isset($r["trabalhoEmEventos"]["nomeDaEditora"]) && $r["trabalhoEmEventos"]["nomeDaEditora"])? $r["trabalhoEmEventos"]["nomeDaEditora"] : '').'$$c'.$r["datePublished"].'';
        } else {
            $record[] = '000000001 260   L $$a$$b'.((isset($r["publisher_organization_name"])? $r["publisher_organization_name"] : '')).'$$c'.$r["datePublished"].'';
        }        
        $record[] = '000000001 300   L $$ap. '.((isset($r["isPartOf_pageStart"])?$r["isPartOf_pageStart"]:"")).'-'.((isset($r["isPartOf_pageEnd"])?$r["isPartOf_pageEnd"]:"")).'';

        if (isset($r['doi'])) {
            $record[] = '000000001 500   L $$aDisponível em: https://doi.org/'.$r["doi"].'. Acesso em: '.date('d M Y').'';
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

        $i_about = 0;
        do {
            $key_about =  'about_'.$i_about.'';
            if (isset($r[$key_about])) {
                $record[] = '000000001 650 7 L $$a'.$r[$key_about].'';
            }
            $i_about++;
        } while ($i_about < 100);    
        
        
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';
        $record[] = '000000001 650 7 L $$a';

        $i = 1;
        do {
            $key =  'author_'.$i.'_person_name';
            $key_person_identifier_value =  'author_'.$i.'_person_identifier_value';
            $key_organization_name =  'author_'.$i.'_organization_name';

            if (isset($r[$key])) {
                $record[] = '000000001 7001  L $$a'.$r[$key].'$$d$$0'.((isset($r[$key_person_identifier_value])? $r[$key_person_identifier_value] : '')).'$$1$$4$$5$$7$$8'.((isset($r[$key_organization_name])? $r[$key_organization_name] : '')).'$$9';
            }
            $i++;
        } while ($i < 100);
     
        
        if (isset($r["trabalhoEmEventos"])) {
            if (empty($r["trabalhoEmEventos"]["cidadeDoEvento"])) {
                $r["trabalhoEmEventos"]["cidadeDoEvento"] = "Não informado";
            }

            $record[] = '000000001 7112  L $$a'.$r["trabalhoEmEventos"]["nomeDoEvento"].'$$d('.((isset($r["trabalhoEmEventos"]["anoDeRealizacao"]) && $r["trabalhoEmEventos"]["anoDeRealizacao"])? $r["trabalhoEmEventos"]["anoDeRealizacao"] : '').'$$c'.$r["trabalhoEmEventos"]["cidadeDoEvento"].')';
            
            $record[] = '000000001 7730  L $$t'.((isset($r["trabalhoEmEventos"]["tituloDosAnaisOuProceedings"]) && $r["trabalhoEmEventos"]["tituloDosAnaisOuProceedings"])? $r["trabalhoEmEventos"]["tituloDosAnaisOuProceedings"] : '').'$$x'.((isset($r["trabalhoEmEventos"]["isbn"]) && $r["trabalhoEmEventos"]["isbn"])? $r["trabalhoEmEventos"]["isbn"] : '').'$$hv. , n. , p.'.((isset($r["trabalhoEmEventos"]["paginaInicial"]) && $r["trabalhoEmEventos"]["paginaInicial"])? $r["trabalhoEmEventos"]["paginaInicial"] : '').'-'.((isset($r["trabalhoEmEventos"]["paginaFinal"]) && $r["trabalhoEmEventos"]["paginaFinal"])? $r["trabalhoEmEventos"]["paginaFinal"] : '').', '.((isset($r["trabalhoEmEventos"]["anoDeRealizacao"]) && $r["trabalhoEmEventos"]["anoDeRealizacao"])? $r["trabalhoEmEventos"]["anoDeRealizacao"] : '').'';
        }
        
        if (isset($r["isPartOf_name"])) {
            $record[] = '000000001 7730  L $$t'.$r["isPartOf_name"].'$$x'.((isset($r["isPartOf_ISSN"])? $r["isPartOf_ISSN"] : '')).'$$hv.'.((isset($r["isPartOf_volume"])? $r["isPartOf_volume"] : '')).', n. '.((isset($r["isPartOf_issue"])? $r["isPartOf_issue"] : '')).', p.'.((isset($r["isPartOf_pageStart"])? $r["isPartOf_pageStart"] : '')).'-'.((isset($r["isPartOf_pageEnd"])? $r["isPartOf_pageEnd"] : '')).', '.$r["datePublished"].'';
        }                                            
        
        
        if (isset($r['doi'])) {                                            
            $record[] = '000000001 8564  L $$zClicar sobre o botão para acesso ao texto completo$$uhttps://doi.org/'.$r["doi"].'$$3DOI';           
        } else {
            $record[] = '000000001 8564  L $$zClicar sobre o botão para acesso ao texto completo$$u$$3DOI';
        }
        
        if (!empty($r['url'])) {                                            
            $record[] = '000000001 8564  L $$zClicar sobre o botão para acesso ao texto completo$$u'.$r["url"].'$$3Documento completo';           
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