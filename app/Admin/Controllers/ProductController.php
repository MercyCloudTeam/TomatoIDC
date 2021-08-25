<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Product(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('type');
            $grid->column('level');
            $grid->column('status');
            $grid->column('display');
            $grid->column('stock');
            $grid->column('max');
            $grid->column('tax');
            $grid->column('review');
            $grid->column('cost');
            $grid->column('gross_margin');
            $grid->column('category_id');
            $grid->column('subtitle');
            $grid->column('view');
            $grid->column('description');
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
        return Show::make($id, new Product(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('type');
            $show->field('level');
            $show->field('status');
            $show->field('display');
            $show->field('stock');
            $show->field('max');
            $show->field('tax');
            $show->field('review');
            $show->field('cost');
            $show->field('gross_margin');
            $show->field('category_id');
            $show->field('subtitle');
            $show->field('view');
            $show->field('description');
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
        return Form::make(new Product(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('type');
            $form->text('level');
            $form->text('status');
            $form->text('display');
            $form->text('stock');
            $form->text('max');
            $form->text('tax');
            $form->text('review');
            $form->text('cost');
            $form->text('gross_margin');
            $form->text('category_id');
            $form->text('subtitle');
            $form->text('view');
            $form->text('description');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
