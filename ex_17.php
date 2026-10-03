<?php

function limparTexto($texto) {
    $limpo = trim($texto);
    while (strpos($limpo, "  ") !== false) {
        $limpo = str_replace("  ", " ", $limpo);
    }
    return $limpo;
}

function contarFrases($texto) {
    $qtd = 0;
    for ($i = 0; $i < strlen($texto); $i++) {
        $c = $texto[$i];
        if ($c == '.' || $c == '!' || $c == '?') {
            $qtd++;
        }
    }

    if ($qtd == 0 && strlen(trim($texto)) > 0) {
        return 1;
    }
    return $qtd;
}

function buscarTamanhosPalavras($palavras) {
    $maior = $palavras[0];
    $menor = $palavras[0];

    for ($i = 0; $i < count($palavras); $i++) {
        $p = $palavras[$i];
        if (strlen($p) > strlen($maior)) {
            $maior = $p;
        }
        if (strlen($p) < strlen($menor)) {
            $menor = $p;
        }
    }

    return ["maior" => $maior, "menor" => $menor];
}

function contarRepetidas($frequencia) {
    $repetidas = 0;
    foreach ($frequencia as $palavra => $qtd) {
        if ($qtd > 1) {
            $repetidas++;
        }
    }
    return $repetidas;
}

function obterTop5Palavras($frequencia) {
    arsort($frequencia);
    $top5 = [];
    $contador = 0;

    foreach ($frequencia as $palavra => $qtd) {
        if ($contador < 5) {
            $top5[$palavra] = $qtd;
            $contador++;
        } else {
            break;
        }
    }
    return $top5;
}

function formatarTextoMaiusculas($texto) {
    return ucwords(strtolower($texto));
}

function processarTexto($textoOriginal) {
    $textoLimpo = limparTexto($textoOriginal);

    $textoSemPontuacao = str_replace([".", ",", "!", "?", ";", ":"], "", strtolower($textoLimpo));
    $palavras = explode(" ", $textoSemPontuacao);

    $frequencia = array_count_values($palavras);

    $tamanhos = buscarTamanhosPalavras($palavras);
    $qtdFrases = contarFrases($textoOriginal);
    $qtdRepetidas = contarRepetidas($frequencia);
    $top5 = obterTop5Palavras($frequencia);
    $textoFormatado = formatarTextoMaiusculas($textoLimpo);

    return [
        "caracteres" => strlen($textoOriginal),
        "palavras" => count($palavras),
        "frases" => $qtdFrases,
        "mais_longa" => $tamanhos["maior"],
        "mais_curta" => $tamanhos["menor"],
        "qtd_repetidas" => $qtdRepetidas,
        "top_5" => $top5,
        "texto_limpo" => $textoLimpo,
        "texto_formatado" => $textoFormatado
    ];
}

$texto = "eu gosto curso curso da escola SESI SENAI e do curso de DS, minha turma é a DSM1/2024";
$resultado = processarTexto($texto);

echo "quantidade de caracteres: " . $resultado["caracteres"] . "<br>";
echo "quantidade de palavras: " . $resultado["palavras"] . "<br>";
echo "quantidade de frases: " . $resultado["frases"] . "<br>";
echo "palavra mais longa: " . $resultado["mais_longa"] . "<br>";
echo "palavra mais curta: " . $resultado["mais_curta"] . "<br>";
echo "quantidade de palavras repetidas: " . $resultado["qtd_repetidas"] . "<br>";

echo "texto sem espaços duplicados: " . $resultado["texto_limpo"] . "<br>";
echo "texto formatado: " . $resultado["texto_formatado"] . "<br>";

echo "<br>top 5 palavras mais frequentes:<br>";
foreach ($resultado["top_5"] as $palavra => $qtd) {
    echo "- $palavra: $qtd vezes<br>";
}