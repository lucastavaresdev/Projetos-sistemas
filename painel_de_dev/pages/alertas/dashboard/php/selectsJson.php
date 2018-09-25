<?php


require('./conexao.php');// REQUSIÇÃO DO BANCO

$parametro =$_GET['parametro'];//PARAMETRO

//selects
$agendamento = 'SELECT nm_paciente, tp_situacao, dt_agendamento,tp_sexo, ds_cirurgia FROM agendamento WHERE DATE(dt_agendamento) = CURDATE() order by dt_agendamento';

$localizacao =  "SELECT distinct a.nm_paciente as paciente,dt_nascimento as data_nascimento, t.id_sala, s.nome as setor 
from tracking_pacientes t
left join setores s on s.id = t.id_sala
left join gateways g on g.id = t.gateway
left join beacons b on b.id = t.beacon
left join agendamento a on b.id_vinculado = a.cd_aviso_cirurgia
left join tracking_scan ts on ts.gateway = t.gateway and ts.beacon = t.beacon
where (t.fechado is null and t.id_vinculado is not null and t.categoria = 'Paciente')";




$setor = "SELECT * FROM nipo.setores s
left join (
  select count(id) as qtdsala, id_sala
      from tracking_pacientes
      where fechado is null
      group by id_sala
  ) t
  on t.id_sala = s.id";

//parametro passado
if($parametro === 'agendamento'){
  geraJson($agendamento , $conexao );
}else if($parametro === 'localizacao'){
  geraJson($localizacao, $conexao);
}else if($parametro === 'setor'){
  geraJson($setor, $conexao);
}
 

//retorna e exibe o json
  function geraJson($select, $conexao){
    $sql = $select;
    $stmt = $conexao->prepare( $sql );
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );
    $novo = array();
      foreach ($result as $key => $value) {
        foreach ($value as $k => $v) {
          $novo[$key][$k] = $v;
        }
      }
    $json = json_encode($novo);
   echo $json; 
  }
?>




