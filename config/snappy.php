<?php

return [
    'app' => [
        'default' => [
            'model' => [
                'shop' => [
                    'distance' => [
                        'default_max'              => 1000,
                        'radius_of_earth_in_miles' => 3959,
                        'metres_per_mile'          => 1609.34,
                    ],
                    'status' => [
                        'closed' => 'closed',
                        'open'   => 'open',
                    ],
                    'type' => [
                        'restuarant' => 'restuarant',
                        'shop'       => 'shop',
                        'takeaway'   => 'takeaway',
                    ]
                ]
            ]
        ]
    ],
];