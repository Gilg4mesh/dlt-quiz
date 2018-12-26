<input type="hidden" name="qtype_id" value="1">
<div class="form-group">
    @foreach(explode("\r\n",$options) as $option)
    	@if(strlen($option))
	        <label class="radio ">
	            <input type="radio" data-toggle="radio" name="answer" required="required" value={{substr($option,0,1)}} data-radiocheck-toggle="radio" >
	            <p class="lead">{!! $option!!}</p>
	        </label>
        @endif
    @endforeach

</div>