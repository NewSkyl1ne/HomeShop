<?php //print_r($cat);exit; ?>
<option data-href="" value="">Select Sub Category</option>
@foreach($cat as $sub)
<option  value="{{ $sub->id }}">{{ $sub->name }}</option>
@endforeach
<?php /*
<option data-href="" value="">Select Sub Category</option>
@foreach($cat as $sub)
<option data-href="{{ route('admin-childcat-load',$sub['id']) }}" value="{{ $sub['id'] }}">{{ $sub['name'] }}</option>
@endforeach */?>