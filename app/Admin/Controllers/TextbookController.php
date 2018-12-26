<?php

namespace App\Admin\Controllers;

use App\Textbook;
use App\Hashlink;
use Hashids\Hashids;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TextbookController extends Controller
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

            $content->header('學習資源');
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

            $content->header('學習資源');
            $content->description('修改');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('學習資源');
            $content->description('新增');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Textbook::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->type('Type')->sortable();
            $grid->title('Title')->sortable();
            $grid->link('Link')->sortable();
            $grid->exporter('custom-exporter');

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Textbook::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('type', 'Type');
            $form->text('title', 'Title');
            $form->text('link', 'Link');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');


            $form->saved(function (Form $form) {
                if (Hashlink::where('textbook_id', $form->model()->id)->count() == 0) {
                    $hashlink = new Hashlink();
                    $hashlink->textbook_id = $form->model()->id;
                    $hashids = new Hashids('', 5);
                    $hashlink->hashlink = $hashids->encode($form->model()->id);
                    $hashlink->orilink = $form->model()->link;
                    $hashlink->save();
                }
            });
        });
    }
}
