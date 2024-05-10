<?php 

function formatRupiah($nominal, $prefix = false)
{
    $nominal = floatval($nominal); // Konversi ke tipe data float
    if ($prefix) {
        return "Rp." . number_format($nominal, 0, ',', '.');
    }
    return number_format($nominal, 0, ',', '.'); 
}
