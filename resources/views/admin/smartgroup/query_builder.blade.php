@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title') Groups::
@parent @endsection

@section('styles')
    @parent
<link rel="stylesheet" type="text/css" href="{{ asset("css/query-builder.default.min.css") }}">

@endsection

{{-- Content --}}
@section('main')
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
						  Groups selection
					</h1>
                </div>

 </div>
 <div class="row">
	<div id="builder"></div>
	<div class="btn-group">
	  <button class="btn btn-danger reset">Reset</button>
	</div>
	<div class="btn-group">
	  <button class="btn btn-default" disabled>Get:</button>
	  <button class="btn btn-primary parse-json">JSON</button>
	  <button class="btn btn-primary parse-sql" data-stmt="false">SQL</button>
	  <button class="btn btn-primary parse-sql" data-stmt="question_mark">SQL statement</button>
	</div>

    <div id="result" class="hide">
	 <textarea  id="result"> </textarea>
      <h3>Output</h3>
      <pre></pre>
    </div>
 </div>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent

	<script src="{{ asset('js/bower_components/jquery-extendext/jQuery.extendext.min.js') }}"></script>
	<script src="{{ asset('js/query-builder.standalone.min.js') }}"></script>
    <script type="text/javascript">
	$(document).ready(function() {
	var rules_basic = {
   "condition": "AND",
   "rules": [
    {
      "id": "price",
      "field": "price",
      "type": "double",
      "input": "text",
      "operator": "less",
      "value": "10.25"
    },
    {
      "condition": "OR",
      "rules": [
        {
          "id": "category",
          "field": "category",
          "type": "integer",
          "input": "select",
          "operator": "equal",
          "value": "2"
        }
      ]
    }
  ]
};

$('#builder').queryBuilder({
  plugins: ['bt-tooltip-errors'],

  filters: [{
    id: 'name',
    label: 'Name',
    type: 'string'
  }, {
    id: 'category',
    label: 'Category',
    type: 'integer',
    input: 'select',
    values: {
      1: 'Books',
      2: 'Movies',
      3: 'Music',
      4: 'Tools',
      5: 'Goodies',
      6: 'Clothes'
    },
    operators: ['equal', 'not_equal', 'in', 'not_in', 'is_null', 'is_not_null']
  }, {
    id: 'in_stock',
    label: 'In stock',
    type: 'integer',
    input: 'radio',
    values: {
      1: 'Yes',
      0: 'No'
    },
    operators: ['equal']
  }, {
    id: 'price',
    label: 'Price',
    type: 'double',
    validation: {
      min: 0,
      step: 0.01
    }
  }, {
    id: 'id',
    label: 'Identifier',
    type: 'string',
    placeholder: '____-____-____',
    operators: ['equal', 'not_equal'],
    validation: {
      format: /^.{4}-.{4}-.{4}$/
    }
  }],

  rules: rules_basic
});

$('#btn-reset').on('click', function() {
  $('#builder-basic').queryBuilder('reset');
});

$('#btn-set').on('click', function() {
  $('#builder-basic').queryBuilder('setRules', rules_basic);
});

$('#btn-get').on('click', function() {
  var result = $('#builder-basic').queryBuilder('getRules');

  if (!$.isEmptyObject(result)) {
    alert(JSON.stringify(result, null, 2));
  }
});

// reset builder
$('.reset').on('click', function() {
  $('#builder').queryBuilder('reset');
  $('#result').addClass('hide').find('pre').empty();
});

// get rules
$('.parse-json').on('click', function() {
  $('#result').removeClass('hide')
    .find('pre').html(JSON.stringify(
      $('#builder').queryBuilder('getRules', {get_flags: true}),
      undefined, 2
    ));
});

$('.parse-sql').on('click', function() {
  var res = $('#builder').queryBuilder('getSQL', $(this).data('stmt'), false);
  console.log(res.sql);
  $('#result').removeClass('hide')
    .find('pre').html(
      res.sql + (res.params ? '\n\n' + JSON.stringify(res.params, undefined, 2) : '')
    );
});
	 });
    </script>
@stop


