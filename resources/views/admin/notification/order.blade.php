<a class="clear">New Order(s).</a>
		@if(count($datas) > 0)
		<a id="order-notf-clear" data-href="{{ route('order-notf-clear') }}" class="clear" href="javascript:;">
			Clear All
		</a>
		<ul>
		@foreach($datas as $data)
			<li style="padding:10px">
				<a href="{{ route('admin-order-show',$data->order_id) }}" > <i class="fas fa-newspaper"></i> <?php 
				echo $data->notification_text ?></a>
			</li>
		@endforeach

		</ul>

		@else 

		<a class="clear" href="javascript:;">
			No New Notifications.
		</a>

		@endif