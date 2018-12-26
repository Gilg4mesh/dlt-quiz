<?php

namespace App\Admin\Controllers;

use App\Test;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TestController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('作答紀錄');
            $content->description('總覽');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('作答紀錄');
            $content->description('詳細內容');

            $content->body($this->form()->edit($id));
        });
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Test::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user_id('user_id')->sortable();
            $grid->tagtype('tagtype')->sortable();
            $grid->totalnumber('totalnumber')->sortable();
            // $grid->testtype('testtype')->sortable();
            $grid->point('point')->sortable();

            $grid->created_at();
            $grid->ended_at('ended_at')->sortable();
            $grid->updated_at();
            $grid->exporter('custom-exporter');

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->disableRowSelector();
            $grid->disableCreateButton();
            $grid->actions(function ($actions) {
                 $actions->disableDelete();
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Test::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('ended_at', 'ended_at');
            $form->display('tagtype', 'tagtype');
            $form->display('totalnumber', 'totalnumber');
            $form->display('testtype', 'testtype');
            $form->display('point', 'point');
            $form->display('user_id', 'user_id');
            $form->display('questionids', 'questionids');
            $form->display('useranswer', 'useranswer');
            $form->display('judges', 'judges');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->disableSubmit();
            $form->disableReset();
        });
    }
}
