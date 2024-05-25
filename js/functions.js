
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



	

	
function Mudarestado(el) {
  var display = document.getElementById(el).style.display;
  if (display == "none")
    document.getElementById(el).style.display = 'block';
  else
    document.getElementById(el).style.display = 'none';
}
