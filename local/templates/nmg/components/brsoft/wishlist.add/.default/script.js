function changeText(elem, changeVal) {
    if ((elem.textContent) && (typeof (elem.textContent) != "undefined")) {
        elem.textContent = changeVal;
    } else {
        elem.innerText = changeVal;
    }
}

;(function(window){

	if(window.brWishlist){
		return;
	}
	brWishlist = function(params){
		this.ID = params.ID;
		this.EXISTS = params.EXISTS;
		this.PARENT_TYPE = params.PARENT_TYPE;
		this.PARENT_ID = params.PARENT_ID;
		this.ELEMENT_ID = params.ELEMENT_ID;
		this.WISHLIST_ELEMENT_ID = params.WISHLIST_ELEMENT_ID;
		this.AJAX_URL = params.AJAX_URL;
		this.self = BX(this.ID);
		this.DELAY_LOAD = params.DELAY_LOAD;
	}
	
	brWishlist.prototype.onClick = function(){
		if(this.EXISTS) this.removeElement();
		else this.addElement();
	}
	
	brWishlist.prototype.addElement = function(){
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=ADD&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID,
			onsuccess: BX.delegate(this.addHandler, this)
		});
	}
	
	brWishlist.prototype.addHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = result.WID;
			this.EXISTS = true;
			
			BX.addClass(this.self, "exists");
			changeText(this.self, BX.message('BRSOFT_WISHLIST_IN'));
		}else{
			this.handleError(result);
		}
	}
	
	brWishlist.prototype.removeElement = function(){
		BX.ajax({
			timeout:   30,
			method:   'POST',
			dataType: 'json',
			url:       this.AJAX_URL,
			data:      "ACTION=DELETE&WID="+this.WISHLIST_ELEMENT_ID,
			onsuccess: BX.delegate(this.removeHandler, this)
		});
	}
	
	brWishlist.prototype.removeHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = 0;
			this.EXISTS = false;
			BX.removeClass(this.self, "exists");
			changeText(this.self, BX.message('BRSOFT_WISHLIST_ADD'));
		}else{
			this.handleError(result);
		}
		
	}
	
	brWishlist.prototype.bindEvents = function(){
		BX.bind(this.self, 'click', BX.proxy(this.onClick, this));
		
		if(this.DELAY_LOAD){
			BX.ajax({
				timeout:   30,
				method:   'POST',
				dataType: 'json',
				url:       this.AJAX_URL,
				data:      "ACTION=CHECK&PARAM1="+this.PARENT_TYPE+"&PARAM2="+this.PARENT_ID+"&PARAM3="+this.ELEMENT_ID,
				onsuccess: BX.delegate(this.checkHandler, this)
			});
		}
	}
	
	brWishlist.prototype.checkHandler = function(result){
		if(result.result){
			this.WISHLIST_ELEMENT_ID = result.WID;
			this.EXISTS = true;
			BX.addClass(this.self, "exists");
		}else{
			this.WISHLIST_ELEMENT_ID = 0;
			this.EXISTS = false;
			BX.removeClass("exists");
		}
		

	}
	
	brWishlist.prototype.handleError = function(result){
		if(!result["result"]){
			console.log(result["err_code"]);
		}
	}
	
})(window);