{root:}
	<form action="/-subscribe/subscribe.php">
		<div class="input-group">
			<input type="text" id="infrajssubscribe{id}" class="form-control" name="email" placeholder="{config.placeholder}">
			<span class="input-group-btn">
				<button class="btn {config.btnclass}" type="submit">{config.submit}</button>
			</span>
		</div>
		{config.mask?:mask}
	</form>
{mask:}
	<script>
		domready(function(){
			$("#infrajssubscribe{id}").mask("+7 (999) 999-9999");
		});
	</script>