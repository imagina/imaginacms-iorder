<?php

return [
  'list resource' => 'Listar suministros',
  'create resource' => 'Crear suministros',
  'edit resource' => 'Editar suministros',
  'destroy resource' => 'Eliminar suministros',
  'title' => [
    'supplies' => 'Suministro',
    'create supply' => 'Crear un suministro',
    'edit supply' => 'Editar un suministro',
    'createdEvent' => 'Nueva orden generada a tu nombre',
    'updatedEvent' => 'Estado de tu orden #:id',
    'orderRemind' => 'Tienes :count órdenes pendientes por revisar',
    'adminOrderRemind' => ':count órdenes en espera de respuesta del proveedor',
    'checkOrder' => ':count órdenes en espera de tu revisión'
  ],
  'button' => [
    'create supply' => 'Crear un suministro',
  ],
  'table' => [
  ],
  'form' => [
  ],
  'messages' => [
    'createdEvent' => 'Hola :userName,
    Esperamos que este mensaje te encuentre bien. Queremos informarte que se ha generado una nueva orden con el número #:id a tu nombre.
    Por favor, ingresa al siguiente enlace para aceptar o rechazar la orden:',
    'updatedEvent' => 'Hola :userName,
    Queremos informarte que el estado de tu orden #:id ha cambiado a :status.',
    'orderRemind' => 'Te informamos que tienes :count órdenes pendientes de revisión. Por favor, ingresa a la aplicación para verificar cuáles te faltan por revisar.',
    'adminOrderRemind' => 'Te informamos que hay :count órdenes en espera de respuesta por parte del proveedor.',
    'checkOrder' => 'Te informamos que actualmente hay :count órdenes en espera de revisión de tu parte. Puedes ingresar a la aplicación para ver y gestionar las órdenes pendientes.'
  ],
  'validation' => [
  ],
  'settings' => [
    'usersToNotify' => 'Usuarios a Notificar',
    'helpUsersToNotify' => 'Selecciona los usuarios que serán notificados cuando haya cambios en el estado de las órdenes. Por defecto, se notificará al usuario que creó la orden.',
    'hoursToNotify' => 'Intervalo de Comprobación (Horas)',
    'helpHoursToNotify' => 'Especifica el tiempo en horas para comprobar los cambios en el estado de las órdenes. Este proceso se ejecuta una vez al día y se basa en la fecha de creación de la orden.',
  ]
];
