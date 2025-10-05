<?php

//get department type
$raw = App\Department::whereIn('type', ['consulate'])->get();
$embassies = $raw->pluck('name_en')->toArray();
// dd($embassies);

$oemb = [];

foreach ($embassies as $em) {
    $full = trim(substr($em, 56));
    $tokenized = explode(' ', $full);

    if (count($tokenized) == 1) {
        $oemb[$em] = 'C'.strtoupper(substr($full, 0, 4));

        continue;
    }

    if (count($tokenized) == 2) {
        $token = '';
        foreach ($tokenized as $t) {
            $token .= strtoupper(substr($t, 0, 3));
        }
        $oemb[$em] = 'C'.$token;

        continue;
    }

    if (count($tokenized) > 2) {
        $token = '';
        foreach ($tokenized as $t) {
            if (in_array($t, ['in', 'at', 'and', 'of'])) {
                continue;
            }
            $token .= strtoupper(substr($t, 0, 2));
        }
        $oemb[$em] = 'C'.$token;

        continue;
    }
}

foreach ($raw as $em) {
    $em->update([
        'code' => $oemb[$em->name_en],
        'name_en' => str_replace('Repulic', 'Republic', $em->name_en),
    ]);
}
