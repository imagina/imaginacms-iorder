<?php

return [
  'name' => 'Iorder',
  'frontendModuleName' => 'qorder',

  'synchronizable' => [
    'entities' => [
      'iorder_syncOrders' => [
        'base_template_id' => '1LeggrpfqCiM8f7MnK5mSMWuqFZonm-WcpAP7zWs5r1k',
        'apiRoute' => '/iorder/v3/orders',
        "supportedActions" =>  ["import"],
        'sheetName' => 'Orders',
        'customColumns' => true,
        'dependencies' => [
          'iorder_syncProvider' => [
            'apiRoute' => '/profile/v1/users',
            'sheetName' => 'Provider',
            'requestParams' => [
              'filter' => ['roleId' => 6]
            ],
            'columns' => [
              'id' => 'ID',
              'fullName' => 'NOMBRE'
            ]
          ],
          'iorder_syncProduct' => [
            'apiRoute' => '/iproduct/v1/products',
            'sheetName' => 'Product',
            'columns' => [
              'id' => 'ID',
              'title' => 'NOMBRE'
            ]
          ]
        ]
      ]
    ]
  ],

  'exportable' => [
    'orders' => [
      'moduleName' => 'Iorder',
      'fileName' => 'Orders Supply',
      'exportName' => 'OrderItemsExport',
    ]
  ],
];
