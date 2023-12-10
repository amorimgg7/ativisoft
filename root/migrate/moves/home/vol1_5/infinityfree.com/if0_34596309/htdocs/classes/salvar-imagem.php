<?php
    if ($_FILES["imagem"]["error"] == UPLOAD_ERR_OK) {
	    $nome_arquivo = $_FILES["imagem"]["name"];
		$caminho_arquivo = "C:\xampp\htdocs\_1_1_sistema\images\foto" . $nome_arquivo;
		move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminho_arquivo);
		// aqui você pode salvar o caminho do arquivo no banco de dados do usuário
	}
															?>