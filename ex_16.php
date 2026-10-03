<?php
function contarMaiusculas($senha) {
    $quantidade = 0;
    for ($i = 0; $i < strlen($senha); $i++) {
        if ($senha [$i] >= 'A' && $senha[$i] <= 'Z') {
            $quantidade++;
        }
    }
    return $quantidade;
}

function contarMinusculas($senha) {
    $quantidade = 0;
    for ($i = 0; $i < strlen($senha); $i++) {
        if ($senha[$i] >= 'a' && $senha[$i] <= 'z') {
            $quantidade++;
        }
    }
    return $quantidade;
}

function contarNumeros($senha) {
    $quantidade = 0;
    for ($i = 0; $i < strlen($senha); $i++) {
        if ($senha[$i] >= '0' && $senha[$i] <= '9') {
            $quantidade++;
        }
    }
    return $quantidade;
}

function contarEspeciais($senha) {
    $quantidade = 0;
    for ($i = 0; $i < strlen($senha); $i++) {
        $c = $senha[$i];
        if (!($c >= 'A' && $c <= 'Z') && !($c >= 'a' && $c <= 'z') && !($c >= '0' && $c <= '9')) {
            $quantidade++;
        }
    }
    return $quantidade;
}

function classificarSenha($tamanho, $maiusculas, $minusculas, $numeros, $especiais) {
    if ($tamanho < 8) {
        return "Fraca";
    }
    $tipos = 0;
        if ($maiusculas > 0) $tipos++;
        if ($minusculas > 0) $tipos++;
        if ($numeros > 0)    $tipos++;
        if ($especiais > 0)  $tipos++;

        if ($tipos == 4) {
            return "muito forte";
        } elseif ($tipos == 3) {
            return "forte";
        } elseif ($tipos == 2) {
            return "média";
        } else {
            return "fraca";
        }
}

function analisarSenha($senha) {
    $maiusculas = contarMaiusculas($senha);
    $minusculas = contarMinusculas($senha);
    $numeros    = contarNumeros($senha);
    $especiais  = contarEspeciais($senha);
    $tamanho    = strlen($senha);

    $nivel = classificarSenha($tamanho, $maiusculas, $minusculas, $numeros, $especiais);
    
    return [
        "maiusculas" => $maiusculas,
        "minusculas" => $minusculas,
        "numeros"    => $numeros,
        "especiais"  => $especiais,
        "tamanho"    => $tamanho,
        "nivel"      => $nivel
    ];
}

$resultado = analisarSenha("TungTung@123");

echo "maiusculas: " . $resultado['maiusculas'] . "<br>";
echo "minusculas: " . $resultado['minusculas'] . "<br>";
echo "numeros: " . $resultado['numeros'] . "<br>";
echo "especiais: " . $resultado['especiais'] . "<br>";
echo "tamanho: " . $resultado['tamanho'] . "<br>";
echo "nivel de segurança: " . $resultado['nivel'] . "<br>";