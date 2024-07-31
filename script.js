//Criação da constante da tag <tbody>
const tbody = document.querySelector('.listaFuncionarios');

//Função async await para listar os funcionários com uma requisição fetch ao list.php
const listarFuncionarios = async(pagina) => {
  const dados = await fetch('./list.php?pagina=' + pagina);
  const response = await dados.text();
  tbody.innerHTML = response;
}

listarFuncionarios(1);