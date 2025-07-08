<?php
function sanitizarTexto($valor)
{
    return htmlspecialchars(trim($valor));
}

function formatarData($data)
{
    return date("d/m/Y", strtotime($data));
}

function formatarHora($hora)
{
    return date("H:i", strtotime($hora));
}
