<?php
function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se tem 11 dígitos e não é uma sequência repetida (ex: 111.111.111-11)
    if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }

    // Validação dos dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }

    return true;
}

// Captura o CPF da URL (ex: ?cpf=123.456.789-09)
$cpf = $_GET['cpf'] ?? '';

if ($cpf) {
    $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);

    if (validarCPF($cpfLimpo)) {
        echo "<p>✅ CPF válido: " . maskCPF($cpfLimpo) . "</p>";
    } else {
        echo "<p>❌ CPF inválido.</p>";
    }
} else {
    echo "<p>Nenhum CPF fornecido.</p>";
}

// Função opcional para formatar o CPF como 123.456.789-09
function maskCPF($cpf) {
    return substr($cpf, 0, 3) . '.' .
           substr($cpf, 3, 3) . '.' .
           substr($cpf, 6, 3) . '-' .
           substr($cpf, 9, 2);
}
?>