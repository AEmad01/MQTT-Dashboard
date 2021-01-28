<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MetricRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MetricCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MetricCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Metric');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/metric');
        $this->crud->setEntityNameStrings('metric', 'metrics');
           $this->crud->addField([   // select_from_array
            'name' => 'template',
            'label' => "Template",
            'type' => 'select_from_array',
            'options' => ['one' => 'One', 'two' => 'Two'],
            'allows_null' => false,
            'default' => 'one',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(MetricRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();


    }
}
