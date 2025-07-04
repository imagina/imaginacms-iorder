<?php

return [
  'name' => 'Iorder',
  'frontendModuleName' => 'qorder',

  'synchronizable' => [
    'entities' => [
      'iorder_syncOrders' => [
        'base_template_id' => '1zjXQKs7DIPiN51wu-n_asQuEkiErn5FVKaEjANn25pI',
        'apiRoute' => '/iorder/v1/orders',
        "supportedActions" =>  ["import"],
        'sheetName' => 'Órdenes',
        'customColumns' => true,
        'dependencies' => [
          'iorder_syncProvider' => [
            'apiRoute' => '/profile/v1/users',
            'sheetName' => 'Proveedor',
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
            'sheetName' => 'Producto',
            'requestParams' => [
              /*'filter' => [
                'updatedAt' => [
                  'where' => 'date',
                  'operator' => '>=',
                  'value' => date('Y-m-d')
                ]
              ]*/
            ],
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
