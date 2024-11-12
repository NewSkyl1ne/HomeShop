@extends('layouts.front')
@section('content')
<script>
  var deleteId = '';
  
  /*$(document).on("click", ".messagea", function () {
     var myBookId = $(this).data('id');
    var ui= $(".messagea").val( "data-id" );
     $("#myID").append(" <b>Appended text</b>.");
     // As pointed out in comments, 
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
console.log(ui);
alert(ui);
    alert("hi");
     //alert(myBookId)
});*/
function onClickHandler(id)
{
 deleteId = id;
}
function goToDelete(){
  window.location.href="/admin/message/"+deleteId+"/delete";
}
$(document).on("click",'.messagea',function(e){
  console.log(e.target);
  var a=document.getElementsByClassName('messagea');
  var as = document.querySelector(".messagea");
  console.log(as);
});
</script>
<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-history">
							<div class="header-area">
								<h4 class="title">
									Tickets 
                  <a data-toggle="modal" data-target="#vendorform" class="mybtn1" href="javascript:;" id="buttonticket"> <i class="fa fa-envelope-o"></i> Send Message</a>
								</h4>
							</div>
							<div class="mr-table allproduct message-area  mt-4">
								@include('includes.form-success')
									<div class="table-responsive">
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>Subject</th>
														<th>Message</th>
														<th>Time</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
                        @foreach($convs as $conv)
                        
                          <tr class="conv">
                            <input type="hidden" value="{{$conv->id}}">
                            <td>{{$conv->subject}}</td>
                            <td>{{$conv->message}}</td>

                            <td>{{$conv->created_at->diffForHumans()}}</td>
                            <td>
                              <a href="{{route('user-message-show',$conv->id)}}" class="link view"><i class="fa fa-comments" title="reply"></i>
                              <a href="{{route('user-message-delete1',7)}}" data-toggle="modal"   data-id="{{$conv->id}}" data-target="#confirm-delete" data-href="{{route('user-message-delete1',$conv->id)}}"class="link remove messagea" onclick= "onClickHandler('{{$conv->id}}')"><i class="fa fa-trash"></i></a>
                            </td>
                          
                          </tr>
                        @endforeach
												</tbody>
											</table>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
  <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel">Send Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-md-12">
              <div class="contact-form">
                <form id="emailreply1">
                  {{csrf_field()}}
                  <ul>
                    <li>
                      <input type="text" class="input-field" id="subj1" name="subject" placeholder="Subject *" required="">
                    </li>
                    <li>
                      <textarea class="input-field textarea" name="message" id="msg1" placeholder="Your Message *" required=""></textarea>
                    </li>
                  </ul>
                  <button class="submit-btn" id="emlsub1" type="submit">Send Message</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>

{{-- MESSAGE MODAL ENDS --}}


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">Confirm Delete</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

                <div class="modal-body" >
            <p class="text-center">You are about to delete this Conversation.</p>
            <p class="text-center">Do you want to proceed?</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-danger btn-ok open-AddBookDialog"  id="myID" onclick="goToDelete()">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">






    
      $(document).on("submit", "#emailreply1" , function(){
      var token = $(this).find('input[name=_token]').val();
      var subject = $(this).find('input[name=subject]').val();
      var message =  $(this).find('textarea[name=message]').val();
      $('#subj1').prop('disabled', true);
      $('#msg1').prop('disabled', true);
      $('#emlsub1').prop('disabled', true);
 $.ajax({
        type: 'post',
        url: "{{URL::to('/user/admin/user/send/message')}}",
        data: {
            '_token': token,
            'subject'   : subject,
            'message'  : message,
              },
        success: function( data) {
      $('#subj1').prop('disabled', false);
      $('#msg1').prop('disabled', false);
      $('#subj1').val('');
      $('#msg1').val('');
    $('#emlsub1').prop('disabled', false);
    if(data == 0)
    $.notify("Oops Something Goes Wrong !!","error");
    else
    $.notify("Message Sent !!","success");
    $('.close').click();
        }

    });          
      return false;
    });

</script>

@endsection

@section('scripts')






<script type="text/javascript">






    
          $(document).on("submit", "#emailreply1" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          $('#subj1').prop('disabled', true);
          $('#msg1').prop('disabled', true);
          $('#emlsub1').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "{{URL::to('/user/admin/user/send/message')}}",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                  },
            success: function( data) {
          $('#subj1').prop('disabled', false);
          $('#msg1').prop('disabled', false);
          $('#subj1').val('');
          $('#msg1').val('');
        $('#emlsub1').prop('disabled', false);
        if(data == 0)
        $.notify("Oops Something Goes Wrong !!","error");
        else
        $.notify("Message Sent !!","success");
        $('.close').click();
            }

        });          
          return false;
        });

</script>


<script type="text/javascript">

      $('#confirm-delete').on('show.bs.modal', function(e) {
          $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });

</script>

@endsection