<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><? $APPLICATION->SetTitle("Оформление заказа"); ?>
<? $APPLICATION->IncludeFile($APPLICATION->GetTemplatePath(SITE_TEMPLATE_PATH."/includes/basket_broadcrumb.php"), array("arCrumb" => 2), array("MODE" => "html"));
?>
<? //echo ShowError($arResult["ERROR_MESSAGE"]); ?>

<table border="0" cellspacing="0" cellpadding="1">
	<tr>
		<td valign="top" class="auths">
			<div class="formauth">
				<h2>Уже покупали у нас?</h2>

				<form method="post" action="/basket/order/" class="jqtransform" name="order_auth_form">
					<table class="sale_order_full_table">
						<tr>
							<td nowrap><p class="bld"><b>Электронная почта</b></p>
								<p>
									<input type="text" name="USER_LOGIN" maxlength="30" size="30" value="<?= $arResult["USER_LOGIN"] ?>">
								</p></td>
						</tr>
						<tr>
							<td nowrap><p class="bld"><b><? echo GetMessage("STOF_PASSWORD") ?></b></p>
								<p>
									<input type="password" name="USER_PASSWORD" maxlength="30" size="30">
								</p></td>
						</tr>
						<tr>
							<td nowrap><p class="repair"><a class="grey" href="/personal/profile/forgot-password/">Восстановить пароль</a></p></td>
						</tr>
						<tr>
							<td nowrap>
								<input onclick="_gaq.push(['_trackEvent', 'Button', 'Auth', 'Order']);" type="submit" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Войти и купить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
								<input type="hidden" name="do_authorize" value="Y"></td>
						</tr>
					</table>
				</form>
				<br>
				<table>
					<tr>
						<?/*<td><span class="bold">Войти с помощью профиля&nbsp;&nbsp;&nbsp;</span></td>*/?>
						<td class="socserv-auth-block"><span class="bold socserv-auth-block-head">Войти с помощью профиля&nbsp;&nbsp;&nbsp;</span><?

							$oAuthManager = new CSocServAuthManager();
							$arServices = $oAuthManager->GetActiveAuthServices($arResult);

							if(!empty($arServices))
							{
								$arResult["AUTH_SERVICES"] = $arServices;
								if(isset($_REQUEST["auth_service_id"]) && $_REQUEST["auth_service_id"] <> '' && isset($arResult["AUTH_SERVICES"][$_REQUEST["auth_service_id"]]))
								{
									$arResult["CURRENT_SERVICE"] = $_REQUEST["auth_service_id"];
									if(isset($_REQUEST["auth_service_error"]) && $_REQUEST["auth_service_error"] <> '')
									{
										$arResult['ERROR_MESSAGE'] = $oAuthManager->GetError($arResult["CURRENT_SERVICE"], $_REQUEST["auth_service_error"]);
									}
									elseif(!$oAuthManager->Authorize($_REQUEST["auth_service_id"]))
									{
										$ex = $APPLICATION->GetException();
										if ($ex)
											$arResult['ERROR_MESSAGE'] = $ex->GetString();
									}
								}
							}

							if($arResult["AUTH_SERVICES"]) {
							?><?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
								array(
									"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
									"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
									"AUTH_URL" => $arResult["AUTH_URL"],
									"POST" => $arResult["POST"],
									"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
									"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
									"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
								),
								$component,
								array("HIDE_ICONS"=>"Y")
							);?><?
							}?></td>
					</tr>
				</table>
			</div>
		</td>
		<td valign="top" width="100%"><? if($arResult["AUTH"]["new_user_registration"] == "Y"): ?>
				<div class="formauth">
					<h2>Если первый раз, то Вам сюда.</h2>

					<form method="post" class="jqtransform" action="/basket/order/" name="order_reg_form">
						<table class="sale_order_full_table">
							<tr>
								<td nowrap><input type="hidden" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N"></td>
							</tr>
							<? if ($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"): ?>
							<tr>
								<td>
									<div id="sof_choose_login">
										<table>
											<? endif; ?>
											<tr<?= (in_array("NEW_NAME", $arResult["POST_NAME_ERROR"])?' class="input-error"':'') ?>>
												<td><p class="bld"><b>Имя</b> <span class="req">*</span></p>
													<p>
														<input type="text" name="NEW_NAME" size="30" value="<?= $arResult["POST"]["NEW_NAME"] ?>">
													</p></td>
											</tr>
											<tr<?= (in_array("NEW_PHONE", $arResult["POST_NAME_ERROR"])?' class="input-error"':'') ?>>
												<td><p class="bld"><b>Телефон</b> <span class="req">*</span></p>
													<p>
														<input id="NEW_PHONE" type="text" name="NEW_PHONE" size="30" value="<?= $arResult["POST"]["NEW_PHONE"] ?>">
													</p></td>
											</tr>
											<tr<?= (in_array("NEW_LOGIN", $arResult["POST_NAME_ERROR"])?' class="input-error"':'') ?>>
												<td><p class="bld"><b>Электронная почта</b> <span class="req">*</span></p>
													<p>
														<input type="text" name="NEW_LOGIN" size="30" value="<?= $arResult["POST"]["NEW_LOGIN"] ?>">
													</p></td>
											</tr>
											<tr<?= (in_array("NEW_LOCATION", $arResult["POST_NAME_ERROR"])?' class="input-error"':'') ?>>
												<td><p class="bld"><b>Населенный пункт</b> <span class="req">*</span></p>
													<p>
														<select name="NEW_LOCATION">
															<option value=""></option>
															<?
															if(strlen($arResult["POST"]["NEW_LOCATION"]) <= 0) $arResult["POST"]["NEW_LOCATION"] = 1732;
															$rsLoc = CSaleLocation::GetList(array(
																"SORT" => "ASC",
																"CITY_NAME_LANG" => "ASC"
															), array(
																"LID" => LANGUAGE_ID,
																"COUNTRY_ID" => 19
															), false, false, array());
															while ($arLoc = $rsLoc->Fetch())
															if (strlen($arLoc["CITY_NAME"]) > 0)
															{
															?>
															<option<?= ($arLoc["ID"] == $arResult["POST"]["NEW_LOCATION"]?' selected="selected"':'') ?> value="<?= $arLoc["ID"] ?>"><?= $arLoc["CITY_NAME"] ?></option><?
															}?></select>
													</p>
												</td>
											</tr>
											<tr<?= (in_array("NEW_ADDRESS", $arResult["POST_NAME_ERROR"])?' class="input-error"':'') ?>>
												<td><p class="bld"><b>Адрес</b> <span class="req">*</span></p>
													<p>
														<textarea class="textareaAddress" name="NEW_ADDRESS"><?= $arResult["POST"]["NEW_ADDRESS"] ?></textarea>
													</p></td>
											</tr>
											<tr>
												<td><p class="bld"><b>Дата доставки</b></p>
													<p>
														<?
														$APPLICATION->IncludeComponent("bitrix:main.calendar", "", Array(
																"SHOW_INPUT" => "Y",
																"FORM_NAME" => "order_reg_form",
																"INPUT_NAME" => "NEW_DATE",
																"INPUT_NAME_FINISH" => "",
																"INPUT_VALUE" => $arResult["POST"]["NEW_DATE"],
																"INPUT_VALUE_FINISH" => "",
																"SHOW_TIME" => "N",
																"HIDE_TIMEBAR" => "Y"
															), false);
														?>
													</p></td>
											</tr>
											<tr>
												<td>
													<p class="bld"><b>Комментарий</b></p>
													<p>
														<textarea class="textareaAddress" name="NEW_COMMENT"><?= $arResult["POST"]["NEW_COMMENT"] ?></textarea>
													</p></td>
											</tr>
											<? if ($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"): ?>
										</table>
									</div>
								</td>
							</tr>
						<? endif; ?>
							<?
							if($arResult["AUTH"]["captcha_registration"] == "Y") //CAPTCHA
							{
								?>
								<tr>
									<td><br /> <b>
											<?= GetMessage("CAPTCHA_REGF_TITLE") ?>
										</b></td>
								</tr>
								<tr>
									<td><input type="hidden" name="captcha_sid" value="<?= $arResult["AUTH"]["capCode"] ?>">
										<img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["AUTH"]["capCode"] ?>" width="180" height="40" alt="CAPTCHA">
									</td>
								</tr>
								<tr valign="middle">
									<td><span class="sof-req">*</span>
										<?= GetMessage("CAPTCHA_REGF_PROMT") ?>
										:<br /> <input type="text" name="captcha_word" size="30" maxlength="50" value=""></td>
								</tr>
							<?
							}
							?>
							<tr>
								<td><p class="auth_form_btn_reg">
										<input onclick="_gaq.push(['_trackEvent', 'Button', 'Register', 'Order']);" type="submit" value="Зарегестрироваться и купить">
									</p>
									<input type="hidden" name="do_register" value="Y"> <br> <br></td>
							</tr>
						</table>
					</form>
				</div>
			<? endif; ?></td>
	</tr>
</table>