<!DOCTYPE html>
<html>
<head>

<style>
	label,input {
		display: block;
	}
	.error{
		color: red;
	}
</style>

<script language="javascript" type="text/javascript">
	/* this is just a simple reload; you can safely remove it; remember to remove it from the image too */
	function reloadCaptcha()
	{
		document.getElementById('captcha').src = document.getElementById('captcha').src+ '?' +new Date();
	}
</script>
</head>

<body>

		
		<?php 
			if($message){
				echo $message;
			}
		echo form_open('admin/login');?>
		<p>
			<label for="username">Username</label><br />
			<?php echo form_error('username');?>
			<input name="username" type="text" value="<?php echo set_value('username');?>"></input>
		</p>
		<p>	
			<label for="password">password</label><br />
			<?php echo form_error('password');?>
			<input name="password" type="password" value=""></input>
		</p>
		<p>
			<span class="explain">click on the image to reload it</span><br />
			<img src="/index.php/login/captcha" alt="Click to reload image" title="Click to reload image" id="captcha" onclick="javascript:reloadCaptcha()" />
		</p>
		<p>
			<?php if($captcha_error):?>
				<p class="error"><?php echo $captcha_error;?></p>
			<? endif;?>
		</p>
		<p>
			<label for="secure">Captcha Answer</label><br />
			<?php echo form_error('secure');?>
			<input type="text" name="secure" value=""/>
		</p>
			<h1 class="enter">
				<input type="submit" name="submit" value="LOGIN">
			</h1>
		<?php echo form_close();?>
		</div>
	</div>
		</div>
	</body>
</html>