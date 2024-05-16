<?php 

// Format rupiah
function formatRupiah($nominal, $prefix = false)
{
    $nominal = floatval($nominal); // Konversi ke tipe data float
    if ($prefix) {
        return "Rp." . number_format($nominal, 0, ',', '.');
    }
    return number_format($nominal, 0, ',', '.'); 
}

// Set Sidebar Item Active

function setActive(array $route)
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r)) {
                return 'active';
            }
        }
    }
}

