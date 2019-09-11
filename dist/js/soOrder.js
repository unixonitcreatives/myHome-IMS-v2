var manageOrderTable;
var suppliers_product_id;
var suppliers_id;



function soAddRow() {
	$("#addRowBtn").button("loading");


	var tableLength = $("#productTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {
		tableRow = $("#productTable tbody tr:last").attr('id');
		arrayNumber = $("#productTable tbody tr:last").attr('class');
		count = tableRow.substring(3);
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}

	$.ajax({
		url: "fetchProductData.php",
		type: 'post',
		dataType: 'json',
		success:function(response) {
			$("#addRowBtn").button("reset");

			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+
				'<td>'+
					'<div class="form-group">'+

					'<select class="form-control" name="so_model[]" id="so_model'+count+'" onchange="getProductData('+count+')" >'+
						'<option value="">~~SELECT MODEL~~</option>';
						//console.log(response);
						$.each(response, function(index, value) {
							tr += '<option value="'+value[0]+'">'+value[1]+'</option>';
						});

					tr += '</select>'+
					'</div>'+
				'</td>'+
				'<td>'+
					'<input type="text" name="so_unit_price[]" id="so_unit_price'+count+'" autocomplete="off" disabled="true" class="form-control" />'+
					'<input type="hidden" name="so_unit_priceValue[]" id="so_unit_priceValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td>'+
					'<div class="form-group">'+
					'<input type="number" name="so_qty[]" id="so_qty'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control" min="1" />'+
					'</div>'+
				'</td>'+
				'<td>'+
					'<input type="text" name="price[]" id="price'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control"  />'+
				'</td>'+
				'<td>'+
					'<input type="text" name="so_total_amount[]" id="so_total_amount'+count+'" autocomplete="off" class="form-control" disabled="true" />'+
					'<input type="hidden" name="so_total_amountValue[]" id="so_total_amountValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td>'+
					'<button class="btn btn-default removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
			'</tr>';
			if(tableLength > 0) {
				$("#productTable tbody tr:last").after(tr);
			} else {
				$("#productTable tbody").append(tr);
			}

		} // /success
	});	// get the product data

} // /add row

function removeProductRow(row = null) {
	if(row) {
		$("#row"+row).remove();
		subAmount();
	} else {
		alert('error! Refresh the page again');
	}
}

// select on product data
function getProductData(row = null) {
	if(row) {
		var suppliers_product_id = $("#so_model"+row).val();

		if(suppliers_product_id == "") {
			$("#so_unit_price"+row).val("");

			$("#so_qty"+row).val("");
			$("#so_price"+row).val("");
			$("#so_total_amount"+row).val("");


		} else {
			$.ajax({
				url: 'fetchSelectedProduct.php',
				type: 'POST',
				data: {suppliers_product_id : suppliers_product_id},
				dataType: 'json',
				success:function(response) {
					// setting the rate value into the rate input field
					$("#so_unit_price"+row).val(response.sup_prod_price);
					$("#so_total_amountValue"+row).val(response.sup_prod_price);

					$("#so_qty"+row).val(1);

					var total = Number(response.sup_prod_price) * 1;
					total = total.toFixed(2);
					$("#price"+row).val(total);
					$("#so_total_amount"+row).val(total);
					$("#so_total_amountValue"+row).val(total);


					subAmount();
				} // /success
			}); // /ajax function to fetch the product data
		}

	} else {
		alert('no row! please refresh the page');
	}
} // /select on product data

// table total
function getTotal(row = null) {
	if(row) {
		var total = Number($("#price"+row).val()) * Number($("#so_qty"+row).val());
		total = total.toFixed(2);
		$("#so_total_amount"+row).val(total);
		//$("#po_totalValue"+row).val(total);

		subAmount();

	} else {
		alert('no row !! please refresh the page');
	}
}

function subAmount() {
	var tableProductLength = $("#productTable tbody tr").length;
	var totalSubAmount = 0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#productTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#so_total_amount"+count).val());
	} // /for

	totalSubAmount = totalSubAmount.toFixed(2);
	// sub total
	$("#so_sub_total").val(totalSubAmount);
	$("#so_sub_totalValue").val(totalSubAmount);

	/* vat
	var vat = (Number($("#subTotal").val())/100) * 13;
	vat = vat.toFixed(2);
	$("#vat").val(vat);
	$("#vatValue").val(vat); */

	//delivery fee
	var delFee = Number($("#so_delivery_fee").val());
	delFee = delFee.toFixed(2);
	$("#so_delivery_fee").val(delFee);

	// total amount
	var totalAmount = Number($("#so_delivery_fee").val()) + Number($("#so_sub_total").val());
	//var totalAmount = (Number($("#subTotal").val()) + Number($("#vat").val()));
	totalAmount = totalAmount.toFixed(2);
	$("#so_total_amount").val(totalAmount);
	$("#so_total_amountValue").val(totalAmount);

	/*var discount = $("#discount").val();
	if(discount) {
		var grandTotal = Number($("#totalAmount").val()) - Number(discount);
		grandTotal = grandTotal.toFixed(2);
		$("#grandTotal").val(grandTotal);
		$("#grandTotalValue").val(grandTotal);
	} else {
		$("#grandTotal").val(totalAmount);
		$("#grandTotalValue").val(totalAmount);
	} // /else discount

	var paidAmount = $("#paid").val();
	if(paidAmount) {
		paidAmount =  Number($("#grandTotal").val()) - Number(paidAmount);
		paidAmount = paidAmount.toFixed(2);
		$("#due").val(paidAmount);
		$("#dueValue").val(paidAmount);
	} else {
		$("#due").val($("#grandTotal").val());
		$("#dueValue").val($("#grandTotal").val());
	} // else */

} // /sub total amount

/*function discountFunc() {
	var discount = $("#discount").val();
 	var totalAmount = Number($("#totalAmount").val());
 	totalAmount = totalAmount.toFixed(2);

 	var grandTotal;
 	if(totalAmount) {
 		grandTotal = Number($("#totalAmount").val()) - Number($("#discount").val());
 		grandTotal = grandTotal.toFixed(2);

 		$("#grandTotal").val(grandTotal);
 		$("#grandTotalValue").val(grandTotal);
 	} else {
 	}

 	var paid = $("#paid").val();

 	var dueAmount;
 	if(paid) {
 		dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
 		dueAmount = dueAmount.toFixed(2);

 		$("#due").val(dueAmount);
 		$("#dueValue").val(dueAmount);
 	} else {
 		$("#due").val($("#grandTotal").val());
 		$("#dueValue").val($("#grandTotal").val());
 	}

} // /discount function */

/*function paidAmount() {
	var grandTotal = $("#grandTotal").val();

	if(grandTotal) {
		var dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
		dueAmount = dueAmount.toFixed(2);
		$("#due").val(dueAmount);
		$("#dueValue").val(dueAmount);
	} // /if
} // /paid amoutn function */


function resetOrderForm() {
	// reset the input field
	$("#createOrderForm")[0].reset();
	// remove remove text danger
	$(".text-danger").remove();
	// remove form group error
	$(".form-group").removeClass('has-success').removeClass('has-error');
} // /reset order form


// remove order from server
/*function removeOrder(orderId = null) {
	if(orderId) {
		$("#removeOrderBtn").unbind('click').bind('click', function() {
			$("#removeOrderBtn").button('loading');

			$.ajax({
				url: 'php_action/removeOrder.php',
				type: 'post',
				data: {orderId : orderId},
				dataType: 'json',
				success:function(response) {
					$("#removeOrderBtn").button('reset');

					if(response.success == true) {

						manageOrderTable.ajax.reload(null, false);
						// hide modal
						$("#removeOrderModal").modal('hide');
						// success messages
						$("#success-messages").html('<div class="alert alert-success">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert

					} else {
						// error messages
						$(".removeOrderMessages").html('<div class="alert alert-warning">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} // /else

				} // /success
			});  // /ajax function to remove the order

		}); // /remove order button clicked


	} else {
		alert('error! refresh the page again');
	}
}*/
// /remove order from server

// Payment ORDER
/*function paymentOrder(orderId = null) {
	if(orderId) {

		$("#orderDate").datepicker();

		$.ajax({
			url: 'php_action/fetchOrderData.php',
			type: 'post',
			data: {orderId: orderId},
			dataType: 'json',
			success:function(response) {

				// due
				$("#due").val(response.order[10]);

				// pay amount
				$("#payAmount").val(response.order[10]);

				var paidAmount = response.order[9]
				var dueAmount = response.order[10];
				var grandTotal = response.order[8];

				// update payment
				$("#updatePaymentOrderBtn").unbind('click').bind('click', function() {
					var payAmount = $("#payAmount").val();
					var paymentType = $("#paymentType").val();
					var paymentStatus = $("#paymentStatus").val();

					if(payAmount == "") {
						$("#payAmount").after('<p class="text-danger">The Pay Amount field is required</p>');
						$("#payAmount").closest('.form-group').addClass('has-error');
					} else {
						$("#payAmount").closest('.form-group').addClass('has-success');
					}

					if(paymentType == "") {
						$("#paymentType").after('<p class="text-danger">The Pay Amount field is required</p>');
						$("#paymentType").closest('.form-group').addClass('has-error');
					} else {
						$("#paymentType").closest('.form-group').addClass('has-success');
					}

					if(paymentStatus == "") {
						$("#paymentStatus").after('<p class="text-danger">The Pay Amount field is required</p>');
						$("#paymentStatus").closest('.form-group').addClass('has-error');
					} else {
						$("#paymentStatus").closest('.form-group').addClass('has-success');
					}

					if(payAmount && paymentType && paymentStatus) {
						$("#updatePaymentOrderBtn").button('loading');
						$.ajax({
							url: 'php_action/editPayment.php',
							type: 'post',
							data: {
								orderId: orderId,
								payAmount: payAmount,
								paymentType: paymentType,
								paymentStatus: paymentStatus,
								paidAmount: paidAmount,
								grandTotal: grandTotal
							},
							dataType: 'json',
							success:function(response) {
								$("#updatePaymentOrderBtn").button('loading');

								// remove error
								$('.text-danger').remove();
								$('.form-group').removeClass('has-error').removeClass('has-success');

								$("#paymentOrderModal").modal('hide');

								$("#success-messages").html('<div class="alert alert-success">'+
			            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
			            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
			          '</div>');

								// remove the mesages
			          $(".alert-success").delay(500).show(10, function() {
									$(this).delay(3000).hide(10, function() {
										$(this).remove();
									});
								}); // /.alert

			          // refresh the manage order table
								manageOrderTable.ajax.reload(null, false);

							} //

						});
					} // /if

					return false;
				}); // /update payment

			} // /success
		}); // fetch order data
	} else {
		alert('Error ! Refresh the page again');
	}
}*/

function printSupplier() {

			$.ajax({
				type: "POST",
				url: 'getSupplier.php',
				data: {suppliers_id : suppliers_id},
				dataType: 'json',
				success:function(response) {
					// out the reponse into po_supplier field
					$("#po_supplier_field").val(response.supplier_name);

					alert('done');


					} // /success
				}); // /ajax function to fetch the supplier data



}// /printSupplier
