<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Simulador EPL/ZPL</title>
<style>
body{
    margin:0;
    font-family:Arial;
}
.container{
    display:flex;
    height:100vh;
}
.left{
    width:40%;
    padding:20px;
    box-sizing:border-box;
}
.right{
    width:60%;
    padding:20px;
    background:#f0f0f0;
    overflow:auto;
}
textarea{
    width:100%;
    height:500px;
    font-family:monospace;
}
canvas{
    border:1px solid black;
    background:white;
}
input, select{
    margin:5px;
}
</style>
</head>
<body>

<div class="container">

<div class="left">
    <h2>Simulador</h2>

    Linguagem:
    <select id="tipo">
        <option value="EPL">EPL</option>
        <option value="ZPL">ZPL</option>
    </select>
    <br>

    Largura (cm):
    <input id="largura" value="10">

    Altura (cm):
    <input id="altura" value="5">

    <button onclick="render()">Simular</button>

    <br><br>

    <textarea id="codigo">
Q240,24
A30,1,0,2,2,2,N,"PRODUTO TESTE"
A30,40,0,2,2,2,N,"LINHA 2"
B30,90,0,1,3,2,35,B,"7891234567890"
    </textarea>
</div>

<div class="right">
    <canvas id="canvas"></canvas>
</div>

</div>

<script>
function render(){
    const tipo = document.getElementById('tipo').value;
    const codigo = document.getElementById('codigo').value;
    const larguraCM = parseFloat(document.getElementById('largura').value);
    const alturaCM = parseFloat(document.getElementById('altura').value);

    // 1 cm ≈ 38 px
    const escala = 38;

    const canvas = document.getElementById('canvas');
    canvas.width = larguraCM * escala;
    canvas.height = alturaCM * escala;

    const ctx = canvas.getContext('2d');
    ctx.clearRect(0,0,canvas.width,canvas.height);

    ctx.fillStyle="white";
    ctx.fillRect(0,0,canvas.width,canvas.height);
    ctx.fillStyle="black";

    if(tipo==="EPL"){
        parseEPL(codigo, ctx);
    }else{
        parseZPL(codigo, ctx);
    }
}

function parseEPL(codigo, ctx){
    const linhas = codigo.split("\n");

    linhas.forEach(linha=>{
        linha = linha.trim();

        if(linha.startsWith("A")){
            const m = linha.match(/^A(\d+),(\d+).*,"(.*)"$/);
            if(m){
                const x = parseInt(m[1]);
                const y = parseInt(m[2]);

                ctx.font="18px Arial";
                ctx.fillText(m[3], x, y+18);
            }
        }

        if(linha.startsWith("B")){
            const m = linha.match(/^B(\d+),(\d+)/);
            if(m){
                barcode(ctx, parseInt(m[1]), parseInt(m[2]));
            }
        }
    });
}

function parseZPL(codigo, ctx){
    const linhas = codigo.split("\n");

    let x=0;
    let y=0;

    linhas.forEach(linha=>{
        linha = linha.trim();

        let fo = linha.match(/\^FO(\d+),(\d+)/);
        if(fo){
            x=parseInt(fo[1]);
            y=parseInt(fo[2]);
        }

        let fd = linha.match(/\^FD(.*)\^FS/);
        if(fd){
            ctx.font="18px Arial";
            ctx.fillText(fd[1], x, y+18);
        }

        if(linha.includes("^BC")){
            barcode(ctx,x,y);
        }
    });
}

function barcode(ctx,x,y){
    for(let i=0;i<150;i+=4){
        ctx.fillRect(x+i,y,2,60);
    }
}
render();
</script>

</body>
</html>