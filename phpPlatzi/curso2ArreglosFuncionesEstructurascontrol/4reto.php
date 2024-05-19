<?php

$michis = [
    "Michi1" => [
        "name" => "Michi1",
        "ocupación" => 1,
        "color" => "blanco",
        "comidas" => [
                        "favoritas" => [
                            "atun"=> "atún",
                            "pollo" => "pollo",
                            "pescado" => "pescado"
                        ],
                        "noFavoritas" => [
                            "zanahoria" => "zanahoria",
                            "lechuga" => "lechuga",
                            "espinaca" => "espinaca"
                        ]
                    ]

    ],
    "Michi2" => [
        "name" => "Michi1",
        "ocupación" => 1,
        "color" => "blanco",
        "comidas" => [
                        "favoritas" => [
                            "atun"=> "atún",
                            "pollo" => "pollo",
                            "pescado" => "pescado"
                        ],
                        "noFavoritas" => [
                            "zanahoria" => "zanahoria",
                            "lechuga" => "lechuga",
                            "espinaca" => "espinaca"
                        ]
                    ]

    ],
    "Michi3" => [
        "name" => "Michi1",
        "ocupación" => 1,
        "color" => "blanco",
        "comidas" => [
                        "favoritas" => [
                            "atun"=> "atún",
                            "pollo" => "pollo",
                            "pescado" => "pescado"
                        ],
                        "noFavoritas" => [
                            "zanahoria" => "zanahoria",
                            "lechuga" => "lechuga",
                            "espinaca" => "espinaca"
                        ]
                    ]

    ]

                        
];

echo "El color del michi1 es: {$michis['Michi1']['color']}\n";
echo "La comida favorita del michi2 es: {$michis['Michi2']['comidas']['favoritas']['atun']}\n";
?>