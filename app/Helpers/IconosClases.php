<?php

if (!function_exists('iconoClase')) {
    function iconoClase($nombreClase)
    {
        $nombreClase = strtolower($nombreClase);

        $iconos = [
            'yoga' => '🧘',
            'pilates' => '🤸',
            'gap' => '🏋️‍♂️',
            'hiit' => '🔥',
            'zumba' => '💃',
            'spinning' => '🚴',
            'circuito' => '🔁',
            'boxeo' => '🥊',
            'kickboxing' => '🥋',
            'dance' => '🕺',
            'core' => '🧘‍♂️',
            'funcional' => '🤾',
            'estiramientos' => '🧎',
            'cardio' => '🏃',
            'musculación' => '🏋️‍♀️',
            'crossfit' => '🏋️‍♂️',
            'pump' => '🏋️',
            'aerobic' => '🎶',
            'balance' => '⚖️',
        ];

        foreach ($iconos as $clave => $icono) {
            if (str_contains($nombreClase, $clave)) {
                return $icono;
            }
        }

        return '🏋️'; // icono por defecto
    }
}
