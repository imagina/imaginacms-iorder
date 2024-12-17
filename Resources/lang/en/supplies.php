<?php

return [
  'list resource' => 'List supplies',
  'create resource' => 'Create supplies',
  'edit resource' => 'Edit supplies',
  'destroy resource' => 'Destroy supplies',
  'title' => [
    'supplies' => 'Supply',
    'create supply' => 'Create a supply',
    'edit supply' => 'Edit a supply',
    'createdEvent' => 'New Order Assigned to You',
    'updatedEvent' => 'Status of Your Order #:id',
    'orderRemind' => 'You have :count pending orders to review',
    'adminOrderRemind' => ':count orders awaiting supplier response',
    'checkOrder' => ':count orders pending your review'
  ],
  'button' => [
    'create supply' => 'Create a supply',
  ],
  'table' => [
  ],
  'form' => [
  ],
  'messages' => [
    'createdEvent' => 'Hello :userName,
    We hope this message finds you well. We want to inform you that a new order with the number #:id has been assigned to you.
    Please click the following link to accept or decline the order:',
    'updatedEvent' => 'Hello :userName,
    We want to inform you that the status of your order #:id has changed to $:status.',
    'orderRemind' => 'We inform you that you have :count pending orders to review. Please log in to the application to verify which ones are still pending review.',
    'adminOrderRemind' => 'We inform you that there are :count orders awaiting supplier response.',
    'checkOrder' => 'We inform you that there are currently :count orders pending your review. You can log into the application to view and manage the pending orders.'
  ],
  'validation' => [
  ],
  'settings' => [
    'usersToNotify' => 'Users to Notify',
    'helpUsersToNotify' => 'Select the users who will be notified when there are order status changes. By default, the user who created the order will be notified.',
    'hoursToNotify' => 'Notification Check Interval (Hours)',
    'helpHoursToNotify' => 'Specify the number of hours to check for order status updates. This process runs once daily and is based on the order creation date.'
  ]
];
