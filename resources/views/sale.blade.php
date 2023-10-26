<div class="modal fade in" id="exams-view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"> 
	<div class="modal-dialog modal-full" role="document">
		<div class="modal-content video-contentfull">
			<div class="modal-body">

				<div class="card">
					<div class="card-header">
						<h3 style="width: 100%"> 
							Record Sales 
							<a href="#" id="close-modal" class="float-right">x</a></h3>

							<div style="display: flex;align-items: center;margin-left: 20px;">
									<div class="form-group">
										<label for="">Enter Code</label>
										<input type="text" class="form-control" name="code" id="code">
									</div>
									<div style="margin-left: 10px;margin-top: 10px;">
										<a href="#" class="btn btn-success" id="fetchdetails">Fetch Details</a>
									</div>

									<div style="margin-left: 10px;margin-top: 10px;">
										<a href="/admin/record-sales" class="btn btn-info">Reload Sales</a>
									</div>
								</div>
						</div>
						<div class="card-body">

							<div class="card card-info">
								<div class="card-body">
									<div class="row">

										<div class="col-md-3">

											<form action="">

												@csrf
												<div class="form-group">
													<label for="">Bill ID</label>
													<input type="text" class="form-control" name="billid" id="billid" value="{{ $billid }}" readonly>
												</div>

												<div class="form-group">
													<label for="">Barcode ID</label>
													<input type="text" class="form-control" name="barcodeid" id="barcodeid">
												</div> 

												<div class="form-group">
													<label for="">Product name</label>
													<select name="prname" id="prname" class="form-control select2">
														<option value=""></option>
														@foreach($allproducts as $product)
														<option value="{{ $product->id }}">{{ $product->name }} - {{ $product->ptype }}</option>
														@endforeach
													</select>
												</div>

												<div class="form-group">
													<label for="">Product price (Gh¢)</label>
													<input type="text" class="form-control" name="prpx" id="prpx" readonly>
												</div>

												<div class="form-group">
													<label for="">Quantity</label>
													<input type="number" class="form-control" name="qty" id="qty" value="1">
												</div>

												<div class="form-group">
													<input type="hidden" class="form-control" name="dscnt" id="dscnt" value="0">
												</div> 

												<ul class="list-unstyled" style="display: flex;align-items: center;justify-content: center;">
													<li class="mr-2"><a href="#" class="btn btn-info" id="addsales">Add</a></li>
													<li><Button type="reset" class="btn btn-success">Reset</Button></li>
												</ul>

											</form>

										</div>
										<div class="col-md-9">
											<div id="addcustomersales">
												@include('saleproducts',['getproduct' => $getproduct])
											</div>
										</div>
									</div>
		{{-- <div class="bottom-info">
			<ul class="list-unstyled" style="display: flex;align-items: center;justify-content: center;">
				<li class="mr-2"><a href="#" class="btn btn-info">Calculate</a></li>
				<li><a href="#" class="btn btn-success">Print Bill</a></li>
			</ul>
		</div> --}}
	</div>
</div>


</div>
</div>
</div>
</div>
</div>
</div>

<style type="text/css">
    .modal-full{
        min-width: 100%;
        margin: 0;
      }

      .modal-full .modal-content{
        min-height: 100vh;
      }

      .video-contentfull {
        overflow-y: hidden;
        overflow-x: hidden;
        background: #ccc;
        border-radius: 0;
        box-shadow: none;
        border: 0px;
      }

    .sticky {
        position: fixed;
        top: 0;
        box-shadow: 5px 10px #888888;
    }
    .time{
        border-radius: 50px;
        bottom: 30px;
        right: 20px;
        width: 200px;
        color:white;
        background: #3b98ff;
        padding: 12px 20px;
        text-transform: capitalize;
        font-weight: bold;
        font-size: 16px;
        position: fixed;
        -webkit-transition: all 0.5s ease;
        transition: all 0.5s ease;
        -webkit-animation: pulse 2s infinite;
        animation: pulse 2s infinite;
    }


    @-webkit-keyframes pulse {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3);
            box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3)
        }
        70% {
            -webkit-box-shadow: 0 0 0 20px rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 20px rgba(4, 169, 245, 0)
        }
        100% {
            -webkit-box-shadow: 0 0 0 0 rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 0 rgba(4, 169, 245, 0)
        }
    }

    @keyframes pulse {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3);
            box-shadow: 0 0 0 0 rgba(59, 152, 255, 0.3)
        }
        70% {
            -webkit-box-shadow: 0 0 0 20px rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 20px rgba(4, 169, 245, 0)
        }
        100% {
            -webkit-box-shadow: 0 0 0 0 rgba(4, 169, 245, 0);
            box-shadow: 0 0 0 0 rgba(4, 169, 245, 0)
        }
    }

</style>

<script>
	$('document').ready(function(){

		require(['select2'],function(){
			$('.select2').select2();
		});

		$(document).on('change','#prname',function(e){
			e.preventDefault();
			var id = $(this).val();

			if(id == ""){
				return;
			}

			$.ajax({
				beforeSend: function(){
					$.LoadingOverlay("show");
				},
				complete: function(){
					$.LoadingOverlay("hide");
				},
				url: '/admin/fetch-product-px',
				type: 'get',
				data: {id: id},
				success: function(data){
				 $("#prpx").val(data);
				 $("#qty").val(1);
				},
				error: function (data) {
				 console.log('Error:', data);
				}
			}); 
			
		});


		//fetchdetails
		$(document).on('click','#fetchdetails',function(e){
			e.preventDefault();
			var id = $("#code").val();

			if(id == ""){
				return;
			}

			$.ajax({
				beforeSend: function(){
					$.LoadingOverlay("show");
				},
				complete: function(){
					$.LoadingOverlay("hide");
				},
				url: '/admin/fetch-app-product',
				type: 'get',
				data: {id: id},
				success: function(data){
					$("#addcustomersales").html(data);
				},
				error: function (data) {
				 console.log('Error:', data);
				}
			}); 
			
		});

		//addSales
		
		$(document).off( "click", "#addsales").on('click','#addsales',function(e){
			e.preventDefault();

			var code = $("#code").val();
			var billid = $("#billid").val();
			var barcodeid = $("#barcodeid").val();
			var prname = $("#prname").val();
			var prpx = $("#prpx").val();
			var qty = $("#qty").val();
			var dscnt = $("#dscnt").val();

			if(billid == ""){
				return;
			}

			if(prname == ""){
				return;
			}

			if(prpx == ""){
				return;
			}

			if(qty == ""){
				return;
			}

			$.ajax({
				beforeSend: function(){
					$.LoadingOverlay("show");
				},
				complete: function(){
					$.LoadingOverlay("hide");
				},
				url: '/admin/add-product-to-sales',
				type: 'get',
				data: {billid: billid, barcodeid: barcodeid,prname: prname, prpx: prpx, qty: qty, dscnt: dscnt, code: code},
				success: function(data){
					//console.log(data);
				 $("#addcustomersales").html(data);
				},
				error: function (data) {
				 console.log('Error:', data);
				}
			}); 
			
		});

		//delproduct
		$(document).off("click", ".delproduct").on('click','.delproduct',function(e){
			e.preventDefault();
			var id = $(this).data('cid');
			var title = $(this).data('title');

			swal({
				title: "Are You Sure ?",
				text: `You want to remove ${title} from sales`,
				icon: "warning",
				buttons: ['Cancel','Yes'],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						beforeSend: function(){
							$.LoadingOverlay("show");
						},
						complete: function(){
							$.LoadingOverlay("hide");
						},
						url: '/admin/del-product-from-sales',
						type: 'get',
						data: {id: id},
						success: function(data){
						$.admin.reload(data);
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 

				}
			});

		});

		
		$(document).on('keyup','#barcodeid',function(e){
			e.preventDefault();

			var value = $(this).val();

			if(value == ""){
				return;
			}

			if(e.which==13 || value.length > 10){

				$.ajax({
					beforeSend: function(){
						$.LoadingOverlay("show");
					},
					complete: function(){
						$.LoadingOverlay("hide");
					},
					url: '/admin/fetch-product-px-from-barcode',
					type: 'get',
					data: {value: value},
					dataType: 'json',
					success: function(data){
					$("#prpx").val(data.price);
					$("#qty").val(1);
					$("#prname").val(data.name).trigger('change');
					},
					error: function (data) {
					 console.log('Error:', data);
					}
				});


			}
			
		});


		$(document).on('keyup','#discont',function(e){
			e.preventDefault();
			var discount = $(this).val();
			var subtotal = parseInt($("#dissubtot").val());

			if(discount === "NaN"){
				$("#distot").val(subtotal);
			}else{
				var stotal = (discount/100)*subtotal;
				var total = subtotal - stotal;
				$("#distot").val(total);
			}
			
		});

		//onloadtoatl();
		function onloadtoatl(){
			var discount = $("#dissubtot").val();
			$("#distot").val(subtotal);
		}



		//confirmsales
		
		$(document).off("click", "#confirmsales").on('click','#confirmsales',function(e){
			e.preventDefault();
			var subtotal = $("#dissubtot").val();
			var discont = $("#discont").val();
			var total = $("#distot").val();
			var billid = $("#billid").val();
			var code = $("#code").val();
			

			swal({
				title: "Are You Sure ?",
				text: `Approve action`,
				icon: "warning",
				buttons: ['Cancel','Yes Confirm'],
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						beforeSend: function(){
							$.LoadingOverlay("show");
						},
						complete: function(){
							$.LoadingOverlay("hide");
						},
						url: '/admin/product-confirm-sales',
						type: 'get',
						data: {subtotal: subtotal, discont: discont,total: total, billid: billid, code: code},
						success: function(data){
						
						clearfield();

						var printurl = '/admin/print-sales-report/'+billid;

                        window.open(printurl,"_blank");

						$.admin.reload(data);
					},
					error: function (data) {
						console.log('Error:', data);
					}
				}); 

				}
			});

		});

		
		$('#exams-view').modal({
	        show: true,
	        backdrop: 'static',
	        keyboard: false
	    });

	    $(document).on("click","#close-modal", function(e){ 
	    	e.preventDefault();
	    	window.location.href = '/admin';
	    });


	    function clearfield(){

	    	$("#code").val("");
			$("#barcodeid").val("");
			$("#prname").val("").trigger('change');
			$("#prpx").val();
			$("#qty").val(1);
	    }

		
	});
</script>

<script type="text/javascript">

   $('.save_exam_btn').click(function () {
       $('#saveModal').modal({
           show: true,
           backdrop: 'static',
           keyboard: false
       })
   });

   

    //$(document).on("click","#close-modal", function(e){ });

</script>





















