//Criação da constante da tag <tbody>
const tbody = document.querySelector('tbody');

//Função async await para listar os funcionários com uma requisição fetch ao list.php
const listarFuncionarios = async() => {
  const dados = await fetch('./list.php');
  const response = await dados.text();
  tbody.innerHTML = response;
}

listarFuncionarios();