<?php

return [
  "sidebar" => [
    "adminGroup" => "Orders",
    "adminOrders" => "Orders",
    "adminSupplies" => "Supplies",
  ],
  "label" => [
    "refuse" => "Reject",
    "refuseOrder" => "Reject Order",
    "refuseMessage" => "Do you want to permanently reject this order? Once rejected, there is no going back. Please make sure.",
    "accept" => "Accept",
    "acceptOrder" => "Accept Order",
    "acceptMessage" => "Do you want to accept this order? Please ensure the units and price are correct.",
    "suppliesHelp" => "This module allows you to manage orders=> review, edit quantities or prices if needed, and decide whether to accept or reject them. Make sure to verify the details before confirming."
  ],
  "form" => [
    "order" => "Order",
    "orderId" => "# Order",
    "supplier" => "Supplier",
    "suppliers" => "Suppliers",
    "price" => "Price",
    "supplierPrice" => "Supplier Price",
    "requestedQuantity" => "Requested Units",
    "avaliableQuantity" => "Available Units",
    "requestedAndAvaliableQuantity" => "Requested/Available Units",
    "observations" => "Observations",
    "total" => "Total",
    "beforeUpdate" => [
      "invalidPrice" => "Enter a valid price.",
      "invalidQuantity" => "Enter a valid quantity.",
      "invalidAvaliableQuantity" => "The number of available units must be less than the requested units."
    ]
  ],
  "orderManagement" => "Orders",
  "suppliesManagement" => "Supplies",
];
