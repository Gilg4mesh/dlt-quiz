<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class TagModify extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }

    public function script()
    {
        return <<<EOT
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;
    }
    $('{$this->getElementClass()}').on('click', function() {

    $.ajax({
        method: 'post',
        url: '{$this->resource}/modify',
        data: {
            _token:LA.token,
            ids: selectedRows(),
            action: {$this->action},
            tag: $.urlParam('tag')
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('Tag Modify succeeded !');
        }
    });
});

EOT;

    }
}