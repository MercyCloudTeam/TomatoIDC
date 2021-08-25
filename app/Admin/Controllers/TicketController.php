<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Ticket;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class TicketController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Ticket(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('content');
            $grid->column('contact');
            $grid->column('type');
            $grid->column('priority');
            $grid->column('user_uuid');
            $grid->column('service_uuid');
            $grid->column('admin_id');
            $grid->column('status');
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
        return Show::make($id, new Ticket(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('content');
            $show->field('contact');
            $show->field('type');
            $show->field('priority');
            $show->field('user_uuid');
            $show->field('service_uuid');
            $show->field('admin_id');
            $show->field('status');
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
        return Form::make(new Ticket(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('content');
            $form->text('contact');
            $form->text('type');
            $form->text('priority');
            $form->text('user_uuid');
            $form->text('service_uuid');
            $form->text('admin_id');
            $form->text('status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
