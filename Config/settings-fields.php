<?php

return [
  //Users to notify
  'usersToNotify' => [
    "onlySuperAdmin" => true,
    'name' => 'iorder::usersToNotify',
    'value' => [],
    'type' => 'select',
    'help' => [
      'description' => 'iorder::supplies.settings.helpUsersToNotify',
    ],
    'props' => [
      'label' => 'iorder::supplies.settings.usersToNotify',
      'multiple' => true,
      'useChips' => true,
    ],
    'loadOptions' => [
      'filterByQuery' => true,
      'apiRoute' => 'apiRoutes.quser.users',
      'select' => ['label' => 'fullName', 'id' => 'id']
    ]
  ],
  //Hours limit to notify
  'hoursToNotify' => [
    "onlySuperAdmin" => true,
    'name' => 'iorder::hoursToNotify',
    'value' => 0,
    'type' => 'input',
    'help' => [
      'description' => 'iorder::supplies.settings.helpHoursToNotify',
    ],
    'props' => [
      'type' => 'number',
      'label' => 'iorder::supplies.settings.hoursToNotify',
    ]
  ],
];
