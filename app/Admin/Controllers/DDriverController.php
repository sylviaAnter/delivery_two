<?php

namespace App\Admin\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DDriverController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Driver';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Driver());
        $u = Admin::user();
        $grid->model()->where('company_id', $u->company_id);
        $grid->disableBatchActions();
        //$grid->column('image', __('Image'))->image();
        $grid->column('id', __('Id'));
        $grid->column('created_at', __('Created at'))
            ->display(function ($created_at) {
                return date('Y-m-d', strtotime($created_at));
            })->sortable()
            ->hide();
        //$grid->column('updated_at', __('Updated at'));
        //$grid->column('company_id', __('Company id'));
        $grid->column('vehicle_id', __('Car Plate'))
            ->display(function ($vehicle_id) {
                $vehicle = Vehicle::find($vehicle_id);
                if ($vehicle_id) {
                    return $vehicle->plate_number;
                } else {
                    return 'N/A';
                }
            })->sortable();
        $grid->column('first_name', __('First name'));
        $grid->column('last_name', __('Last name'));
        $grid->column('status', __('Status'))->display(function ($status) {
            return $status == 'available' ? 'available' : 'Not available';
        })->sortable();


        $grid->column('phone_number', __('Phone number'));
        $grid->column('phone_number_2', __('Phone number 2'))->hide();
        $grid->column('address', __('Address'))->hide();
        $grid->column('sex', __('Sex'));
        $grid->column('dob', __('Dob'))->hide();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Driver::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('vehicle_id', __('Vehicle id'));
        $show->field('status', __('Status'));
        $show->field('image', __('Image'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('phone_number', __('Phone number'));
        $show->field('phone_number_2', __('Phone number 2'));
        $show->field('address', __('Address'));
        $show->field('sex', __('Sex'));
        $show->field('dob', __('Dob'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Driver());

        $u = Admin::user();
        //dd($u->company_id);
        $form->hidden('company_id', __('Company id'))
            ->default($u->company_id);

        //$form->number('company_id', __('Company id'));

        // URL for fetching vehicle options via AJAX

        // $form->number('vehicle_id', __('Vehicle id'));


        $form->divider('Personal Information');
        $form->text('first_name', __('First name'))->required();
        $form->text('last_name', __('Last name'))->required();
        $form->text('phone_number', __('Phone number'))->required();
        $form->text('phone_number_2', __('Phone number 2'));
        $form->text('address', __('Address'));
        $form->radio('sex', __('Gender'))
            ->options([
                'Male' => 'Male',
                'Female' => 'Female',
                'Other' => 'Other'
            ])->rules('required');
        $form->date('dob', __('Date of bith'))->default(date('Y-m-d'));

        $form->image('image', __('Image'))->uniqueName();
        $form->divider('Account Information');
        $sub_cat_ajax_url = url('api/vehicles') . '?company_id=' . $u->company_id;
        $form->select('vehicle_id', __('Car Plate'))
            ->ajax($sub_cat_ajax_url)
            ->options(function ($vehicle_id) {
                //$r = Vehicle::find($vehicle_id);
                if ($vehicle_id) {
                    $r = Vehicle::find($vehicle_id);
                    if ($r) {
                        return [
                            $r->id => $r->plate_number
                        ];
                    }
                }
                return [];
            })
            ->rules('required');
        $form->radio('status', __('Status'))
            ->options([
                'Available' => 'Available',
                'Not available' => 'Not available'
            ])->default('Active')
            ->rules('required');

        return $form;
    }
}
