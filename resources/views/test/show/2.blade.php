<input type="hidden" name="qtype_id" value="2">
<div class="form-group">
    @foreach(explode("\r\n",$options) as $option)
    	@if(strlen($option))
	        <label class="checkbox ">
	            <input type="checkbox" data-toggle="checkbox" name="answer[]"  value={{substr($option,0,1)}} data-radiocheck-toggle="radio" >
	            <p class="lead">{!! $option!!}</p>
	        </label>
        @endif
    @endforeach

</div>