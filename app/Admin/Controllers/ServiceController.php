<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Service;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ServiceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Service(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id');
            $grid->column('title');
            $grid->column('billing_id');
            $grid->column('product_id');
            $grid->column('type');
            $grid->column('user_config');
            $grid->column('status');
            $grid->column('sub_status');
            $grid->column('expired_at');
            $grid->column('auto_renew');
            $grid->column('postpaid');
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
        return Show::make($id, new Service(), function (Show $show) {
            $show->field('id');
            $show->field('user_id');
            $show->field('title');
            $show->field('billing_id');
            $show->field('product_id');
            $show->field('type');
            $show->field('user_config');
            $show->field('status');
            $show->field('sub_status');
            $show->field('expired_at');
            $show->field('auto_renew');
            $show->field('postpaid');
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
        return Form::make(new Service(), function (Form $form) {
            $form->display('id');
            $form->text('user_id');
            $form->text('title');
            $form->text('billing_id');
            $form->text('product_id');
            $form->text('type');
            $form->text('user_config');
            $form->text('status');
            $form->text('sub_status');
            $form->text('expired_at');
            $form->text('auto_renew');
            $form->text('postpaid');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
