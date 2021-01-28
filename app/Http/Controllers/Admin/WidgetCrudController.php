<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\WidgetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class WidgetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WidgetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;

    protected function setupReorderOperation()
    {
        // define which model attribute will be shown on draggable elements
        $this->crud->set('reorder.label', 'topic');
        // define how deep the admin is allowed to nest the items
        // for infinite levels, set it to 0
        $this->crud->set('reorder.max_level', 1);
    }

    public function setup()
    {
        $this->crud->setModel('App\Models\Widget');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/widget');
        $this->crud->setEntityNameStrings('widget', 'widgets');
        $this->crud->orderBy('lft');


    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->removeButton('show');

    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(WidgetRequest::class);
        $types = \App\Models\Device::all()->pluck('name');
        $topics = \App\Models\Device::all()->pluck('topics');
        $topicsListen = \App\Models\Device::all()->pluck('topics');
        $topicsArray=array();
        for ($x=0; $x < count(json_decode($topicsListen)); $x++)
        {
            for ($i = 0; $i < count(json_decode($topicsListen[$x])); $i++) {
                $topicsArray[ json_decode($topicsListen[$x])[$i]->topic] = json_decode($topicsListen[$x])[$i]->topic;
            }
        }

        //dd($topicsArray);
        $typeArray=array();
        foreach($types as $type)
        {
            $typeArray[$type] = $type;
        }
        $topicArray=array();
        foreach($topics as $topic)
        {
            $topicArray[$topic] = $topic;
        }
        // TODO: remove setFromDb() and manually define Fields
        // $this->crud->setFromDb();
        $this->crud->addField([   // select2_from_array
            'name' => 'device',
            'label' => "Display Location:",
            'type' => 'select2_from_array',
            'options' => $typeArray,
            'allows_null' => false,
            'default' => 'one',
            'hint' => 'Select the type of device in which this widget should be displayed.'
            //'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->addField([   // select2_from_array
            'name' => 'topic',
            'label' => "Metric:",
            'type' => 'select2_from_array',
            'options' => $topicsArray,
            'allows_null' => false,
            'default' => 'one',
            //'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->addField([   // select2_from_array
            'name' => 'type',
            'label' => "Type:",
            'type' => 'select2_from_array',
            'options' => array('gauge' =>'Speedometer','solidgauge'=>'Gauge','pie'=>'Pie','counter'=>'Counter'),
            'allows_null' => false,
            'default' => 'one',
            //'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
        $this->crud->addField([   // select2_from_array
            'name' => 'size',
            'label' => "Size:",
            'type' => 'select2_from_array',
            'options' => array(0,1,2,3,4,5,6,7,8,9,10,11,12),
            'required' => 'true',
            'default' => '7',

        ]);
        $this->crud->addField([   // select2_from_array
            'name' => 'unit',
            'label' => "Unit:",
            'type' => 'text',
        ]);
        $this->crud->addField([   // select2_from_array
            'name' => 'min',
            'label' => "Minimum Value:",
            'type' => 'number',
            'default' => '0',
            'hint' => 'Only Needed for Gauge or Speedometer'
        ]);        $this->crud->addField([   // select2_from_array
            'name' => 'max',
            'label' => "Maximum Value:",
            'type' => 'number',
            'default' => '100',
            'hint' => 'Only Needed for Gauge or Speedometer'

        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
