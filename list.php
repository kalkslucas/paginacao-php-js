<?php
include_once 'conexao.php';

$sql = "SELECT ID, NOME, EMAIL, SEXO, DEPARTAMENTO, ADMISSAO, SALARIO, CARGO FROM funcionarios LIMIT 10";
$prepare = $pdo->prepare($sql);
$prepare->execute();

$dados = "";
while( $row = $prepare->fetch(PDO::FETCH_ASSOC) ) {
  extract($row);
  $dados .= "<tr>
        <td>$ID</td>
        <td>$NOME</td>
        <td>$EMAIL</td>
        <td>$SEXO</td>
        <td>$DEPARTAMENTO</td>
        <td>$ADMISSAO</td>
        <td>$SALARIO</td>
        <td>$CARGO</td>
      </tr>";
}

echo $dados;