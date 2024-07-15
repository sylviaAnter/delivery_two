<?php

namespace App\Admin\Controllers;

use App\Models\Region;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class RegionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Region';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Region());


        $u = Admin::user();
        $grid->model()->where('company_id', $u->company_id);
        $grid->disableBatchActions();
        $grid->quickSearch('Region_name', 'city', 'status');


        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('Created at'))
            ->display(function ($created_at) {
                return date('Y-m-d', strtotime($created_at));
            })->sortable()
            ->hide();

        //$grid->column('updated_at', __('Updated at'));
        //$grid->column('company_id', __('Company id'));
        $grid->column('Region_name', __('Region name'))->sortable();
        $grid->column('city', __('City'))->sortable();

        $grid->column('PostalCode', __('PostalCode'))->display(function ($PostalCode) {
            return number_format($PostalCode);
        })->sortable();
        $grid->column('DeliveryFee', __('DeliveryFee'))->display(function ($DeliveryFee) {
            return number_format($DeliveryFee);
        })->sortable();
        $grid->column('EstimatedDeliveryTime', __('DeliveryTime In Days'))->display(function ($EstimatedDeliveryTime) {
            return number_format($EstimatedDeliveryTime);
        })->sortable();
        $grid->column('description', __('Description'));
        $grid->column('status', __('Status'))->display(function ($status) {
            return $status == 'available' ? 'available' : 'Not available';
        })->sortable();

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
        $show = new Show(Region::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('Region_name', __('Region name'));
        $show->field('city', __('City'));
        $show->field('PostalCode', __('PostalCode'));
        $show->field('DeliveryFee', __('DeliveryFee'));
        $show->field('EstimatedDeliveryTime', __('EstimatedDeliveryTime'));
        $show->field('description', __('Description'));
        $show->field('status', __('Status'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Region());
        $u = Admin::user();
        //dd($u->company_id);

        $form->hidden('company_id', __('Company id'))
            ->default($u->company_id);

        $form->text('Region_name', __('Region name'))->required();
        $form->text('city', __('City'))->required();
        $form->decimal('DeliveryFee', __('DeliveryFee'))->required();
        $form->decimal('EstimatedDeliveryTime', __('EstimatedDeliveryTime'));
        $form->decimal('PostalCode', __('PostalCode'));
        $form->radio('status', __('Status'))
            ->options([
                'available' => 'available',
                'Not available' => 'Not available'
            ])->default('available')
            ->rules('required');
        $form->textarea('description', __('Description'));

        return $form;
    }
}
