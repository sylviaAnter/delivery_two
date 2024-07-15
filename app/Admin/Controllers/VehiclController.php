<?php

namespace App\Admin\Controllers;

use App\Models\Invoice;
use App\Models\Region;
use App\Models\vehicle;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VehiclController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Vehicle';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new vehicle());
        $u = Admin::user();
        $grid->model()->where('company_id', $u->company_id);
        $grid->disableBatchActions();
        $grid->quickSearch('vehicle_type', 'status', 'plate_number');

        $grid->column('id', __('Id'))->sortable();
        $grid->column('created_at', __('Created at'))
            ->display(function ($created_at) {
                return date('Y-m-d', strtotime($created_at));
            })->sortable()
            ->hide();
        // $grid->column('updated_at', __('Updated at'));
        // $grid->column('company_id', __('Company id'));
        $grid->column('region_id', __('Region Name'))
            ->display(function ($region_id) {
                $Region = Region::find($region_id);
                if ($region_id) {
                    return $Region->Region_name;
                } else {
                    return 'N/A';
                }
            })->sortable();


        $grid->column('invoice_id', __('Customer Name'))
            ->display(function ($invoice_id) {
                $Invoice = Invoice::find($invoice_id);
                if ($invoice_id) {
                    return $Invoice->customer_name;
                } else {
                    return 'N/A';
                }
            })->sortable();
        // $grid->column('invoice_id', __('Customer Name'))->sortable();
        // $grid->column('region_id', __('Region Name'))->sortable();
        $grid->column('vehicle_type', __('Vehicle type'));
        $grid->column('plate_number', __('Plate number'));
        $grid->column('brand', __('Brand'));
        $grid->column('model', __('Model'));
        $grid->column('color', __('Color'))->hide();
        $grid->column('capacity', __('Capacity'))->hide();
        $grid->column('status', __('Status'))->display(function ($status) {
            return $status == 'available' ? 'available' : 'under maintenance';
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
        $show = new Show(vehicle::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('company_id', __('Company id'));
        $show->field('invoice_id', __('Invoice id'));
        $show->field('region_id', __('Region id'));
        $show->field('vehicle_type', __('Vehicle type'));
        $show->field('plate_number', __('Plate number'));
        $show->field('brand', __('Brand'));
        $show->field('model', __('Model'));
        $show->field('color', __('Color'));
        $show->field('capacity', __('Capacity'));
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
        $u = Admin::user();
        $form = new Form(new vehicle());
        $form->hidden('company_id', __('Company id'))
            ->default($u->company_id);

        $sub_cat_ajax_url = url('api/regions') . '?company_id=' . $u->company_id;

        $form->select('region_id', __('Name Of Region'))
            ->ajax($sub_cat_ajax_url)
            ->options(function ($region_id) {
                if ($region_id) {
                    $r = Region::find($region_id);
                    if ($r) {
                        return [
                            $r->id => $r->Region_name
                        ];
                    }
                }
                return [];
            })
            ->rules('required');
        $sub_cat_ajax_url = url('api/invoices') . '?company_id=' . $u->company_id;
        $form->select('invoice_id', __('Name Of Customer'))
            ->ajax($sub_cat_ajax_url)
            ->options(function ($invoice_id) {
                if ($invoice_id) {
                    $r = Region::find($invoice_id);
                    if ($r) {
                        return [
                            $r->id => $r->customer_name
                        ];
                    }
                }
                return [];
            })
            ->rules('required');
        $form->text('plate_number', __('Plate number'))->rules('required');
        $form->text('vehicle_type', __('Vehicle type'));

        $form->text('brand', __('Brand'));
        $form->text('model', __('Model'));
        $form->color('color', __('Color'));
        $form->decimal('capacity', __('Capacity in Kg'));
        $form->radio('status', __('Status'))
            ->options([
                'available' => 'available',
                'under maintenance' => 'under maintenance'
            ])->default('available')
            ->rules('required');

        return $form;
    }
}
