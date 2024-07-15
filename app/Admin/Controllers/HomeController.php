<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        $u = Admin::user();
        $company = Company::find($u->company_id);
        if ($u->company_id == null) {
            return $content
                ->title('<span style="font-family: Arial, sans-serif; font-size: 36px; font-weight: bold; color: #000;">INTELL</span>
                <span style="font-family: Arial, sans-serif; font-size: 36px; font-weight: bold; color: #c96;">$</span>
                <span style="font-family: Arial, sans-serif; font-size: 36px; font-weight: bold; color: #000;">Mart</span>')
                ->description('hello ' . $u->name)
                ->row(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $box = new Box('Welcome to Intell$Mart Dashboard', '<p style="font-size: 18px; color: #600;">To add new comapny choose Companies.</p>');
                        $box->style('primary')->solid();
                        $column->append($box);
                    });
                })
                ->row(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $box = new Box('About Intell\$Mart Dashboard', '<p style="font-size: 18px; color: #666;">Provide companies , User , Role</p>');
                        $box->style('info')->solid();
                        $column->append($box);
                    });
                })
                // ->row(function (Row $row) {
                //     $row->column(6, function (Column $column) {
                //         $count = User::where('company_id', Admin::user()->company_id)->count();
                //         $box = new Box('Employees', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight:800;">' . $count . '</h3>');
                //         $box->style('primary')->solid();
                //         $column->append($box);
                //     });
                // });
                ->row(function (Row $row) {
                    // $row->column(6, function (Column $column) {
                    //     // $u = Admin::user();
                    //     // $company = Company::find($u->company_id);
                    //     // $count = User::where('company_id', $u->company_id)->count();
                    //     $box = new Box('Employees', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">' . $count . '</h3>');
                    //     $box->style('primary')->solid();
                    //     $column->append($box);
                    // });

                    $row->column(6, function (Column $column) {
                        $box = new Box('Companies', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">2</h3>');
                        $box->style('success')->solid();
                        $column->append($box);
                    });

                    $row->column(6, function (Column $column) {
                        $box = new Box('Users', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">4</h3>');
                        $box->style('warning')->solid();
                        $column->append($box);
                    });

                    $row->column(6, function (Column $column) {
                        $box = new Box('Roles', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">3</h3>');
                        $box->style('danger')->solid();
                        $column->append($box);
                    });

                    // ->row(function (Row $row) {
                    //     $row->column(6, function (Column $column) {
                    //         $count = User::where('company_id', Admin::user()->company_id)->count();
                    //         $box = new Box('Employees', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight:800;">' . $count . '</h3>');
                    //         $box->style('primary')->solid();
                    //         $column->append($box);
                    //     });
                    // });
                });
        } else {
            return $content
                ->title($u->name)
                ->description('hello ' . $u->name)
                ->row(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $box = new Box('Welcome to FedEx Dashboard', '<p style="font-size: 18px; color: #600;">Use the menu on the left to navigate through the dashboard.</p>');
                        $box->style('primary')->solid();
                        $column->append($box);
                    });
                })
                ->row(function (Row $row) {
                    $row->column(12, function (Column $column) {
                        $box = new Box('About FedEx Dashboard', '<p style="font-size: 18px; color: #666;">FedEx :: we are a company provide delivery services from 40 years of experince.</p>');
                        $box->style('info')->solid();
                        $column->append($box);
                    });
                })
                ->row(function (Row $row) {
                    $row->column(6, function (Column $column) {
                        $box = new Box('Driver', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">2</h3>');
                        $box->style('success')->solid();
                        $column->append($box);
                    });

                    $row->column(6, function (Column $column) {
                        $box = new Box('vehicle', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">2</h3>');
                        $box->style('success')->solid();
                        $column->append($box);
                    });

                    $row->column(6, function (Column $column) {
                        $box = new Box('Regions', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">5</h3>');
                        $box->style('warning')->solid();
                        $column->append($box);
                    });

                    $row->column(6, function (Column $column) {
                        $box = new Box('Invoices', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight: 800;">2</h3>');
                        $box->style('danger')->solid();
                        $column->append($box);
                    });

                    // ->row(function (Row $row) {
                    //     $row->column(6, function (Column $column) {
                    //         $count = User::where('company_id', Admin::user()->company_id)->count();
                    //         $box = new Box('Employees', '<h3 style="text-align:right;margin:0; font-size: 40px; font-weight:800;">' . $count . '</h3>');
                    //         $box->style('primary')->solid();
                    //         $column->append($box);
                    //     });
                    // });
                });
        }
    }
}
