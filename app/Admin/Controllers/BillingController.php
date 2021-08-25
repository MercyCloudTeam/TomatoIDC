<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Billing;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class BillingController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Billing(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('time');
            $grid->column('cycle');
            $grid->column('type');
            $grid->column('price');
            $grid->column('setup_fee');
            $grid->column('status');
            $grid->column('display');
            $grid->column('buy');
            $grid->column('renew');
            $grid->column('postpaid');
            $grid->column('auto_generate');
            $grid->column('remark');
            $grid->column('view');
            $grid->column('config');
            $grid->column('sale');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Billing(), function (Show $show) {
            $show->field('id');
            $show->field('time');
            $show->field('cycle');
            $show->field('type');
            $show->field('price');
            $show->field('setup_fee');
            $show->field('status');
            $show->field('display');
            $show->field('buy');
            $show->field('renew');
            $show->field('postpaid');
            $show->field('auto_generate');
            $show->field('remark');
            $show->field('view');
            $show->field('config');
            $show->field('sale');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Billing(), function (Form $form) {
            $form->display('id');
            $form->text('time');
            $form->text('cycle');
            $form->text('type');
            $form->text('price');
            $form->text('setup_fee');
            $form->text('status');
            $form->text('display');
            $form->text('buy');
            $form->text('renew');
            $form->text('postpaid');
            $form->text('auto_generate');
            $form->text('remark');
            $form->text('view');
            $form->text('config');
            $form->text('sale');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
