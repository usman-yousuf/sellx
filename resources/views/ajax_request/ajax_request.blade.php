@extends('layouts.app')

@section('content')


<div class="card">
	<div class="card-body">
		<div class="input-group">
		  <input type="text" class="form-control" placeholder="Subscribe" aria-label="Subscribe" aria-describedby="basic-addon2" name="subscribe">
		  <div class="input-group-append">
		    <button class="btn btn-outline-secondary" type="button">Button</button>
		  </div>
		</div>			
	</div>
</div>

<script type="text/javascript">

  $(".btn-outline-secondary").click(function(event){
      event.preventDefault();

      let email = $("input[name=subscribe]").val();

      $.ajax({
        url: `http://localhost/sellx/api/subscribe`,
        type:"POST",
        data:{
          e_mail:email,
          // _token: _token
        },
        success:function(response){
          console.log(response);
          if(response) {
           alert(`saved`);
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        	alert(xhr.status);
        	alert(thrownError);
      	}
       });
  });

</script>

@endsection