		<a class="clear">New Notification(s).</a>
		@if(count($datas) > 0)
		<a id="user-notf-clear" data-href="{{ route('user-notf-clear') }}" class="clear" href="javascript:;">
			Clear All
		</a>
		<ul>
		@foreach($datas as $data)
			<li style="padding: 10px;"> 
			<!-- Message is hardcoded -->
				<a href="{{ route('admin-user-show',$data->user_id) }}"> <i class="fas fa-user"></i> <?php 
				echo $data->notification_text ?></a>
			</li>
		@endforeach

		</ul>

		@else 

		<a class="clear" href="javascript:;">
			No New Notifications.
		</a>

		@endif