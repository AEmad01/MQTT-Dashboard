<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AlertRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Topic;

/**
 * Class AlertCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AlertCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    public function setup()
    {
        $this->crud->setModel('App\Models\Alert');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/alert');
        $this->crud->setEntityNameStrings('alert', 'alerts');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(AlertRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $topics = Topic::distinct('message')->pluck('message')->take(10);
        $this->crud->addField([
            'name' => 'templates',
             'type'=>'select-table' // select_from_array
        ]);

        $this->crud->addFields([
            [   // Table
                'name' => 'alerts',
                'label' => 'Alerts',
                'type' => 'table',
                'entity_singular' => 'alert', // used on the "Add X" button
                'columns' => [
                    'topic' => 'Topic',
                    'operator' => 'Operator',
                    'value' => 'Value',


                ],
                'max' => 200, // maximum rows allowed in the table
                'min' => 1, // minimum rows allowed in the table

            ],
        ]);    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
