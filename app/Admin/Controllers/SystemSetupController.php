<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\SystemSetting;
use App\Admin\Forms\ThemeSetting;
use App\Admin\Repositories\SystemSetup;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;

class SystemSetupController extends AdminController
{
    /**
     * @param Content $content
     * @return Content
     */
    public function systemSetup(Content $content)
    {
        return  $content
            ->title('网站设置')
            ->description('详情')
            ->body(new Card(new SystemSetting()));
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new SystemSetup(), function (Grid $grid) {
            $grid->column('name')->sortable();
            $grid->column('value');
            $grid->column('type');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('name');

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
        return Show::make($id, new SystemSetup(), function (Show $show) {
            $show->field('name');
            $show->field('value');
            $show->field('type');
            $show->field('name');
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
        return Form::make(new SystemSetup(), function (Form $form) {
            $form->display('name');
            $form->text('value');
            $form->text('type');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
