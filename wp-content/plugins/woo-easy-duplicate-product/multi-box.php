<div class="wedp-multiple-products-box">
<style type="text/css">
	
	.wedp-multiple-products-number {
		padding: 0 0 0 8px !important;
	}

	.wedp-hidden {
		display: none;
	}

	.wedp-multi-status-message {
		display: inline-block;
		display: none;
	}

	.wedp-green {
		color: green !important;
	}
</style>

<p><a href="#" class="wedp-multiple-products-switch-button">Multiple</a></p>
<div class="wedp-multiple-products-input-container wedp-hidden">How many times? <input type="number" style="color: #444;" name="wedp-multiple-products-number" class="wedp-multiple-products-number" min="2" value="2"><p><input style="" type="button" name="wedp-duplicate-multiple-products-button" id="publish" class="wedp-duplicate-multiple-products-button button button-primary button-small" value="Duplicate multiple" width="20">
<div class="wedp-multi-status-message"><span>Done!</span></div>
</div>
</div>
<p><small><em><a style="color: #444;" href="https://bit.ly/wpgem-go" target="_blank">(Feature request?)</a></em></small></p>

<script type="text/javascript">
	(function($){
		"use strict"


		var $input_container = $('.wedp-multiple-products-input-container');
		var $duplicate_multiple_products_button_switch = $('.wedp-multiple-products-switch-button');
		var $duplicate_multiple_products_button = $input_container.find('.wedp-duplicate-multiple-products-button');
		var $duplicate_multiple_products_number_input = $input_container.find('.wedp-multiple-products-number');


		$duplicate_multiple_products_button.on('click', function(e){

			let duplicate_number = $duplicate_multiple_products_number_input.val();

			if(confirm("Please confirm. This product will be duplicated "+ duplicate_number +" times.")){
						console.log('Multiduplication.', duplicate_number);

						var data = {
							action: 'wedp_duplicate_product',
							product_id : wedp_product_id,
							multiple_products_number: duplicate_number,
							wedp_multiple_product_duplicate: true,
							_wp_nonce: wedp_wp_nonce
						};
						
						let $status_message = $('.wedp-multi-status-message');
						$status_message.text('Multiplying your product...');
						$status_message.show();

						$.post(ajaxurl, data, function(response){


							//console.log(response);
							response = JSON.parse(response);
							let status = response.status;

							if (status == 'success'){

							$status_message.addClass('wedp-green');
							$status_message.text('Done!');

								setTimeout(5000, function hideMultiDoneMessage(){
									$status_message.hide('slow');
								})

							}

						});
			}

		});


		$duplicate_multiple_products_button_switch.on('click', function(){

			$input_container.toggle();

		});

	})(jQuery);


</script>