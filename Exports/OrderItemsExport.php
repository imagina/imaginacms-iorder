<?php

namespace Modules\Iorder\Exports;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;

//Events
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;


//Extra
use Modules\Notification\Services\Inotification;
use Modules\Icommerce\Entities\OrderItem;
use Modules\Icommerce\Transformers\OrderTransformer;

use Modules\Isite\Traits\ReportQueueTrait;

class OrderItemsExport implements FromQuery, WithEvents, ShouldQueue, WithMapping, WithHeadings
{
  use Exportable, ReportQueueTrait;

  private $params;
  private $exportParams;
  private $inotification;
  private $service;

  public function __construct($params, $exportParams)
  {
    $this->userId = \Auth::id();//Set for ReportQueue
    $this->params = $params;
    $this->exportParams = $exportParams;
  }

  /**
   * @return \Illuminate\Support\Collection
   */
  public function query(): \Illuminate\Database\Eloquent\Builder
  {
    //Init Repo
    $repository = app("Modules\\Iorder\\Repositories\\ItemRepository");
    $this->params->returnAsQuery = true;
    $this->params->include = ['suppliers.supplier'];
    //Get query
    $query = $repository->getItemsBy($this->params);
    //Response
    return $query;
  }

  /**
   * Table headings
   *
   * @return string[]
   */
  public function headings(): array
  {
    return [
      'id',
      'Producto',
      'Proveedor',
      'Precio Proveedor',
      'Unidades Disponibles',
      'Precio Base',
      'Unidades Solicitadas',
      'Estado',
      'Observaciones',
      'Fecha de Creación',
      'Fecha Ultima Actualización'
    ];
  }

  /**
   * @var Invoice
   */
  public function map($item): array
  {

//    'fields' => [
//    'id',
//    'product.title',
//    'suppliers.supplier.first_name',
//    'suppliers.price',
//    'suppliers.quantity',
//    'price',
//    'quantity',
//    'status.title',
//    'suppliers.comment',
//    'created_at',
//    'updated_at'
//  ]
    $suppliers = $item->suppliers->first() ?? null;

    $supplier = null;
    if(isset($suppliers)) {
      $supplier= $suppliers->supplier->first() ?? null;
    }

    //Map data
    return [
      $item->id ?? null,
      $item->title ?? null,
      isset($supplier) ? $supplier->present()->fullName() : null,
      $suppliers->price ?? null,
      $suppliers->quantity ?? null,
      $item->price ?? null,
      $item->quantity ?? null,
      $item->status->title ?? null,
      $suppliers->comment ?? null,
      $item->created_at ?? null,
      $item->updated_at ?? null,
    ];
  }

  /**
   * //Handling Events
   */
  public function registerEvents(): array
  {
    return [
      // Event gets raised at the start of the process.
      BeforeExport::class => function (BeforeExport $event) {
        $this->lockReport($this->exportParams->exportName);
      },
      // Event gets raised before the download/store starts.
      BeforeWriting::class => function (BeforeWriting $event) {
      },
      // Event gets raised just after the sheet is created.
      BeforeSheet::class => function (BeforeSheet $event) {
      },
      // Event gets raised at the end of the sheet process
      AfterSheet::class => function (AfterSheet $event) {
        $this->unlockReport($this->exportParams->exportName);
        //Send pusher notification
        app('Modules\Notification\Services\Inotification')->to(['broadcast' => $this->params->user->id])->push([
          'title' => 'New report',
          'message' => 'Your report is ready!',
          'link' => url(''),
          'isAction' => true,
          'frontEvent' => [
            'name' => 'isite.export.ready',
            'data' => $this->exportParams,
          ],
          'setting' => ['saveInDatabase' => 1],
        ]);
      },
    ];
  }
}
