<?php

namespace App\Admin\Controllers;

use App\Models\Invoice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class InvoiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Invoice';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Invoice());

        $u = Admin::user();
        $grid->model()->where('company_id', $u->company_id);
        $grid->disableBatchActions();
        $grid->quickSearch('customer name', 'description', 'status');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('Created at'))
            ->display(function ($created_at) {
                return date('Y-m-d', strtotime($created_at));
            })->sortable()
            ->hide();
        // $grid->column('updated_at', __('Updated at'));
        $grid->column('customer_name', __('Customer name'))
            ->sortable();
        $grid->column('customer_address', __('Customer address'))
            ->sortable();
        $grid->column('cost', __('Cost'))
            ->display(function ($cost) {
                return number_format($cost);
            })->sortable();
        $grid->column('description', __('Description'));
        $grid->column('status', __('Status'))->display(function ($status) {
            return $status == 'Shipped' ? 'shipped' : 'Not shipped';
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
        $show = new Show(Invoice::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('customer_name', __('Customer name'));
        $show->field('customer_address', __('Customer address'));
        $show->field('cost', __('Cost'));
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
        $form = new Form(new Invoice());

        $u = Admin::user();
        //  dd($u->company_id);
        $form->hidden('company_id', __('Company id'))
            ->default($u->company_id);
        // $form->divider('Personal Information');
        $form->text('customer_name', __('Customer name'))->required();
        $form->text('customer_address', __('Customer address'))->required();
        $form->decimal('cost', __('Cost'))->default(0.00)->rules('required');
        $form->textarea('description', __('Description'));
        // $form->text('status', __('Status'))->default('shipped');

        $form->radio('status', __('Status'))
            ->options([
                'Shipped' => 'Shipped',
                'Not Shipped' => 'Not Shipped'
            ])->default('Not Shipped')
            ->rules('required');
        return $form;
    }
}
