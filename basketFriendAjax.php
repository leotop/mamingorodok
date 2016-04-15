<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?
	if($_REQUEST["do"]=="changeCertificate"){
		unset($_SESSION["buyfriend"]["certificate"]);
		foreach($_REQUEST["id"] as $v){
			$v = intval($v);
			if($v<=0)
				continue;
			if(isset($_SESSION["buyfriend"]["certificate"][$v]))
				$_SESSION["buyfriend"]["certificate"][$v]++;
			else
				$_SESSION["buyfriend"]["certificate"][$v]=1;
		}
		
	}
	if($_REQUEST["do"]=="updateBasket"){
	
		$user_id = intval($_REQUEST["user_id"]);
		if($user_id>0 && isset($_SESSION["buyfriend"][$user_id])){
			foreach($_REQUEST["id"] as $k=>$v){
				$count = intval($_REQUEST["count"][$k]);
				if($count<=0)
					continue;
				$_SESSION["buyfriend"][$user_id][$v] = $count;
			}				
		}
	}
?>