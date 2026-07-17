let perguntas = [];
let atual = 0;
let acertos = 0;
let erros = [];

fetch('perguntas.json')
.then(r => r.json())
.then(data => {

    perguntas = data.sort(() => Math.random() - 0.5);

    carregarPergunta();
});

function carregarPergunta() {

    let p = perguntas[atual];

    document.getElementById("numero").innerHTML =
        `Pergunta ${atual+1} de ${perguntas.length}`;

    document.getElementById("pergunta").innerHTML =
        p.pergunta;

    let opcoes = document.getElementById("opcoes");

    opcoes.innerHTML = "";

    p.opcoes.forEach((opcao, i)=>{

        let btn = document.createElement("button");

        btn.className = "opcao";
        btn.innerHTML = opcao;

        btn.onclick = function(){
            responder(i);
        }

        opcoes.appendChild(btn);
    });
}

function responder(indice){

    let p = perguntas[atual];

    let botoes = document.querySelectorAll(".opcao");

    botoes.forEach(b=>b.disabled=true);

    if(indice === p.correta){

        botoes[indice].classList.add("correta");
        acertos++;
    }
    else{

        botoes[indice].classList.add("errada");
        botoes[p.correta].classList.add("correta");

        erros.push({
            pergunta:p.pergunta,
            resposta:p.opcoes[p.correta]
        });
    }
}

document.getElementById("proximo").onclick = function(){

    atual++;

    if(atual >= perguntas.length){
        finalizar();
        return;
    }

    carregarPergunta();
}

function finalizar(){

    document.getElementById("quiz").style.display="none";

    let percentual =
        ((acertos/perguntas.length)*100).toFixed(1);

    let nota =
        ((acertos/perguntas.length)*10).toFixed(1);

    let html = `
        <h2>Resultado Final</h2>

        <p><b>Acertos:</b> ${acertos}</p>
        <p><b>Erros:</b> ${perguntas.length-acertos}</p>
        <p><b>Aproveitamento:</b> ${percentual}%</p>
        <p><b>Nota:</b> ${nota}/10</p>
        <hr>
    `;

    if(erros.length){

        html += "<h3>Questões Erradas</h3>";

        erros.forEach(e=>{

            html += `
                <p>
                    <b>${e.pergunta}</b><br>
                    Resposta correta:
                    ${e.resposta}
                </p>
            `;
        });
    }

    document.getElementById("resultado").innerHTML = html;
    document.getElementById("resultado").style.display = "block";
}