<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DeviceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Device;

/**
 * Class DeviceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeviceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation {
        show as traitDestroy;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow;}



    public function setup()
    {
        $this->crud->setModel('App\Models\Device');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/device');
        $this->crud->setEntityNameStrings('device', 'devices');
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Device Type']);


        $this->crud->addButtonFromView('line', 'view_clients', 'view_clients', 'beginning');
    }
    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
$this->crud->addColumn([
    'name' => 'topics', // The db column name
    'label' => "Topics", // Table column heading
    'type' => 'array_count',
     'suffix' => 'topics', // if you want it to show "2 options" instead of "2 items"
 ]);
 $this->crud->removeButton('show');

    }

    public function show($id)
    {



        $data[] = $id;
        $data[] = $this->crud;
        return view('overview')->with('data', $data);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(DeviceRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Device Name']);

        $this->crud->addFields([
            [   // Table
                'name' => 'topics',
                'label' => 'MQTT Topics',
                'type' => 'table',
                'entity_singular' => 'topic', // used on the "Add X" button
                'columns' => [
                    'topic' => 'Topic',
                    'unit' =>'Unit'
                ],
                'max' => 200, // maximum rows allowed in the table
                'min' => 1, // minimum rows allowed in the table
                'hint'       => 'The device id is automatically assumed to be the 2nd level, as in <strong>"device/{client_id}/"</strong>.<br> There is no need to add it.<br><br><h3>MQTT Broker:</h1><strong> Host: </strong> hairdresser.cloudmqtt.com<br><strong> port:</strong>  15674<br><strong> Username:</strong>  nhslvltv<br><strong>Password:</strong> 5vJUELr8WG3a', // helpful text, shows up after the input

            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        return $this->crud->delete($id);
    }


}
