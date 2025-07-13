<?php

use Hanafalah\ModuleDisease\{
    Models as ModuleDisease,
    Contracts
};

return [
    'namespace' => 'Hanafalah\\ModuleDisease',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database'                      => [
        'models'                    => [
        ]
    ],
];
