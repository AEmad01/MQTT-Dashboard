<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Client;
use App\Models\Device;
use App\Models\Topic;
use App\Models\clientView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientCrudController extends CrudController
{
    public $storeName;
    public $range;

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation {
        show as traitList;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation {
        show as traitShow;
    }



    public function setup()
    {
        $this->crud->setModel('App\Models\Client');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/client');
        $this->crud->setEntityNameStrings('client', 'clients');
        $this->crud->setShowView('device');
    }

    public function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->disablePersistentTable();
        $this->crud->enableExportButtons();
        $this->crud->setDefaultPageLength(1400);

        $types = Device::all()->pluck('name');

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
                'type' => 'Text',
                'name' => 'client',
                'label' => 'CLIENT_ID',
                'persistent-table' => 'false'
            ],
            'false', // the simple filter has no values, just the "Draft" label specified above
            function ($value) { // if the filter is active (the GET parameter "draft" exits)
                $this->crud->addClause('whereIn', 'client_id', explode(",", $value));
            }
        );

        $this->crud->removeButton('delete');
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('show');


        $additionalColumns = clientView::get()->pluck('topicDisplay');
        $this->crud->setColumns([]);

        if (sizeof($additionalColumns) >= 0) {
            $this->crud->addColumn([
                'name' =>  'client_id', // the db column name (attribute name)
                'label' =>  'Client ID', // the human-readable label for it
                'type' => 'text' // the kind of column to show
            ]);

            $this->crud->addColumn([
                'name' =>  'created_at', // the db column name (attribute name)
                'label' =>  'First Seen', // the human-readable label for it
                'type' => 'datetime' // the kind of column to show
            ]);


            $this->crud->addColumn([
                'name' =>  'last_seen', // the db column name (attribute name)
                'label' =>  'Last Seen', // the human-readable label for it
                'type' => 'datetime' // the kind of column to show
            ]);
            $this->crud->addColumn([
                'name' =>  'status', // the db column name (attribute name)
                'label' =>  'Status', // the human-readable label for it
                'type' => 'status', // the kind of column to show
                'orderable' => false,
                'orderLogic' => function ($query, $column, $columnDirection) {
                    dd($query->get()[0]);
                    return $query->orderBy( ucwords(str_replace('/', '-', $this->storeName)), $columnDirection);
                },
                'visible' => true,
                'searchable' => false,



            ]);
            $this->crud->addFilter([
                'type'  => 'date_range',
                'name'  => 'created_at',
                'label' => 'First Seen'
              ],
                false,
                function ($value) { // if the filter is active, apply these constraints
                    $dates = json_decode($value);
                     $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                     $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
                });

                $this->crud->addFilter([
                    'type'  => 'date_range',
                    'name'  => 'last_seen',
                    'label' => 'Last Seen'
                  ],
                    false,
                    function ($value) { // if the filter is active, apply these constraints
                        $dates = json_decode($value);
                         $this->crud->addClause('where', 'last_seen', '>=', $dates->from);
                         $this->crud->addClause('where', 'last_seen', '<=', $dates->to . ' 23:59:59');
                    });
            foreach ($additionalColumns as $add) {
                $this->storeName = $add;
                $this->crud->addFilter(
                    [
                        'type' => 'metric_filter',
                        'name' => ucwords(str_replace('/', '-', $this->storeName)),
                        'label' => ucwords(str_replace('/', '-', $this->storeName))
                    ],
                    'false', // the simple filter has no values, just the "Draft" label specified above
                    function ($value) { // if the filter is active (the GET parameter "draft" exits)
                        $devId = Device::where('name', $value)->get()->pluck('id');
                        $this->crud->addClause('where', 'device_id', 'LIKE', "%$devId[0]%");
                    }
                );
                $this->crud->addColumn([
                    'name' =>  $add, // the db column name (attribute name)
                    'label' =>  ucwords(str_replace('/', '-', $this->storeName)), // the human-readable label for it
                    'type' => 'selectTopicDisplay', // the kind of column to show
                    'orderable' => false,
                    'orderLogic' => function ($query, $column, $columnDirection) {
                        dd($query->get()[0]);
                        return $query->orderBy( ucwords(str_replace('/', '-', $this->storeName)), $columnDirection);
                    },
                    'visible' => true,
                    'searchable' => false,



                ]);

            }
        }



        $this->crud->addButtonFromView('line', 'metrics', 'metrics', 'beginning');
        $this->crud->addButtonFromView('top', 'selectTopicDisplay', 'selectTopicDisplay', 'beginning');
    }

    public function add(Request $request)
    {
        $data = $request->all();
        clientView::firstOrCreate(['topicDisplay' => $data['name']]);
        header("Refresh:0");
        return $data['name'];
    }


    public function remove(Request $request)
    {
        $data = $request->all();
        clientView::where(['topicDisplay' => $data['name']])->delete();
        return $data['name'];
    }
    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ClientRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function index()
    {
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getListView(), $this->data);
    }



    protected function showClientsForDevice($id)
    {
        $device = Device::where('id', $id)->pluck('name');
        return redirect('admin/client/?device=' . $device[0]);
    }
    public function show($id)
    {
        $clientid = $id;
        $deviceid = Client::where('id', $clientid)->pluck('device_id');


        $client_id = Client::where('id', $clientid)->pluck('client_id');
        $data[] = $deviceid;
        $topicsListen = Device::where('id', $deviceid)->pluck('topics');
        for ($i = 0; $i < count(json_decode($topicsListen[0])); $i++) {
            $topicsArray[] = json_decode($topicsListen[0])[$i]->topic;
        }

        $data[] = $this->crud->getCreateView();
        $data[] = $this->crud;
        $data[] = $client_id;
        $this->crud->fields();
        return view('device')->with('data', $data);
    }
    public function metrics($id)
    {
        return redirect('admin/client/' . $id . '/show');
    }
}
