document.addEventListener("DOMContentLoaded", decodificarParametroCriptografado);

function decodificarParametroCriptografado() {
  // Recuperar o parâmetro criptografado da URL
  const urlParams = new URLSearchParams(window.location.search);
  const parametroCriptografado = urlParams.get("parametro");

  // Decodificar o parâmetro usando JavaScript atob
  const parametroDecodificado = atob(parametroCriptografado);

  document.getElementById("cpf").value = parametroDecodificado;
  document.getElementById("cpf").setAttribute("readonly", true);

  // Exibir o valor do parâmetro na página
  // Preencher o campo CPF com um valor usando JavaScript
  return 1;
}

function validarSenha(event) {
    const senha = document.getElementById("senha").value;
    const confirmaSenha = document.getElementById("confirma_senha").value;

    if (senha !== confirmaSenha) {
      alert("As senhas não coincidem. Por favor, digite senhas iguais.");
      event.preventDefault(); // Impede o envio do formulário se as senhas não coincidirem
    }
  };

function MascaraTelefonica(elemento) {
  // Remove caracteres não numéricos do valor atual
  const inputTelefone = elemento.value.replace(/\D/g, '');

  // Formata o número de telefone
  const formattedTelefone = formatarTelefone(inputTelefone);

  // Atualiza o valor do campo de entrada
  elemento.value = formattedTelefone;
  
  function formatarTelefone(numero) {
    // Aplica a máscara telefônica
    return numero.replace(/^(\d{2})(\d{4,5})(\d{4})$/, '($1) $2-$3');
  }
}