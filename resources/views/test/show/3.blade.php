<input type="hidden" name="qtype_id" value="3">
<div class="form-group">

    <label class="radio">
        <input required="required" type="radio" data-toggle="radio" name="answer" value="True" data-radiocheck-toggle="radio" required
               @if(isset($question)&&($question->answer)=="1")checked=""@endif>
        True
    </label>

    <label class="radio">
        <input required="required" type="radio" data-toggle="radio" name="answer" value="False" data-radiocheck-toggle="radio"
               @if(isset($question)&&($question->answer)=="0")checked=""@endif >
        False
    </label>
</div>