var operatorInvite = false;
var isOperatorOnline = false;
var boolOpenInvite = true;


UisConsultant = { 
    // количество попыток соединения с сервером
    left_connect_atempt: 5,
    // задают значение, на которое будет смещён баннер от углов экрана
    TO_LEFT: 5,
    TO_TOP: 7,
    // код баннера для вставки
    html: '<div id="uis-online-consultant">\
        <div id="uis_invite" style="display: none;">\
            <div class="uis-transparency"></div>\
            <div class="uis-close-invite">\
                <img src="{{web_host}}static/client/images/close_invite.png?rnd={{rnd}}">\
                <span id="uis_close_invite">Закрыть</span>\
            </div>\
            <div class="uis-panel">\
                <table><tr>\
                        <td><img src="" id="uis_operator_photo"></td>\
                        <td> \
                            <b>Консультант: </b><span id="uis_operator_name"></span>\
                            <div id="uis_operator_question"></div>\
                        </td>\
                </tr></table>\
                <textarea id="uis_answer_textarea"></textarea>\
                <div class="uis-invite-open-chat">\
                    <input type="button" value="Отправить" id="uis_invite_open_chat" style="display:none;">\
					<input type="button" value="Отправить" onclick="UisConsultant.inviteOpenChat.click();">\
                </div>\
            </div>\
        </div>\
        <div id="uis_consultant"  style="background: url(http://www.mamingorodok.ru/bitrix/templates/Mami/images/consult-offline.png) no-repeat top left; background-color:#FF0000; display: none;">\
            <table id="uis_consultant_wind">\
                <tr><td class="uis-empty-td"></td><td class="uis-close-button" id="uis_mininmize_banner">&nbsp;</td></tr>\
                <tr><td class="uis-empty-td"></td><td class="uis-main-link">&nbsp;</td></tr>\
                <tr><td class="uis-empty-td"></td><td class="uis-desc">&nbsp;</td></tr>\
                <tr><td></td><td>&nbsp;</td></tr>\
            </table>\
        </div>\
        <div id="uis_consultant_wind_h" style="background: url({{web_host}}static/client/images/consult-h.png); display: none;"></div>\
        </div>',
    // код флеша для вставки    
    flash_html: '<div>\
          <object id="flash_socket{{banner_id}}" name="sock{{banner_id}}" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="0" height="0" align="middle">\
              <param name="allowScriptAccess" value="always" />\
              <param name="movie" value="{{web_host}}static/client/flash/flash_socket.swf?socketName=sock{{banner_id}}" />\
              <embed id="flash_socket{{banner_id}}" src="{{web_host}}static/client/flash/flash_socket.swf?socketName=sock{{banner_id}}" name="sock{{banner_id}}" width="0" height="0" align="middle"  allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />\
          </object>\
        </div>',

    // private
    // запоминает состояние баннера для синхронизации баннеров (свёрнут/не свёрнут)
    minimize_banner: false,
    // таймер для синхронизации баннеров на сайте
    cookieTimer: undefined,

    // private
    // функция инициализации
    init: function (id, key, host, port, customer_id, web_host) {
        this.initLogger();
        this.log('starting', 'init', 'info');
        this.id = id;
        this.key = key;
        this.host = host;
        this.port = port;
        this.customer_id = customer_id;
        this.web_host = web_host;
        
        this.sock = window['sock' + id] = {};
        this.visitor_key = this.getCookie('ulab_visitor_key' + this.customer_id);
        var self = this;
        if (document.body === null) {
            setTimeout(function(){ self.initAll.call(self); }, 200);
        } else {
            this.initAll();
        }
        this.log('done', 'init', 'info');
    },
    // функция нужна отдельно, если вдруг скрипты вставлены в head и document.body не найден ко времени запуска инициализации
    initAll: function(){
        this.log('starting', 'initAll', 'info');
        this.initHTML();
        this.initFlash();
        this.log('done', 'initAll', 'info');
    },
    
    //private
    // вставка кода флеша на сайт, инициализация флеша
    initFlash: function(){
        this.log('starting', 'initFlash', 'info');
        var node = document.getElementsByTagName("head")[0].appendChild( document.createElement("link") );
        node.setAttribute("rel", "stylesheet");
        node.setAttribute("media", "all");
        node.setAttribute("type", "text/css");
        node.setAttribute("href", this.web_host + "static/client/css/consultant/uis_consultant.css?rnd=" + this.rnd);
        
        var div = document.createElement("div");
        document.body.appendChild(div);
        div.innerHTML = this.getHtmlText(this.flash_html);
        this.initFlashPlayer();
        this.log('done', 'initFlash', 'info');
    },
    
    // private
    getHtmlText: function(text){
        return text.replace(/{{web_host}}/g, this.web_host).replace(/{{rnd}}/g, this.rnd).replace(/{{banner_id}}/g, this.id);
    },
    
    // private
    // в функции "находятся" все нужные элементы html
    initComponents: function() {
        this.initBanners();
        this.initInvite();
    },

    //private
    // инициализация переменных для приглашения
    initInvite: function(){
        // приглашение и иже с ним
        this.invite = document.getElementById('uis_invite');
        this.inviteTextarea = document.getElementById('uis_answer_textarea');
        this.inviteClose = document.getElementById('uis_close_invite');
        this.inviteOpenChat = document.getElementById('uis_invite_open_chat');
		
        this.inviteOperatorPhoto = document.getElementById('uis_operator_photo');
        this.inviteOperatorName = document.getElementById('uis_operator_name');
        this.inviteOperatorQuestion = document.getElementById('uis_operator_question');
		if(this.getCookie("consultantAutoOpen") != "N") setTimeout('showInvite()', 15000);
    },
    
    //private
    // инициализация переменных для баннеров
    initBanners: function(){
        // баннер
        this.banner = document.getElementById('uis_consultant');
		this.banner.style.position = "fixed"; 
		this.banner.style.top = parseInt(document.body.clientHeight/2 - 70)+"px";
		this.banner.style.left = 0;
        // минимизированный баннер
        this.minBanner = document.getElementById('uis_consultant_wind_h');
        this.elMinimizeBanner = document.getElementById('uis_mininmize_banner');
    },
    
    // private
    // инициализация событий для html-элементов
    initEvents: function() {
        var self = this;
        this.banner.onclick = function(e){ boolOpenInvite = false; self.openChat.call(self, e); }
        this.minBanner.onclick = function(e){ self.maximizeBanner.call(self, e); }
        this.elMinimizeBanner.onclick = function(e){ self.minimizeBanner.call(self, e); }
        this.inviteClose.onclick = function(e){ self.onClickCloseInvite.call(self, e); }
        this.inviteOpenChat.onclick = function(e){ self.openChat.call(self, e); }
    },
    
    // private
    initFlashPlayer: function() {
        this.log('starting', 'initFlashPlayer', 'info');
        var self = this;
        // onFlashSocketReady сокет вызывается, когда инициализируется, если сокет вдруг загрузится раньше - эту функцию вызовет js
        this.sock.onFlashSocketReady = function(){
            self.log('starting', 'sock.onFlashSocketReady', 'info');
            self.log('asserting socket...', 'sock.onFlashSocketReady', 'info');
            self.assertSocket();
            // отсылаем серверу информацию о посетителе
            self.sock.onConnect = function(){
                self.log('starting', 'sock.onConnect', 'info');
                var cmd = '{"command":"visitor_insite"' +
                    ',"banner_key":' + (self.key ? self.quote(self.key) : 'null') +
                    ',"visitor_key":' + (self.visitor_key ? self.quote(self.visitor_key) : 'null') + 
                    ',"title":' + self.quote(document.title) +
                    ',"url":' + self.quote(location.href) + 
                    ',"referrer":' + self.quote(document.referrer) +
                    ',"navigator":' + self.quote(navigator.appName + '(' + navigator.appVersion + ')') +
                    '}';
                self.sock.send(cmd);
            };
            self.sock.onClose = function() { self.onCloseSocket.apply(self, ['1'].concat(arguments)); };
            self.sock.onIOError = function() { self.onCloseSocket.apply(self, ['2'].concat(arguments)); };
            self.sock.onSecurityError = function() { self.onCloseSocket.apply(self, ['3'].concat(arguments)); };
            // функция вызовется, если сокету придут данные
            self.sock.onData = function(data){
                var cmd = self.jsonParse(data);
                // если нужно поменять состояние баннера
                if (cmd.command === 'refresh_state'){
                    // установка внутренних значений
                    if (cmd.visit_id){
                        self.visit_id = cmd.visit_id;
                    }
                    if (cmd.visitor_id){
                        self.visitor_id = cmd.visitor_id;
                    }
                    self.state = cmd.state;
                    switch (cmd.state){
                        // поменялся статус у операторов
                        case 'online':
                        case 'offline':
                            self.onChangeState(cmd.state);
							isOperatorOnline = cmd.state == "online";
                            break;
                        // клиент вошёл в чат с оператором
                        case 'in_chat':
                            self.onOpenChat();
                            break;
                        // оператор прислал приглашение посетителю
                        case 'invite':
							operatorInvite = true;
                            self.onOpenInvite(cmd);
                            break;
                    }
                } else 
                // если посетитель первый раз на странице, устанавливаем для него куки
                if (cmd.command === 'set_visitor_key'){
                    self.visitor_key = cmd.visitor_key;
                    self.setCookie('ulab_visitor_key' + self.customer_id, self.visitor_key);
                } else 
                // команда присылается сервером раз в час, дабы убедиться что баннер ещё жив
                if (cmd.command === 'ping'){
                    self.sock.send('{"command": "ping"}');
                }
            }
            self.onSocketConnect();
            self.log('done', 'sock.onFlashSocketReady', 'info');
        }
        // если сокет загрузился и уже попробовал безуспешно вызвать onFlashSocketReady, вызываем функцию ещё раз
        if (this.sock.ready === true){
            this.sock.onFlashSocketReady();
        }
        this.log('done', 'initFlashPlayer', 'info');
    },
    
    // private
    // функция вызывается, если баннер не может подключиться к серверу
    onSocketConnect: function() {
        this.log('starting', 'onSocketConnect', 'info');
        if (this.left_connect_atempt > 0){
            this.log('trying to connect' + this.left_connect_atempt, 'onSocketConnect', 'info');
            this.left_connect_atempt--;
            this.sock.connect(this.host, this.port);
        }
    },
    
    // private
    // функции используются вместо функций модуля JSON, поскольку ie7 и ie в quirks mode его не поддерживает
    jsonParse: function(){var h,a,k={'"':'"',"\\":"\\","/":"/",b:"\u0008",f:"\u000c",n:"\n",r:"\r",t:"\t"},j,f=function(a){throw{name:"SyntaxError",message:a,at:h,text:j};},c=function(b){b&&b!==a&&f("Expected '"+b+"' instead of '"+a+"'");a=j.charAt(h);h+=1;return a},l=function(){var b;b="";"-"===a&&(b="-",c("-"));for(;"0"<=a&&"9">=a;)b+=a,c();if("."===a)for(b+=".";c()&&"0"<=a&&"9">=a;)b+=a;if("e"===a||"E"===a){b+=a;c();if("-"===a||"+"===a)b+=a,c();for(;"0"<=a&&"9">=a;)b+=a,c()}b=+b;if(isFinite(b))return b; f("Bad number")},m=function(){var b,g,d="",e;if('"'===a)for(;c();){if('"'===a)return c(),d;if("\\"===a)if(c(),"u"===a){for(g=e=0;4>g;g+=1){b=parseInt(c(),16);if(!isFinite(b))break;e=16*e+b}d+=String.fromCharCode(e)}else if("string"===typeof k[a])d+=k[a];else break;else d+=a}f("Bad string")},e=function(){for(;a&&" ">=a;)c()},n=function(){switch(a){case "t":return c("t"),c("r"),c("u"),c("e"),!0;case "f":return c("f"),c("a"),c("l"),c("s"),c("e"),!1;case "n":return c("n"),c("u"),c("l"),c("l"),null}f("Unexpected '"+ a+"'")},i;i=function(){e();switch(a){case "{":var b;a:{var g,d={};if("{"===a){c("{");e();if("}"===a){c("}");b=d;break a}for(;a;){g=m();e();c(":");Object.hasOwnProperty.call(d,g)&&f('Duplicate key "'+g+'"');d[g]=i();e();if("}"===a){c("}");b=d;break a}c(",");e()}}f("Bad object")}return b;case "[":a:{b=[];if("["===a){c("[");e();if("]"===a){c("]");g=b;break a}for(;a;){b.push(i());e();if("]"===a){c("]");g=b;break a}c(",");e()}}f("Bad array")}return g;case '"':return m();case "-":return l();default:return"0"<= a&&"9">=a?l():n()}};return function(b,c){var d;j=b;h=0;a=" ";d=i();e();a&&f("Syntax error");return"function"===typeof c?function o(a,b){var d,e,f=a[b];if(f&&"object"===typeof f)for(d in f)Object.prototype.hasOwnProperty.call(f,d)&&(e=o(f,d),void 0!==e?f[d]=e:delete f[d]);return c.call(a,b,f)}({"":d},""):d}}(),    
    quote: function(a){var b=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,c={"\u0008":"\\b","\t":"\\t","\n":"\\n","\u000c":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"};b.lastIndex=0;return b.test(a)?'"'+a.replace(b,function(a){var b=c[a];return"string"===typeof b?b:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'},
    
    // private
    // устанавливает куки
    setCookie: function(name, value){
        var expiresDate = new Date();
        expiresDate.setTime(expiresDate.getTime() + 365*24*60*60*1000);
        document.cookie = name + "=" + encodeURIComponent(value) + "; path=/; expires=" + expiresDate.toGMTString() + ";";
    },
    
    // private
    // считывает куки
    getCookie: function(name){
        var prefix = name + "=";
        var cookieStartIndex = document.cookie.indexOf(prefix);
        if (cookieStartIndex == -1)
            return null;
        var cookieEndIndex = document.cookie.indexOf(";", cookieStartIndex + prefix.length);
        if (cookieEndIndex == -1)
            cookieEndIndex = document.cookie.length;
        return decodeURIComponent(document.cookie.substring(cookieStartIndex + prefix.length, cookieEndIndex));
    },
    
    // common
    // установка видимости для баннеров и приглашения
    setDisplay: function (banner, minBanner, invite) {
        if (banner !== undefined && this.banner) {
            this.banner.style.display = banner;
        }
        if (minBanner !== undefined && this.minBanner) {
            this.minBanner.style.display = minBanner;
        }
        if (invite !== undefined && this.invite) {
            this.invite.style.display = invite;
        }
    },
    
    // ---------------------- banner -------------------------

    // code reduce - для синхронизации "минималистичности" баннера.
    setMinimizeBannerState: function(state){
        this.minimize_banner = state;
        // дополнительный куки для отдельно для статуса - чтобы если баннер был свёрнут в состоянии оффлайн, 
        //     при появлении операторов онлайн он развернулся снова. 
        this.setCookie('ulab_minimize_banner_state', state);
    },
    
    // code reduce - для смены статуса баннера
    setMaximizeBanner: function(maximize){
        this.setDisplay(maximize ? 'block' : 'none', maximize ? 'none' : 'block', 'none');
        // куки для синхронизации действия пользователя
        this.setCookie('ulab_banner_state', maximize ? 'banner' : 'minBanner');
    },
    
    // вызывается по клику на "X" в баннере 
    // сворачивает баннер
    minimizeBanner: function(event){
        if (this.state == 'online'){
            this.setMinimizeBannerState(true);
        }
        this.setMaximizeBanner(false);
        event ? (event.stopPropagation ? event.stopPropagation() : event.cancelBubble = true) : window.event.cancelBubble = true;
    },
    
    // вызывается по клику на минимизированный баннер 
    // разворачивает баннер до нормального состояния
    maximizeBanner: function(){
        this.setMinimizeBannerState(false);
        this.setMaximizeBanner(true);
    },
    
    // вызывается по нажатию на "Закрыть" в приглашении
    // минимизирует баннер, отправляет сокету команду "reject_invite"
    onClickCloseInvite: function(){
		this.setCookie("consultantAutoOpen", "N");
        this.setMinimizeBannerState(true);
        this.setDisplay('block', 'none', 'none');
		this.setCookie('ulab_banner_state', 'banner');
		if(operatorInvite)
			this.rejectInvite();
		operatorInvite = true;
    },
    
    // вызывается по закрытию/ошибке сокета
    // убирает баннер и пробует снова коннектится
    onCloseSocket: function(){
        this.setDisplay('none', 'none', 'none');
        this.onSocketConnect();
    },

    // ----------------------- synchronize banner ------------------------
    // вызывается каждую секунду
    // синхронизирует куки баннера на одном сайте
    synchronizeBanner: function(){
        if (this.state && this.state !== 'in_chat' && this.state !== 'invite'){
            var val = this.getCookie('ulab_banner_state');
            switch (val){
                case 'banner':     this.setDisplay('block', 'none', 'none');  break;
                case 'minBanner':  this.setDisplay('block', 'none', 'none');  break; // this.setDisplay('none', 'block', 'none');  break;
            }
        }
    },
    
    // ----------------------- for ie in Quirks mode only ------------------------
    // вызывается при инициализации
    // добавляет соответствующие классы и обработчики событий к html
    fixForIEQuirks: function(){
        var self = this;
        this.banner.className = this.invite.className = this.minBanner.className = "uis-consultant-ie-quirks";        
        window.attachEvent('onresize', function(){ self.setTiming.call(self); });
        window.attachEvent('onscroll', function() { self.setTiming.call(self); });
        this.changePosition();
    },
    
    // вызывается если произошло событие onresize или onscroll у window
    // ждёт пока не остановится прокрутка или изменение размеров страницы
    // реализовано через таймер затем, чтобы баннер не дёргался при данных событиях
    setTiming: function(){
        var self = this;
        if (this.timer) clearTimeout(this.timer);
        this.timer = setTimeout(function() { self.changePosition.call(self); }, 500);
    },
    
    // устанавливает позицию баннера на странице
    changePosition: function(){
        var h = document.body.clientHeight, 
            w = document.body.clientWidth,
            t = document.body.scrollTop,
            l = document.body.scrollLeft;
        //this.banner.style.top = h + t - (this.TO_TOP + 73) + 'px';
        //this.banner.style.left = w + l - (this.TO_LEFT + 250) + 'px';
        this.invite.style.top = h + t - (this.TO_TOP + 218) + 'px';
        this.invite.style.left = w + l - (this.TO_LEFT + 450) + 'px';
        this.minBanner.style.top = h + t - (this.TO_TOP + 38) + 'px';
        this.minBanner.style.left = w + l - (this.TO_LEFT + 190) + 'px';
		
		this.banner.style.top = parseInt(document.body.clientHeight/2 - 70)+"px";
		this.banner.style.left = 0;
    },
    
//------------------------------------------------------------------------------------------------------------
// ----------------------------------------- функции, которые нужно использовать без изменения -----------------------------------------
//------------------------------------------------------------------------------------------------------------
    // открывает чат с оператором. если есть текст приглашения, он также вставится в url страницы с чатом
    openChat: function(){
        // var c = UisConsultant;
		strAddon = $("#uis_answer_textarea").val();
        window.open(this.web_host + 'consultant/visitor_' + (this.state === 'offline' ? 'mail' : 'chat') + 
            '/?banner_key=' + this.key + '&visitor_key=' + this.visitor_key + '&visit_id=' + this.visit_id + '&premessage=' + 
            (this.inviteTextarea ? encodeURIComponent(strAddon) : ""), "" , "width=500,height=450,scrollbars=0,resizable=yes,location=no,status=no");
        if (this.inviteTextarea) this.inviteTextarea.value = '';
    },
    // отсылает команду серверу "отмена приглашения"
    rejectInvite: function(){
        this.sock.send('{"command": "reject_invite"}');
    },

//------------------------------------------------------------------------------------------------------------
// ----------------------------------------- функции, которые можно менять -----------------------------------------
//------------------------------------------------------------------------------------------------------------
    // инициализация html, переопределить при необходимости
    initHTML: function(){
        var div = document.createElement("div");
        div.innerHTML = this.getHtmlText(this.html);
        document.body.appendChild(div);
        
        this.initComponents();
        this.initEvents();

        // for ie in Quirks mode
        if (navigator.appName == 'Microsoft Internet Explorer' && document.compatMode && document.compatMode === 'BackCompat'){
            this.isQuirksMode = true;
            this.fixForIEQuirks();
            return;
        }
        this.banner.className = this.invite.className = this.minBanner.className = "uis-consultant-all-others";
        this.minimize_banner = this.getCookie('ulab_minimize_banner_state') === 'true' || false;
        //setTimeout(function() { self.animatePencil.call(self, false); }, 20000);
        var self = this;
        this.cookieTimer = setInterval(function(){
            self.synchronizeBanner.call(self);
        }, 1000);
    },
    
    // вызывается при событии от сервера "refresh_state"
    onChangeState: function(state){
        if (!this.minimize_banner){
            this.setDisplay('block', 'none', 'none');
            this.setCookie('ulab_banner_state', 'banner');
        }
        this.banner.style.background = 'url("http://www.mamingorodok.ru/bitrix/templates/Mami/images/consult-' + state + '.png")';
    },
    
    // вызвается, когда сервер присылает событие "in_chat", когда чат посетителя законнектился через сокет к серверу
    onOpenChat: function(){
        this.setDisplay('none', 'none', 'none');
    },
    
    // вызывается, когда приходит приглашение от оператора посетителю
    onOpenInvite: function(cmd){
        var c = UisConsultant;
        c.setDisplay('none', 'none', 'block');
        c.inviteOperatorQuestion.innerHTML = cmd.message;
        c.inviteOperatorPhoto.src = cmd.file_link || (c.web_host + "static/client/images/user-icon-100.png");
        c.inviteOperatorName.innerHTML = cmd.operator_name;
        c.inviteTextarea.value = "";
    },
    //private
    initLogger: function() {
        var l = window.location;
        if (!l) {
            return;
        }
        var s = l.search || '';
        if (s.indexOf('uisconsultantdebug=true') == -1) {
            return;
        }
        var d = document.createElement('DIV');
        d.setAttribute('class', 'uis-consultant-log');
        document.body.appendChild(d);
        if (this.isQuirksMode) {
            d.style.left = 0;
            d.style.top = 0;
            d.style.position = 'absolute';
            d.style.backgroundColor = '#ffffff';
        }
        this.loggerBox = d;
    },
    formatDate: function(date) {
        date = (date || new Date());
        var dateStr = date + '';
        var match = /(.*\s\d{2}:\d{2}:\d{2})/.exec(dateStr);
        if (!match) {
            return dateStr;
        }
        return match[1] + '.' + date.getMilliseconds();
    },
    log: function(msg, objName, type) {
        if (!this.loggerBox) {
            return;
        }
        objName = objName || 'common';
        msg += '';
        msg = '[' + this.formatDate() + '][' + objName + ']' + msg;
        var d = document.createElement('DIV');
        var cls = 'uis-consultant-log-record';
        if (type == 'error') {
            cls += ' uis-consultant-log-record-error';
        }
        d.setAttribute('class', cls);
        d.innerHTML = msg;
        this.loggerBox.insertBefore(d, this.loggerBox.firstChild);
    },
    assertSocket: function() {
        var self = this;
        var properties = ['ready', '_bridge', 'close', 'connect', 'onClose', 'onConnect', 'onData', 'onFlashSocketReady', 'onIOError', 'onSecurityError', 'send'];
        for (var i = 0; i < properties.length; i++) {
            self.assertSocketProperty(properties[i]);
        }
    },
    assertSocketProperty: function(name) {
        var self = this;
        var prop = self.sock[name];
        self.log(name, 'assertSocket', prop ? 'info' : 'error');
    }

};

function showInvite()
{
	if(isOperatorOnline && boolOpenInvite)
	{
		$("#uis_invite_open_chat").hide();
		UisConsultant.onOpenInvite({message: "Здравствуйте, чем могу Вам помочь?", operator_name: "Мамин городок"});
		UisConsultant.state = 'invite';
	}
}

function encode_utf8( s )
{
  return unescape( encodeURIComponent( s ) );
}

function decode_utf8( s )
{
  return decodeURIComponent( escape( s ) );
}