<?php
include_once 'conexao.php';
//Criação da variável página obtida pelo JavaScript
$pagina = filter_input(INPUT_GET,'pagina', FILTER_SANITIZE_NUMBER_INT);

if (!empty ($pagina)) {

  //Calcular a quantidade de visualizações de registros na tela
  $num_registros_pagina = 10; //Quantidade de registros por página
  $inicio = ($pagina * $num_registros_pagina) - $num_registros_pagina;

  $sql = "SELECT ID, NOME, EMAIL, SEXO, DEPARTAMENTO, ADMISSAO, SALARIO, CARGO FROM funcionarios ORDER BY ID ASC LIMIT :inicio, :offset";
  $prepare = $pdo->prepare($sql);
  $prepare->bindParam(":inicio", $inicio, PDO::PARAM_INT);
  $prepare->bindParam(":offset", $num_registros_pagina, PDO::PARAM_INT);
  $prepare->execute();

  $dados = "<table class='table table-warning table-striped' border='1' style='margin: 15px; width: 400px;'>
          <thead>
            <tr>
              <th>ID</th>
              <th>NOME</th>
              <th>EMAIL</th>
              <th>SEXO</th>
              <th>DEPARTAMENTO</th>
              <th>ADMISSAO</th>
              <th>SALARIO</th>
              <th>CARGO</th>
            </tr>
          </thead>";
  while($row = $prepare->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $dados .= "
            <tbody>
              <tr>
                <td>$ID</td>
                <td>$NOME</td>
                <td>$EMAIL</td>
                <td>$SEXO</td>
                <td>$DEPARTAMENTO</td>
                <td>$ADMISSAO</td>
                <td>$SALARIO</td>
                <td>$CARGO</td>
              </tr>
            </tbody>";
  }
$dados .= "</table>";

//Paginação - Somar a quantidade de usuários
$sqlQtdFuncionarios = "SELECT COUNT(ID) AS QTD_ID FROM funcionarios";
$prepareQtdFuncionarios = $pdo->prepare($sqlQtdFuncionarios);
$prepareQtdFuncionarios->execute();
$row_pg = $prepareQtdFuncionarios->fetch(PDO::FETCH_ASSOC);
extract($row_pg);
//Quantidade de páginas
$qtdPaginas = ceil($QTD_ID / $num_registros_pagina);
$dados .= "<p class='text-center'>Página: $pagina | Número de páginas: $qtdPaginas</p>";

$page_interval = 2;
$first_page = max($pagina - $page_interval, 1);
$last_page = min($qtdPaginas, $pagina + $page_interval);

$dados .= "<nav aria-label='Page navigation example'>
            <ul class='pagination justify-content-center'>
              <li class='page-item'><a class='page-link' href='#' onclick='listarFuncionarios(1)'>Primeiro</a></li>";
for($pag_ant = $pagina - $page_interval; $pag_ant <= $pagina - 1; $pag_ant++){
  if($pag_ant >= 1){
    $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarFuncionarios($pag_ant)'>$pag_ant</a></li>";
  }
}
  $dados .= " <li class='page-item active'><a class='page-link' href='#'>$pagina</a></li>";

for($pag_dep = $pagina + 1; $pag_dep <= $pagina + $page_interval; $pag_dep++){
  if($pag_dep <= $qtdPaginas){
    $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarFuncionarios($pag_dep)'>$pag_dep</a></li>";
  }
} 

  $dados .= "<li class='page-item'><a class='page-link' href='#' onclick='listarFuncionarios($qtdPaginas)'>Último</a></li>
            </ul>
          </nav>";
echo $dados;
} else {
  echo "<div class='alert alert-danger' role='alert'>
          Erro: Nenhum usuário encontrado!
        </div>";
}