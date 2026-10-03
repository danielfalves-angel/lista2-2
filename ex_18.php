<?php

function ordenarPorHorario($consultas) {
    $total = count($consultas);
    for ($i = 0; $i < $total - 1; $i++) {
        for ($j = 0; $j < $total - $i - 1; $j++) {
            if ($consultas[$j]['horario'] > $consultas[$j + 1]['horario']) {
                $temp = $consultas[$j];
                $consultas[$j] = $consultas[$j + 1];
                $consultas[$j + 1] = $temp;
            }
        }
    }
    return $consultas;
}

function contarPacientesUnicos($consultas) {
    $pacientes = [];
    for ($i = 0; $i < count($consultas); $i++) {
        $nome = $consultas[$i]['paciente'];
        if (!in_array($nome, $pacientes)) {
            $pacientes[] = $nome;
        }
    }
    return count($pacientes);
}

function contarPorEspecialidade($consultas) {
    $especialidades = [];
    for ($i = 0; $i < count($consultas); $i++) {
        $esp = $consultas[$i]['especialidade'];
        if (isset($especialidades[$esp])) {
            $especialidades[$esp]++;
        } else {
            $especialidades[$esp] = 1;
        }
    }
    return $especialidades;
}

function pesquisarPaciente($consultas, $nomeBuscado) {
    for ($i = 0; $i < count($consultas); $i++) {
        if (strtolower($consultas[$i]['paciente']) == strtolower($nomeBuscado)) {
            return "Encontrado (" . $consultas[$i]['especialidade'] . " às " . $consultas[$i]['horario'] . ")";
        }
    }
    return "Paciente não encontrado";
}

function verificarHorariosDuplicados($consultas) {
    $horarios = [];
    for ($i = 0; $i < count($consultas); $i++) {
        $chave = $consultas[$i]['data'] . " " . $consultas[$i]['horario'];
        if (in_array($chave, $horarios)) {
            return "Sim, existem conflitos de horário";
        }
        $horarios[] = $chave;
    }
    return "Não existem horários duplicados";
}

function obterPrimeiroEUltimo($consultasOrdenadas) {
    $total = count($consultasOrdenadas);
    return [
        "primeiro" => $consultasOrdenadas[0]['paciente'] . " às " . $consultasOrdenadas[0]['horario'],
        "ultimo" => $consultasOrdenadas[$total - 1]['paciente'] . " às " . $consultasOrdenadas[$total - 1]['horario']
    ];
}

function organizarAgenda($consultas, $pacienteBusca) {
    $ordenadas = ordenarPorHorario($consultas);
    $extremos = obterPrimeiroEUltimo($ordenadas);

    return [
        "total_consultas"     => count($consultas),
        "pacientes_unicos"    => contarPacientesUnicos($consultas),
        "por_especialidade"   => contarPorEspecialidade($consultas),
        "primeiro_atendimento"=> $extremos["primeiro"],
        "ultimo_atendimento"  => $extremos["ultimo"],
        "agenda_ordenada"     => $ordenadas,
        "pesquisa_paciente"   => pesquisarPaciente($consultas, $pacienteBusca),
        "horarios_duplicados" => verificarHorariosDuplicados($consultas)
    ];
}

$agenda = [
    ["paciente" => "Carlos", "especialidade" => "Cardiologia", "data" => "2026-10-10", "horario" => "14:00"],
    ["paciente" => "Ana",    "especialidade" => "Dermatologia", "data" => "2026-10-10", "horario" => "09:00"],
    ["paciente" => "Maria",  "especialidade" => "Cardiologia", "data" => "2026-10-10", "horario" => "10:30"],
    ["paciente" => "Ana",    "especialidade" => "Pediatria",   "data" => "2026-10-10", "horario" => "16:00"]
];

$resultado = organizarAgenda($agenda, "Ana");

echo "total de consultas: " . $resultado["total_consultas"] . "<br>";
echo "pacientes diferentes: " . $resultado["pacientes_unicos"] . "<br>";
echo "primeiro atendimento: " . $resultado["primeiro_atendimento"] . "<br>";
echo "último atendimento: " . $resultado["ultimo_atendimento"] . "<br>";
echo "pesquisa (Ana): " . $resultado["pesquisa_paciente"] . "<br>";
echo "conflitos de horário: " . $resultado["horarios_duplicados"] . "<br><br>";

echo "consultas por especialidade:<br>";
foreach ($resultado["por_especialidade"] as $esp => $qtd) {
    echo "- $esp: $qtd<br>";
}

echo "<br>lista de horários ordenados:<br>";
for ($i = 0; $i < count($resultado["agenda_ordenada"]); $i++) {
    $c = $resultado["agenda_ordenada"][$i];
    echo $c["horario"] . " - " . $c["paciente"] . " (" . $c["especialidade"] . ")<br>";
}