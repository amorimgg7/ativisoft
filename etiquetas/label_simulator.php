<?php
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Label Simulator</title>
<style>
html, body{
    margin:0;
    height:100%;
    overflow:hidden;
    font-family:Arial;
}
.wrapper{
    display:flex;
    height:100%;
}
.sidebar{
    width:420px;
    border-right:1px solid #ccc;
    padding:15px;
    box-sizing:border-box;
    background:#fafafa;
    overflow-y: auto;
}
.viewer{
    flex:1;
    background:#d8d8d8;
    position:relative;
    overflow:hidden;
}
textarea{
    width:100%;
    height:400px;
    font-family:Consolas;
    font-size:14px;
}
.toolbar{
    margin-bottom:10px;
}
.toolbar input, .toolbar select, .toolbar button{
    margin:3px;
}
canvas{
    position:absolute;
    left:0;
    top:0;
    cursor:grab;
}
canvas:active {
    cursor: grabbing;
}
</style>
</head>
<body>

<div class="wrapper">

<div class="sidebar">
    <h2>Label Simulator</h2>

    <div class="toolbar">
    Linguagem:
    <select id="language">
        <option value="EPL">EPL</option>
        <option value="ZPL">ZPL</option>
    </select>

    Preset:
    <select id="preset" onchange="applyPreset()">
        <option value="">Custom</option>
        <option value="10x3">10 x 3 cm</option>
        <option value="10x5">10 x 5 cm</option>
        <option value="A6">A6 (10.5 x 14.8 cm)</option>
    </select>

    <br><br>

    Tamanho:
    <select id="sizeMode">
        <option value="auto">Auto (usar código)</option>
        <option value="dots">Manual (dots)</option>
        <option value="cm">Manual (cm)</option>
    </select>

    <br>

    Largura:
    <input id="widthValue" value="831" size="6">

    Altura:
    <input id="heightValue" value="240" size="6">

    <br><br>

    DPI:
    <input id="dpi" value="203" size="5">

    <br><br>

    Grid:
    <input type="checkbox" id="grid" checked onchange="renderLabel()">

    <br><br>

    <button onclick="renderLabel()">Render</button>
    <button onclick="zoomIn()">+</button>
    <button onclick="zoomOut()">-</button>
    <button onclick="fitScreen()">Fit</button>
</div>

<textarea id="code">Q240,24
q831
N
A30,1,0,2,2,2,N,"PRODUTO TESTE"
A30,40,0,2,2,2,N,"LINHA 2"
B30,90,0,1,3,2,35,B,"7891234567890"
A250,90,0,3,2,1,N,"VAREJO"
A250,120,0,4,2,2,N,"R$29,90"
A550,90,0,3,2,1,N,"ATACADO"
A550,120,0,4,2,2,N,"R$25,90"
P1</textarea>
</div>

<div class="viewer" id="viewer">
    <canvas id="canvas"></canvas>
</div>

</div>

<script>
const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");
const viewer = document.getElementById("viewer");

let labelWidth = 831;
let labelHeight = 240;
let zoom = 1;
let offsetX = 0;
let offsetY = 0;

let dragging = false;
let dragX = 0;
let dragY = 0;

function parseEPL(code){
    const commands = [];
    const lines = code.split("\n");

    for(let line of lines){
        line = line.trim();

        if(line.startsWith("q")){
            labelWidth = parseInt(line.substring(1)) || labelWidth;
        }

        if(line.startsWith("Q")){
            const p = line.substring(1).split(",");
            labelHeight = parseInt(p[0]) || labelHeight;
        }

        if(line.startsWith("A")){
            // Expressão regular aprimorada para capturar textos de forma segura
            const m = line.match(/^A\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*[N|R]\s*,\s*["'](.*)["']$/);
            if(m){
                commands.push({
                    type: "text",
                    x: +m[1],
                    y: +m[2],
                    font: +m[4],
                    mx: +m[5],
                    my: +m[6],
                    text: m[7]
                });
            }
        }

        if(line.startsWith("B")){
            const m = line.match(/^B\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*([^,]+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*,\s*[B|N]\s*,\s*["'](.*)["']$/);
            if(m){
                commands.push({
                    type: "barcode",
                    x: +m[1],
                    y: +m[2],
                    height: +m[7],
                    data: m[8]
                });
            }
        }
    }
    return commands;
}

function parseZPL(code){
    const commands = [];
    const lines = code.split("\n");
    let x = 0, y = 0;

    for(let line of lines){
        line = line.trim();
        let fo = line.match(/\^FO(\d+),(\d+)/);
        if(fo){
            x = +fo[1];
            y = +fo[2];
        }

        let fd = line.match(/\^FD(.*)\^FS/);
        if(fd){
            commands.push({
                type: "text",
                x, y,
                font: 3,
                mx: 1,
                my: 1,
                text: fd[1]
            });
        }

        if(line.includes("^BC")){
            commands.push({
                type: "barcode",
                x, y,
                height: 60
            });
        }
    }
    return commands;
}

function fontSize(font, mx, my){
    let base = {
        1: 8,
        2: 12,
        3: 16,
        4: 22,
        5: 28
    }[font] || 12;

    return base * my;
}

function drawBarcode(x, y, h){
    let pos = x;
    ctx.fillStyle = "black";
    for(let i = 0; i < 60; i++){
        let w = (i % 4 === 0) ? 3 : 1;
        ctx.fillRect(pos, y, w, h);
        pos += w + 1;
    }
}

function drawGrid(){
    if(!document.getElementById("grid").checked) return;

    ctx.strokeStyle = "#ddd";
    ctx.lineWidth = 1;

    for(let x = 0; x < labelWidth; x += 50){
        ctx.beginPath();
        ctx.moveTo(x, 0);
        ctx.lineTo(x, labelHeight);
        ctx.stroke();
    }

    for(let y = 0; y < labelHeight; y += 50){
        ctx.beginPath();
        ctx.moveTo(0, y);
        ctx.lineTo(labelWidth, y);
        ctx.stroke();
    }
}

function applyPreset() {
    const preset = document.getElementById("preset").value;
    const dpi = parseFloat(document.getElementById("dpi").value) || 203;
    
    if (!preset) return;
    
    document.getElementById("sizeMode").value = "dots";
    
    let cmW = 0, cmH = 0;
    
    if (preset === "10x3") { cmW = 10; cmH = 3; }
    if (preset === "10x5") { cmW = 10; cmH = 5; }
    if (preset === "A6")    { cmW = 10.5; cmH = 14.8; }
    
    const dotsW = Math.round((cmW * dpi) / 2.54);
    const dotsH = Math.round((cmH * dpi) / 2.54);
    
    document.getElementById("widthValue").value = dotsW;
    document.getElementById("heightValue").value = dotsH;
    
    renderLabel();
}

function renderLabel(){
    const code = document.getElementById("code").value;
    const lang = document.getElementById("language").value;

    // Se estiver em modo automático, roda o parser antes para capturar as dimensões da etiqueta (EPL)
    if (document.getElementById("sizeMode").value === "auto" && lang === "EPL") {
        parseEPL(code); 
    }

    const size = getLabelSize();
    labelWidth = size.width;
    labelHeight = size.height;

    canvas.width = viewer.clientWidth;
    canvas.height = viewer.clientHeight;
    
    ctx.setTransform(1,0,0,1,0,0);
    ctx.clearRect(0,0,canvas.width,canvas.height);

    let commands = lang === "EPL" ? parseEPL(code) : parseZPL(code);

    ctx.translate(offsetX, offsetY);
    ctx.scale(zoom, zoom);

    ctx.fillStyle = "white";
    ctx.fillRect(0, 0, labelWidth, labelHeight);

    drawGrid();

    commands.forEach(cmd => {
        if(cmd.type === "text"){
            ctx.fillStyle = "black";
            ctx.font = fontSize(cmd.font, cmd.mx, cmd.my) + "px monospace";
            ctx.textBaseline = "top";
            ctx.fillText(cmd.text, cmd.x, cmd.y);
        }

        if(cmd.type === "barcode"){
            drawBarcode(cmd.x, cmd.y, cmd.height);
        }
    });

    ctx.strokeStyle = "black";
    ctx.lineWidth = 2;
    ctx.strokeRect(0, 0, labelWidth, labelHeight);
}

function fitScreen(){
    const sx = viewer.clientWidth / labelWidth;
    const sy = viewer.clientHeight / labelHeight;
    zoom = Math.min(sx, sy) * 0.9;

    offsetX = (viewer.clientWidth - labelWidth * zoom) / 2;
    offsetY = (viewer.clientHeight - labelHeight * zoom) / 2;

    renderLabel();
}

function zoomIn(){
    zoom *= 1.2;
    renderLabel();
}

function zoomOut(){
    zoom /= 1.2;
    renderLabel();
}

function getLabelSize() {
    const mode = document.getElementById("sizeMode").value;
    const dpi = parseFloat(document.getElementById("dpi").value) || 203;

    let width = parseFloat(document.getElementById("widthValue").value) || 831;
    let height = parseFloat(document.getElementById("heightValue").value) || 240;

    if (mode === "dots") {
        return { width, height };
    }

    if (mode === "cm") {
        return {
            width: Math.round((width * dpi) / 2.54),
            height: Math.round((height * dpi) / 2.54)
        };
    }

    return {
        width: labelWidth,
        height: labelHeight
    };
}

canvas.addEventListener("mousedown", e => {
    dragging = true;
    dragX = e.clientX;
    dragY = e.clientY;
});

window.addEventListener("mouseup", () => dragging = false);

window.addEventListener("mousemove", e => {
    if(!dragging) return;

    offsetX += e.clientX - dragX;
    offsetY += e.clientY - dragY;

    dragX = e.clientX;
    dragY = e.clientY;

    renderLabel();
});

canvas.addEventListener("wheel", e => {
    e.preventDefault();

    if(e.deltaY < 0) zoom *= 1.1;
    else zoom /= 1.1;

    renderLabel();
}, { passive: false });

window.addEventListener("resize", fitScreen);

// Inicialização
setTimeout(fitScreen, 100);
</script>

</body>
</html>