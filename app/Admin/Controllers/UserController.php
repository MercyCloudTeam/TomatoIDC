<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class UserController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('email');
            $grid->column('phone');
            $grid->column('email_verified_at');
            $grid->column('phone_verified_at');
            $grid->column('amount');
            $grid->column('status');
            $grid->column('password');
            $grid->column('two_factor_secret');
            $grid->column('two_factor_recovery_codes');
            $grid->column('remember_token');
            $grid->column('current_team_id');
            $grid->column('profile_photo_path');
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
        return Show::make($id, new User(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('email');
            $show->field('phone');
            $show->field('email_verified_at');
            $show->field('phone_verified_at');
            $show->field('amount');
            $show->field('status');
            $show->field('password');
            $show->field('two_factor_secret');
            $show->field('two_factor_recovery_codes');
            $show->field('remember_token');
            $show->field('current_team_id');
            $show->field('profile_photo_path');
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
        return Form::make(new User(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('email');
            $form->text('phone');
            $form->text('email_verified_at');
            $form->text('phone_verified_at');
            $form->text('amount');
            $form->text('status');
            $form->text('password');
            $form->text('two_factor_secret');
            $form->text('two_factor_recovery_codes');
            $form->text('remember_token');
            $form->text('current_team_id');
            $form->text('profile_photo_path');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
