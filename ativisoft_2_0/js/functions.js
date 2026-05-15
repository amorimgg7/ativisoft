
function cpfcnpj(i) { 
  let v = i.value;

  // Remove caracteres não numéricos
  v = v.replace(/\D/g, '');

  // Limita o número de caracteres a 14
  v = v.substring(0, 14);

  // Formatação para CPF ou CNPJ
  if (v.length <= 11) { 
    // CPF: formato XXXXXXXXX-XX
    v = v.replace(/(\d{9})(\d{1,2})$/, '$1-$2');
  } else { 
    // CNPJ: formato XXXXXXXX/XXXX-XX
    v = v.replace(/(\d{8})(\d{4})(\d{2})$/, '$1/$2-$3');
  }

  // Atualiza o valor do campo de input
  i.value = v;
}




function cnpj(i){ 
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
    i.value = v.substring(0, v.length-1);
    return;
  }
  
  // Remove caracteres não numéricos usando expressão regular
  v = v.replace(/\D/g, '');

  // Atualiza o valor do campo de input
  i.value = v;

  i.setAttribute("maxlength", "14");
}

function cpf(i) {
  var v = i.value;
  
  // Remove caracteres não numéricos usando expressão regular
  v = v.replace(/\D/g, '');

  // Atualiza o valor do campo de input
  i.value = v;

  i.setAttribute("maxlength", "11");
  
}


function rg(i){
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
    return;
  }

  // Remove caracteres não numéricos usando expressão regular
  v = v.replace(/\D/g, '');

  // Atualiza o valor do campo de input
  i.value = v;

  i.setAttribute("maxlength", "12");
  
}

function cnh(i){
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
    return;
  }

  // Remove caracteres não numéricos usando expressão regular
  v = v.replace(/\D/g, '');

  // Atualiza o valor do campo de input
  i.value = v;

  i.setAttribute("maxlength", "12");
  
}

function cartTrabalho(i){
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
    return;
  }

  i.setAttribute("maxlength", "15");
  if (v.length == 1 || v.length == 5) i.value += " ";
  if (v.length == 9) i.value += "/";
  if (v.length == 13) i.value += "-";
}


function pis(i){
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
    return;
  }

  i.setAttribute("maxlength", "14");
  if (v.length == 3 || v.length == 9) i.value += ".";
  if (v.length == 12) i.value += "-";
}

function tel(i){
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
    return;
  }

  // Remove caracteres não numéricos usando expressão regular
  v = v.replace(/\D/g, '');

  // Atualiza o valor do campo de input
  i.value = v;

  i.setAttribute("maxlength", "11");
}

function tel2(i){
  var v = i.value;   
  if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
      i.value = v.substring(0, v.length-1);
    return;
  }

  // Remove caracteres não numéricos usando expressão regular
  v = v.replace(/\D/g, '');

  // Atualiza o valor do campo de input
  i.value = v;

  i.setAttribute("maxlength", "9");
  
}


function RS(i) {
    // remove tudo que não for número
    let v = i.value.replace(/\D/g, '');

    // se vazio, limpa
    if (v === '') {
        i.value = '';
        return;
    }

    // converte para inteiro (remove zeros à esquerda)
    v = parseInt(v, 10).toString();

    // garante pelo menos 3 dígitos
    if (v.length === 1) {
        v = '00' + v;
    } else if (v.length === 2) {
        v = '0' + v;
    }

    // separa inteiro e decimal
    let inteiro = v.slice(0, -2);
    let decimal = v.slice(-2);

    i.value = inteiro + '.' + decimal;
}


function RSInput(i) {

    // somente números
    let v = i.value.replace(/\\D/g, "");

    if (v === "") {
        i.value = "";
        limparMensagem();
        return;
    }

    // até 2 dígitos: deixa como inteiro (SEM .00)
    if (v.length <= 2) {
        i.value = v;
        return;
    }

    // 3 ou mais dígitos → últimas 2 casas decimais
    let inteiro = v.slice(0, -2);
    let decimal = v.slice(-2);

    // remove zeros à esquerda do inteiro
    inteiro = inteiro.replace(/^0+(?=\\d)/, "");

    i.value = inteiro + "." + decimal;
}

function RSBlur(i) {

    if (i.value === "") return;

    let v = i.value.replace(/\\D/g, "");

    if (v.length <= 2) {
        // completa .00 apenas ao sair do campo
        i.value = v + ".00";
    } else {
        let inteiro = v.slice(0, -2);
        let decimal = v.slice(-2);
        inteiro = inteiro.replace(/^0+(?=\\d)/, "");
        i.value = inteiro + "." + decimal;
    }

    validarValor(i);
}

function validarValor(i) {

    let valorNum = parseFloat(i.value);
    let max = '.$falta_pagar.';

    let msg = document.getElementById("mensagem-financeira");

    if (isNaN(valorNum) || valorNum <= 0 || valorNum > max) {
        msg.style.color = "red";
        i.style.border = "2px solid red";
        msg.textContent =
            "O valor pago deve ser maior que 0 e menor ou igual a " + max.toFixed(2);
        i.setCustomValidity("Valor inválido");
    } else {
        msg.style.color = "green";
        i.style.border = "1px solid green";
        msg.textContent = "OK";
        i.setCustomValidity("");
    }
}





	

	
function Mudarestado(el) {
  var display = document.getElementById(el).style.display;
  if (display == "none")
    document.getElementById(el).style.display = 'block';
  else
    document.getElementById(el).style.display = 'none';
}



function iniciarCarregamento() {
      document.getElementById("load").style.display = 'flex';
    }
    function finalizarCarregamento() {
      document.getElementById("load").style.display = 'none';
    }

    


function editarOrcamento(id) {
    const titulo = document.getElementById('listatitulo_orcamento_' + id);
    const valor  = document.getElementById('listavalor_orcamento_' + id);
    const botao  = document.getElementById('btnGravar_' + id);

    titulo.readOnly = false;
    valor.readOnly  = false;

    titulo.focus();
    botao.style.display = 'inline-block';
}


document.addEventListener('DOMContentLoaded', function(){

    const hidden = document.getElementById('fl_ocorrencia');
    const toggle = document.getElementById('fl_ocorrencia_toggle');

    if(hidden && toggle){
        toggle.checked = hidden.value === 'S';
    }

});






