<?php

namespace App\Admin\Controllers;

use App\Question;
use App\Tag;
use Illuminate\Support\Facades\DB;
use App\Admin\Extensions\Tools\TagModify;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class TagQuestionController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index(\Illuminate\Http\Request $requests)
    {
        $act = $requests['act'];
        $tag = $requests['tag'];

        return Admin::content(function (Content $content) use($tag, $act) {

            $content->header('標籤:'.Tag::where('id', $tag)->value('name'));
            $content->description($act=='add'?'新增題目':'現有題目');

            $content->body($this->grid($tag, $act));
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

            $content->header('header');
            $content->description('description');

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

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }
    

    public function modify(\Illuminate\Http\Request $request)
    {
        // return $request->get('tag');
        if ($request->get('action') == 0) { // 移除Tag
            DB::table('question_tag')->where('tag_id', $request->get('tag'))->whereIn('question_id', $request->get('ids'))->delete();
        }
        else // 新增Tag
            foreach ($request->get('ids') as $question_id)
                DB::table('question_tag')->insert(
                    ['question_id' => $question_id, 'tag_id' => $request->get('tag')]
                );
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($tag, $act)
    {

        return Admin::grid(Question::class, function (Grid $grid) use($tag, $act) {

            if (!Admin::user()->isRole('administrator'))
                $grid->model()->where('admin_id', Admin::user()->id);
                
            $filter = DB::table('question_tag')->where('tag_id', $tag)->pluck('question_id')->toArray();

            $grid->tools(function ($tools) use($act) {
                $tools->batch(function ($batch) use($act) {
                    $batch->disableDelete();
                    if ($act=='add') $batch->add('新增標籤', new TagModify(1));
                    else $batch->add('移除標籤', new TagModify(0));
                });
            });
            $grid->disableCreateButton();
            if ($act=='add') $grid->model()->whereNotIn('id', $filter);
            else $filter = $grid->model()->whereIn('id', $filter);

            $grid->id('ID')->sortable();
            $grid->qtype()->name('Question Type')->sortable();
            $grid->title('Title')->sortable();

            $grid->created_at();
            $grid->updated_at();
            
            $grid->exporter('custom-exporter');
            $grid->disableActions();
        });
    }
    
}
