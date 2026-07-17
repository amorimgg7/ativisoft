<?php

require 'functions.php';

$id = $_GET['id'];

$arquivo =
    "../dados/simulados/$id.json";

$perguntas = [];

if (file_exists($arquivo))
{
    $perguntas =
        json_decode(
            file_get_contents($arquivo),
            true
        );
}
?>

<h1>
Perguntas
</h1>

<a
href="simulados.php">
Voltar
</a>

<hr>

<form
method="post"
action="salvar_pergunta.php"
>

<input
type="hidden"
titulo="simulado"
value="<?= $id ?>"
>

Categoria:

<input
titulo="categoria"
required
>

<br><br>

Pergunta:

<textarea
titulo="pergunta"
required
></textarea>

<br><br>

A:

<input
titulo="a"
required
>

<br><br>

B:

<input
titulo="b"
required
>

<br><br>

C:

<input
titulo="c"
required
>

<br><br>

D:

<input
titulo="d"
required
>

<br><br>

Resposta correta:

<select
titulo="correta"
>
<option value="0">A</option>
<option value="1">B</option>
<option value="2">C</option>
<option value="3">D</option>
</select>

<br><br>

Explicação:

<textarea
titulo="explicacao"
></textarea>

<br><br>

<button>
Salvar Pergunta
</button>

</form>

<hr>

<?php foreach ($perguntas as $p): ?>

<div>

<h3>
<?= $p['pergunta'] ?>
</h3>

<p>
Categoria:
<?= $p['categoria'] ?>
</p>

<a
href="excluir_pergunta.php?id=<?= $id ?>&pergunta=<?= $p['id'] ?>">
Excluir
</a>

</div>

<hr>

<?php endforeach; ?>