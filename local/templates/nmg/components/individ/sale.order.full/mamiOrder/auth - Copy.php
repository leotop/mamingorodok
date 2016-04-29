<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$APPLICATION->SetTitle("Оформление заказа"); ?>
<?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb"=>2), array("MODE"=>"html") );?>
<?//echo ShowError($arResult["ERROR_MESSAGE"]); ?>
<table border="0" cellspacing="0" cellpadding="1">
	<tr >
		<td valign="top" class="auths">
			<div class="formauth">
			<h2>Я уже зарегистрирован</h2>
			<form method="post" action="/basket/order/"  class="jqtransform" name="order_auth_form">
			<table class="sale_order_full_table">
					<tr>
						<td nowrap><p class="bld"><b>Электронная почта</b></p>
							<p><input type="text" name="USER_LOGIN" maxlength="30" size="30" value="<?=$arResult["USER_LOGIN"]?>"></p></td>
					</tr>
					<tr>
						<td nowrap><p class="bld"><b><?echo GetMessage("STOF_PASSWORD")?></b></p>
							<p><input type="password" name="USER_PASSWORD" maxlength="30" size="30"></p></td>
					</tr>
					<tr>
						<td nowrap><p class="repair"><a class="grey" href="/personal/profile/forgot-password/">Восстановить пароль</a></p></td>
					</tr>
					<tr>
						<td nowrap >
							<input type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Войти&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
							<input type="hidden" name="do_authorize" value="Y">
						</td>
					</tr>
				
					
			</table>
			</form>
			<br>
			<table>
			<tr><td>
			<span class="bold">Войти с помощью профиля&nbsp;&nbsp;&nbsp;</span>
			</td><td>
<?
			
			$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
				array(
					"AUTH_SERVICES"=>array(
						"VKontakte" => Array
							(
								"ID" => "VKontakte",
								"CLASS" => "CSocServVKontakte",
								"NAME" => "ВКонтакте",
								"ICON" => "vkontakte",
								"__sort" => 0,
								"__active" => 1,
								"FORM_HTML" =>'<a href="javascript:void(0)" onclick="VK.Auth.login(BxVKAuthInfo,1);" class="bx-ss-button vkontakte-button"></a><span class="bx-spacer"></span><span>Используйте вашу учетную запись VKontakte.ru для входа на сайт.</span>'
							)

					),
					"AUTH_URL"=>"/personal/auth/?login=yes",
					"POST"=>array(),
					"POPUP"=>"N",
					"SUFFIX"=>"form",
				), 
				$component, 
				array("HIDE_ICONS"=>"Y")
			);
?>
			</td></tr>
			</table>
			</div>
		</td>
		<td valign="top" width="100%">
			<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
				<div class="formauth">
				<h2>Зарегистрироваться</h2>
				<form method="post"  class="jqtransform" action="/basket/order/" name="order_reg_form">
					<table class="sale_order_full_table">
						
						
						<tr>
							<td nowrap><input type="hidden" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N"> </td>
						</tr>
						
						<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
						<tr>
							<td>
								<div id="sof_choose_login">
									<table>
						<?endif;?>
										<tr>
											
											<td>
											<p>Пожалуйста, зарегистрируйтесь, если вы делаете заказ впервые.</p>
											<p>Регистрация поможет отследить заказы и сократить время оформления последующих покупок.</p>
											</td>
										</tr>
										<tr>
											
											<td>
												<p class="bld"><b>Электронная почта</b></p>
												<p><input type="text" name="NEW_LOGIN" size="30" value="<?=$arResult["POST"]["NEW_LOGIN"]?>"></p>
											</td>
										</tr>
										<tr>
											
											<td>
												<p class="bld"><b><?echo GetMessage("STOF_PASSWORD")?></b></p>
												<p><input type="password" name="NEW_PASSWORD" size="30"></p>
											</td>
										</tr>
										<tr>
											
											<td>
												<p class="bld"><b>Еще раз пароль</b></p>
												<p><input type="password" name="NEW_PASSWORD_CONFIRM" size="30"></p>
											</td>
										</tr>
						<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
									</table>
								</div>
							</td>
						</tr>
						<?endif;?>
						
						<?
						if($arResult["AUTH"]["captcha_registration"] == "Y") //CAPTCHA
						{
							?>
							<tr>
								<td><br /><b><?=GetMessage("CAPTCHA_REGF_TITLE")?></b></td>
							</tr>
							<tr>
								<td>
									
									<input type="hidden" name="captcha_sid" value="<?=$arResult["AUTH"]["capCode"]?>">
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA">
								</td>
							</tr>
							<tr valign="middle">
								<td>
									<span class="sof-req">*</span><?=GetMessage("CAPTCHA_REGF_PROMT")?>:<br />
									<input type="text" name="captcha_word" size="30" maxlength="50" value="">
								</td>
							</tr>
							<?
						}
						?>
						<tr>
							<td >
								<p  class="auth_form_btn_reg" ><input type="submit"value="Зарегистрироваться"></p>
								<input type="hidden" name="do_register" value="Y">
								<br><br>
							</td>
						</tr>
					</table>
				</form>
				</div>
			<?endif;?>
		</td>
	</tr>
	
</table>


