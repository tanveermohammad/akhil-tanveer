/**
 * popup js 
 * @author    Tanveer Mohammad <tanveer.mohammad@pennywisesolutions.com>
 * @package   Mikimoto\GeoRedirect
 * @since     1.0 First time this was introduced.
 * @copyright 1948-2019 Ogilvy
 * @description
 * the popup modal runs on dom ready. when ever a page loads, the popup will return
 * response @return $.Mikimoto.Popupto, provides buttons to respond to user actions.
 */
;define( 
    [ 
     'jquery', 
     'Magento_Ui/js/modal/modal' ,
      'mage/cookies',
    'domReady!'
    ],
   function ($) { 
        "use strict"; 
        var popup_enabled = parseInt($("#popupstatus").val());
        var store_code_url = $("#baseUrl").val();
        var domain_where_popup_works = $("#domain_where_popup_works").val();
        var hostname = window.location.origin;
        if(popup_enabled === 0)
    	{
    		window.console.log(popup_enabled);
    		window.console.log("popup disabled");
    	return;
    	}
        var hosturl = window.location.href;
        var hosturl = hosturl.split('?')[0]; 
        var hosturl = hosturl.slice(0, -1);
        if(hosturl === domain_where_popup_works)
    	{
        function getUrlVars()
        {
              var vars = {};
              var parts = window.location.href.replace(
                /[?&]+([^=&]+)=([^&]*)/gi, function (m,key,value) {
                    vars[key] = value;
                }
            );
              return vars;
        };
        var ipaddress = getUrlVars()["ip"];
      
     
        var slug = store_code_url.split('.php/').pop();
        var store_code_sliced = slug.replace('/', '');
        var slash = '/';
        var store_code_sliced = slash.concat(store_code_sliced);
        var currentpageURL = window.location.origin;
        var currentpageURL = currentpageURL.concat(store_code_sliced);
        /**
      * set the cookies on first visit to the website
    */
        if ($.cookie('country_redirect_url_user_choosed')) {
            /**
             * @param prefer_to_country_cookieurl users preferred url location
             */  
            var  prefer_to_country_cookieurl= $.cookie('country_redirect_url_user_choosed');
            /**
             * @param currentpageURL the page where the user is currently live 
             */ 
            var currentpageURL = window.location.origin;
            var currentpageURL = currentpageURL.concat(store_code_sliced);
            /**
    * checking if both the urls are same to block popup
    */  
            if(prefer_to_country_cookieurl === currentpageURL) {
                document.getElementById("mikimoto-popup-geo-main").style.display = 'none';
                document.getElementById("mikimoto-popup-geo").style.display = 'none';
                return;
            }}
         /**
    * check if the user has previously selected any option in the popup before
    */  
        if (!!$.mage.cookies.get('popup_geo_status')) {
                var popup_geo_status = $.mage.cookies.get('popup_geo_status');
        	}
        else 
            {
            $.mage.cookies.set('popup_geo_status', 'inactive');
            }
        //creating jquery widget 
        $.widget(
            'Mikimoto.Popup', { 
                options: { 
                    modalForm: '#popup', 
                    modalButton: '.popup-open' 
                }, 
                _create: function () { 
                    this.options.modalOption = this.getModalOptions(); 
                    this._bind(); 
                }, 
                getModalOptions: function () { 
                    /**
                     * * Modal options 
                     */ 
                     var xhttp = new XMLHttpRequest();
                      xhttp.onreadystatechange = function () {
                        if (this.readyState === 4 && this.status === 200) { 
                            window.geoContinue = function () {
                                /**
                                 * @const 
                                 */ var country_redirect_url_from_api = $.cookie('country_redirect_url_api');
                                $.cookie('country_redirect_url_user_choosed',country_redirect_url_from_api);
                                top.location.href= country_redirect_url_from_api;
                            };
                                window.geoStay = function () {
                                    /**
                                     * @const 
                                     */  var pageURL = window.location.origin;
                                    var pageURL = pageURL.concat(store_code_sliced);
                                    $.cookie('country_redirect_url_user_choosed', pageURL); 
                                    document.getElementById("mikimoto-popup-geo-main").style.display = 'none';
                                    document.getElementById("mikimoto-popup-geo").style.display = 'none';
                                    
                                };
                                /**
                                 * @param popup_data the webservice json response here 
                                 */
                                var popup_data = JSON.parse(this.responseText);
                                /**
                                 * @param buttonlink the link to redirect
                                 */
                                var buttonlink = popup_data["country_redirect_url"];
                               /**
                                 * @param popupstatus collecting popupstatus from response if requires popup 
                                 */
                                var popupstatus = popup_data["popup_status"];
                                var welcome_message_from_api = popup_data["welcome_message"];
                                var continue_button_message_api = popup_data["continue_button"];
                                var stay_button_message_api = popup_data["stay_button"];
                                var country_redirect_name = popup_data["country_redirect_name"];
                                var ipaddress = getUrlVars()["ip"];
                                var store_code_url = $("#baseUrl").val();
                                var store_code_url_toblock = $("#baseUrl").val();
                                var store_code_sliced_toblock = store_code_url_toblock.replace('index.php/', '');
                                var newstore_code_sliced_toblock = store_code_sliced_toblock.substring(0, store_code_sliced_toblock.length-1);
                                var currentpageURL = window.location.origin;
                                
                                if(popupstatus === "yes" && buttonlink === newstore_code_sliced_toblock)
                                	{
                                	document.getElementById("mikimoto-popup-geo-main").style.display = 'none';
                                    document.getElementById("mikimoto-popup-geo").style.display = 'none';
                                    return;
                                	}
                                if(newstore_code_sliced_toblock === currentpageURL) {
                                    document.getElementById("mikimoto-popup-geo-main").style.display = 'none';
                                    document.getElementById("mikimoto-popup-geo").style.display = 'none';
                                    return;
                                };
                                $.cookie('country_redirect_url_api',buttonlink);
                                
                                $.mage.cookies.set('country_redirect_url',buttonlink);
                                /**
                                 * @param countryname collecting country name from response 
                                 */
                                var countryname = popup_data["country_name"];
                                var fail_countryname = popup_data["fail_countryname"];
                                var check_country = popup_data["check_country"];
                                
                                /**
                                 * setting country name in cookies 
                                 */
                                $.mage.cookies.set('current_country_name',countryname);
                                /**
                                 * @param popupmessage collecting popup message from response 
                                 */
                                var popupmessage = popup_data["popup_message"];
                                var country_button_name = popup_data["country_button_name"];
                                /**
                                 * @param popup_content this is popup content for frontend 
                                 */
                                document.getElementById("mikimoto-popup-geo-main").style.display = 'block';
                                document.getElementById("mikimoto-popup-geo").style.display = 'block';
                                if(check_country === "false")
                                	{
                                	var popup_content = "<div class='heading'><h1>"+welcome_message_from_api+"</h1></div><div><h2>"+popupmessage+"</h2>  <input type='submit' value='"+stay_button_message_api+" "+country_redirect_name+" Website' onclick='geoStay()'></div>";
                                    document.getElementById("mikimoto-popup-geo").innerHTML =
                                    popup_content;
                                	}
                                if(check_country === "true")
                                	{
                                var popup_content = "<div class='heading'><h1>"+welcome_message_from_api+"</h1></div><div><h2>"+popupmessage+"</h2> <input type='submit' value='"+continue_button_message_api+" "+country_button_name+" Website' onclick='geoContinue()'> <input type='submit' value='"+stay_button_message_api+" "+country_redirect_name+" Website' onclick='geoStay()'></div>";
                                document.getElementById("mikimoto-popup-geo").innerHTML =
                                popup_content;
                                	}
                        }
                      };
                    var apilink = hostname+"/georedirect/index/index/?ip="+ipaddress;
                    if(ipaddress == null) {
                        var apilink = hostname+"/georedirect/index/index/";
                    }
                    xhttp.open("GET",apilink, true);
                    xhttp.send();
                    /**
                     * @const 
                     */   var options = { 
                    		 	type: 'popup', 
                    		 	responsive: true, 
                    		 	clickableOverlay: false, 
                    		 	title: $.mage.__('Welcome to MikiMoto'), 
                    		 	modalClass: 'mikimoto-popup-geo'  };  
                     			return options; 
                						}, 
                _bind: function () { 
                    /**
                     * @const 
                     */     var modalOption = this.options.modalOption; 
                    /**
                     * @const 
                     */  var modalForm = this.options.modalForm; 
                     $(modalForm).modal(modalOption); 
                     $(modalForm).trigger('openModal'); 
                } 
            }
        ); 
        /**
         * @const 
         */  var popup_geo_status = $.mage.cookies.get('popup_geo_status');
        if(popup_geo_status === 'inactive') {
                
               return $.Mikimoto.Popup;
         			}
        }
        else{
           	return;
         	}
  			}
);