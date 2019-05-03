{root:}
	<form action="/-subscribe/hand.php">
		
		<div class="input-group">
			<input type="text" id="infrajssubscribe{id}" class="form-control" name="emailphone" placeholder="{config.placeholder}">
			<span class="input-group-btn">
				<button class="btn {config.btnclass}" type="submit">{config.submit}</button>
			</span>
		</div>
		<p>
			<div id="recaptcha{id}" class="g-recaptcha" style="overflow:hidden"  data-sitekey="{~conf.recaptcha.sitekey}"></div>
		</p>

		<script>
			domready(function () {
				Event.one('reCAPTCHA', function (){
					grecaptcha.render('recaptcha{id}');
				});
			});
		</script>
		<!--<script>
			domready( function () {
				Event.one('Controller.onshow', function () {
					var layer = Controller.ids["{id}"];
					layer.onsubmit = function (layer) {
						var ans = layer.config.ans;
						if (!ans.result) return;
						Goal.reach('subscribe');
					}
				});
			});
		</script>-->
		{config.mask?:mask}
	</form>
{mask:}
	<script>
		domready(function(){
			$("#infrajssubscribe{id}").mask("+7 (999) 999-9999");
		});
	</script>