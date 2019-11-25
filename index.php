<?php
	
	$arr = ['Jogos online','Redes sociais','Cinema','Ver TV/Filmes','Shopping','Restaurantes','Esportes','Ler','Outro'];

	$arr2 = [];

	$arr3 = [];

	$arr4 = [];

	$sql = "SELECT * FROM (";
    $union = '';
	for($l = 0; $l < count($arr); $l++){
		for($k = 0; $k < count($arr2); $k++){
			for($i = 0; $i < count($arr3); $i++) {
				for ($j = 0; $j < count($arr4); $j++) {
					$sql .= $union."SELECT contato_id, des_sair_publico, des_lugar_pais, des_estuda, des_bairro, des_serie, des_profissao_mae, des_profissao_pai, des_genero, '".$arr[$i]."' des_horas_vagas_classe, des_horas_vagas" .($l + 1). " des_horas_vagas WHERE des_horas_vagas" .($l + 1);
					$union = " UNION ";
		}
			}
				}
					}

	$sql .= ") xv_naca_fora_escola;";

	echo $sql;

?>