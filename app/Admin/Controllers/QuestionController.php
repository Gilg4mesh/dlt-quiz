<?php

namespace App\Admin\Controllers;

use App\Question;
use App\Qtype;
use Illuminate\Support\Facades\DB;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;


class QuestionController extends Controller
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

            $content->header('題目管理');
            $content->description('總覽');
            $content->row(function(Row $row) {
                $row->column(2, '');
                $row->column(2, 
                '<a href="/admin/questions/create?qtype=1" class="btn btn-success" style="width: 100%">
                <i class="fa fa-save"></i>&nbsp;&nbsp;新增單選題</a>');
                $row->column(2, 
                '<a href="/admin/questions/create?qtype=2" class="btn btn-success" style="width: 100%">
                <i class="fa fa-save"></i>&nbsp;&nbsp;新增多選題</a>');
                $row->column(2, 
                '<a href="/admin/questions/create?qtype=3" class="btn btn-success" style="width: 100%">
                <i class="fa fa-save"></i>&nbsp;&nbsp;新增是非題</a>');
                $row->column(2, 
                '<a href="/admin/questions/create?qtype=4" class="btn btn-success" style="width: 100%">
                <i class="fa fa-save"></i>&nbsp;&nbsp;新增簡答題</a>');
                $row->column(2, 
                '<a href="/admin/questions/create?qtype=5" class="btn btn-success" style="width: 100%">
                <i class="fa fa-save"></i>&nbsp;&nbsp;新增申論題</a>');
            });
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
            $question = Question::where('id', $id);
            if (!Admin::user()->isRole('administrator') && $question->value('admin_id') != Admin::user()->id)
                return null;

            $content->header('修改題目');

            $qtype = $question->value('qtype_id');
            $content->description(Qtype::where('id', $qtype)->value('name'));

            if ($qtype == 1) $content->body($this->form_single()->edit($id));
            else if ($qtype == 2) $content->body($this->form_multi($id)->edit($id));
            else if ($qtype == 3) $content->body($this->form_truefalse()->edit($id));
            else if ($qtype == 4) $content->body($this->form_short()->edit($id));
            else if ($qtype == 5) $content->body($this->form_discuz()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create(\Illuminate\Http\Request $requests)
    {
        $qtype = $requests['qtype'];
        return Admin::content(function (Content $content) use ($qtype) {

            $content->header('新增題目');
            $content->description(Qtype::where('id', $qtype)->value('name'));

            if ($qtype == 1) $content->body($this->form_single());
            else if ($qtype == 2) $content->body($this->form_multi());
            else if ($qtype == 3) $content->body($this->form_truefalse());
            else if ($qtype == 4) $content->body($this->form_short());
            else if ($qtype == 5) $content->body($this->form_discuz());
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->form()->destroy($id)) {
            DB::table('question_tag')->where('question_id', $id)->delete();
            return response()->json([
                'status'  => true,
                'message' => trans('admin.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin.delete_failed'),
            ]);
        }
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        
        return Admin::grid(Question::class, function (Grid $grid) {
            if (!Admin::user()->isRole('administrator'))
                $grid->model()->where('admin_id', Admin::user()->id);

            $grid->disableCreateButton();
            
            $grid->id('ID')->sortable();
            $grid->qtype()->name('Question Type')->sortable();
            $grid->title('Title')->sortable();
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
        return Admin::form(Question::class, function (Form $form) {
            // id, qtype_id, title, options, answer, parse
            $form->display('id', 'ID');
            $form->display('qtype_id', 'Question Type');
            $form->display('title', '題目')->rules('required');
            $form->display('options', '選項');
            $form->display('answer', '答案')->rules('required');
            $form->display('parse', '詳解')->rules('required');

            $form->display('admin_id', 'admin_id')->rules('required');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

            
            $form->saving(function (Form $form) {
                if (is_array($form->answer))
                    $form->answer = json_encode(array_diff($form->answer, array("")));// implode(',', $form->answer);// json_encode($form->answer);
                $form->admin_id = Admin::user()->id;
            });
        });
    }
    

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form_single()
    {
        return Admin::form(Question::class, function (Form $form) {
            // id, qtype_id, title, options, answer, parse
            $form->display('id', 'ID');
            $form->hidden('qtype_id', 'Question Type')->default(1);
            $form->ckeditor('title', '題目');
            $form->textarea('options', '選項')->default("A.選項內容\nB.選項內容\nC.選項內容\nD.選項內容\nE.選項內容");
            $form->select('answer', '答案')->options(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E']);
            $form->ckeditor('parse', '詳解');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form_multi($id=null)
    {
        return Admin::form(Question::class, function (Form $form) use($id) {
            // id, qtype_id, title, options, answer, parse
            $form->display('id', 'ID');
            $form->hidden('qtype_id', 'Question Type')->default(2);
            $form->ckeditor('title', '題目');
            $form->textarea('options', '選項')->default("A.選項內容\nB.選項內容\nC.選項內容\nD.選項內容\nE.選項內容");

            if (!is_null($id)) $form->display('answer', '原答案');
            $form->multipleSelect('answer', '答案')->options(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E']);
                // dd(implode(". ", json_decode(Question::where('id', $id)->value('answer'))));
            $form->ckeditor('parse', '詳解');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form_truefalse()
    {
        return Admin::form(Question::class, function (Form $form) {
            // id, qtype_id, title, options, answer, parse
            $form->display('id', 'ID');
            $form->hidden('qtype_id', 'Question Type')->default(3);
            $form->ckeditor('title', '題目');
            $form->radio('answer', '答案')->options(['True' => 'True', 'False'=> 'False'])->default('True');
            $form->ckeditor('parse', '詳解');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form_short()
    {
        return Admin::form(Question::class, function (Form $form) {
            // id, qtype_id, title, options, answer, parse
            $form->display('id', 'ID');
            $form->hidden('qtype_id', 'Question Type')->default(4);
            $form->ckeditor('title', '題目');
            $form->text('answer', '答案');
            $form->ckeditor('parse', '詳解');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form_discuz()
    {
        return Admin::form(Question::class, function (Form $form) {
            // id, qtype_id, title, options, answer, parse
            $form->display('id', 'ID');
            $form->hidden('qtype_id', 'Question Type')->default(5);
            $form->ckeditor('title', '題目');
            $form->textarea('answer', '答案');
            $form->ckeditor('parse', '詳解');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
