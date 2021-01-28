<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TopicRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Device;
use App\Models\Topic;
use App\Models\Client;

/**
 * Class TopicCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TopicCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Topic');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/topic');
        $this->crud->setEntityNameStrings('log', 'Logs');
        $this->crud->addButtonFromView('line', 'view_clients', 'view_client_log', 'beginning');

    }

    protected function setupListOperation()
    {
        $this->crud->removeButton('show');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('update');
        $this->crud->removeButton('create');
        $this->crud->disablePersistentTable();
        $types = Device::all()->pluck('name');
        $topics = Topic::distinct('message')->pluck('message');
        $clients = Client::pluck('client_id');

        $this->crud->addFilter(
            [
                'name' => 'device',
                'type' => 'dropdown',
                'label' => 'Device Type'
            ],
            json_decode($types),
            function ($value) {
                $devId = Device::where('name', $value)->get()->pluck('id');
                if (sizeof($devId) > 0) {

                    $this->crud->addClause('where', 'device_id', 'LIKE', "%$devId[0]%");
                } // if the filter is active
                else {
                    $array = Device::all()->pluck('name');
                    $value = $array[$value];
                    $devId = Device::where('name', $value)->get()->pluck('id');
                    $this->crud->addClause('where', 'device_id', 'LIKE', "%$devId[0]%");
                }
            }
        );
        $this->crud->addFilter(
            [
                'name' => 'client_id',
                'type' => 'dropdown',
                'label' => 'Client ID'
            ],
            json_decode($clients),
            function ($value) {
                $clients = Client::pluck('client_id');

                $this->crud->addClause('where', 'client_id', $clients[$value]);

            }
        );
        $this->crud->addFilter(
            [
                'name' => 'topic',
                'type' => 'dropdown',
                'label' => 'Topic'
            ],
            json_decode($topics),
            function ($value) {
                $topics = Topic::distinct('message')->pluck('message')->take(10);
                $this->crud->addClause('where', 'message', $topics[$value]);

            }
        );
        // $this->crud->addFilter(
        //     [
        //         'type' => 'Text',
        //         'name' => 'client',
        //         'label' => 'CLIENT_ID',
        //         'persistent-table' => 'false'
        //     ],
        //     'false', // the simple filter has no values, just the "Draft" label specified above
        //     function ($value) { // if the filter is active (the GET parameter "draft" exits)
        //         $this->crud->addClause('whereIn', 'client_id', explode(",", $value));
        //     }
        // );
        $this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'created_at',
            'label' => 'Date range'
          ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                 $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                 $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
            });

        $this->crud->addFilter(
            [
                'type' => 'Text',
                'name' => 'id',
                'label' => 'ID',
                'persistent-table' => 'false'
            ],
            'false', // the simple filter has no values, just the "Draft" label specified above
            function ($value) { // if the filter is active (the GET parameter "draft" exits)
                $this->crud->addClause('whereIn', 'id', explode(",", $value));
            }
        );

        // $this->crud->addFilter(
        //     [
        //         'type' => 'log_filter',
        //         'name' => 'value',
        //         'label' => 'Value'
        //     ],
        //     'false', // the simple filter has no values, just the "Draft" label specified above
        //     function ($value) { // if the filter is active (the GET parameter "draft" exits)
        //         $devId = Device::where('name', $value)->get()->pluck('id');
        //         $this->crud->addClause('where', 'device_id', 'LIKE', "%$devId[0]%");
        //     }
        // );
        $this->crud->addFilter([
            'name' => 'number',
            'type' => 'range',
            'label'=> 'Range',
            'label_from' => 'min value',
            'label_to' => 'max value'
          ],
          false,
          function($value) { // if the filter is active
                      $range = json_decode($value);
                      if ($range->from) {
                          $this->crud->query->whereRaw('value >= ?',(float) $range->from);

                      }
                      if ($range->to) {
                        $this->crud->query->whereRaw('value <= ?',(float) $range->to);

                      }
          });
        $this->crud->setFromDb();
        $this->crud->addColumn([
            'name' => 'id', // The db column name
            'label' => "id", // Table column heading
            // 'prefix' => "Name: ",
            // 'suffix' => "(user)",
            // 'limit' => 120, // character limit; default is 50;
         ]);
        $this->crud->addColumn([
            'name' => 'client_id', // The db column name
            'label' => "Client", // Table column heading
            // 'prefix' => "Name: ",
            // 'suffix' => "(user)",
            // 'limit' => 120, // character limit; default is 50;
         ]);
$this->crud->addColumn([
    'name' => 'message', // The db column name
    'label' => "Topic", // Table column heading
    // 'prefix' => "Name: ",
    // 'suffix' => "(user)",
    // 'limit' => 120, // character limit; default is 50;
 ]);
 $this->crud->addColumn([
    'name' => 'value', // The db column name
    'label' => "Value", // Table column heading
    'orderable' => true,
    'orderLogic' => function ($query, $column, $columnDirection) {
         return $query->orderBy('value', $columnDirection);
     }
    // 'prefix' => "Name: ",
    // 'suffix' => "(user)",
    // 'limit' => 120, // character limit; default is 50;
 ]);
 $this->crud->addColumn([
    'name' => 'created_at', // The db column name
    'label' => "Date", // Table column heading
    // 'prefix' => "Name: ",
    // 'suffix' => "(user)",
    // 'limit' => 120, // character limit; default is 50;
 ]);

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(TopicRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
