var manageOrderTable;
var suppliers_product_id;
var suppliers_id;

function poaddRow() {
	$("#poaddRowBtn").button("loading");


	var tableLength = $("#poproductTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {
		tableRow = $("#poproductTable tbody tr:last").attr('id');
		arrayNumber = $("#poproductTable tbody tr:last").attr('class');
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
			$("#poaddRowBtn").button("reset");

			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+
				'<td>'+
					'<div class="form-group">'+

					'<select class="form-control" name="sup_prod_model[]" id="sup_prod_model'+count+'" onchange="pogetProductData('+count+')" >'+
						'<option value="">~~SELECT MODEL~~</option>';
						//console.log(response);
						$.each(response, function(index, value) {
							tr += '<option value="'+value[0]+'">'+value[1]+'</option>';
						});

					tr += '</select>'+
					'</div>'+
				'</td>'+
				'<td>'+
					'<input type="text" name="po_price[]" id="po_price'+count+'" autocomplete="off" disabled="true" class="form-control" />'+
					'<input type="hidden" name="po_priceValue[]" id="po_priceValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td>'+
					'<div class="form-group">'+
					'<input type="number" name="po_qty[]" id="po_qty'+count+'" onkeyup="pogetTotal('+count+')" autocomplete="off" class="form-control" min="1" />'+
					'</div>'+
				'</td>'+
				'<td>'+
					'<input type="text" name="po_total[]" id="po_total'+count+'" autocomplete="off" class="form-control" disabled="true" />'+
					'<input type="hidden" name="po_totalValue[]" id="po_totalValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td>'+
					'<button class="btn btn-default removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
			'</tr>';
			if(tableLength > 0) {
				$("#poproductTable tbody tr:last").after(tr);
			} else {
				$("#poproductTable tbody").append(tr);
			}

		} // /success
	});	// get the product data

} // /add row

function removeProductRow(row = null) {
	if(row) {
		$("#row"+row).remove();
		posubAmount();
	} else {
		alert('error! Refresh the page again');
	}
}

// select on product data
function pogetProductData(row = null) {
	if(row) {
		var suppliers_product_id = $("#sup_prod_model"+row).val();

		if(suppliers_product_id == "") {
			$("#po_price"+row).val("");

			$("#po_qty"+row).val("");
			$("#po_total"+row).val("");


		} else {
			$.ajax({
				url: 'fetchSelectedProduct.php',
				type: 'POST',
				data: {suppliers_product_id : suppliers_product_id},
				dataType: 'json',
				success:function(response) {
					// setting the rate value into the rate input field
					$("#po_price"+row).val(response.sup_prod_price);
					$("#po_priceValue"+row).val(response.sup_prod_price);

					$("#po_qty"+row).val(1);

					var total = Number(response.sup_prod_price) * 1;
					total = total.toFixed(2);
					$("#po_total"+row).val(total);
					$("#po_totalValue"+row).val(total);


					posubAmount();
				} // /success
			}); // /ajax function to fetch the product data
		}

	} else {
		alert('no row! please refresh the page');
	}
} // /select on product data

// table total
function pogetTotal(row = null) {
	if(row) {
		var total = Number($("#po_price"+row).val()) * Number($("#po_qty"+row).val());
		total = total.toFixed(2);
		$("#po_total"+row).val(total);
		$("#po_totalValue"+row).val(total);

		posubAmount();

	} else {
		alert('no row !! please refresh the page');
	}
}

function posubAmount() {
	var tableProductLength = $("#poproductTable tbody tr").length;
	var totalSubAmount = 0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#poproductTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#po_total"+count).val());
	} // /for

	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#posubTotal").val(totalSubAmount);
	$("#posubTotalValue").val(totalSubAmount);

} // /sub total amount


function resetOrderForm() {
	// reset the input field
	$("#createOrderForm")[0].reset();
	// remove remove text danger
	$(".text-danger").remove();
	// remove form group error
	$(".form-group").removeClass('has-success').removeClass('has-error');
} // /reset order form



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
