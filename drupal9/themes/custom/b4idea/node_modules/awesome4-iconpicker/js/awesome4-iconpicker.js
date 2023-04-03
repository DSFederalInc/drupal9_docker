;(function($){
    // ==============================
    // Icon Objects 
    // ==============================
    var AwesomeIcon = {
        "iconType":"fontawesome",
        "iconClass": "fa",
        "iconClassFix": "fa-",
        "icons":['address-book','address-book-o','address-card','address-card-o','adjust','american-sign-language-interpreting','anchor','archive','area-chart','arrows','arrows-h','arrows-v','asl-interpreting','assistive-listening-systems','asterisk','at','audio-description','automobile','balance-scale','ban','bank','bar-chart','bar-chart-o','barcode','bars','bath','bathtub','battery','battery-0','battery-1','battery-2','battery-3','battery-4','battery-empty','battery-full','battery-half','battery-quarter','battery-three-quarters','bed','beer','bell','bell-o','bell-slash','bell-slash-o','bicycle','binoculars','birthday-cake','blind','bluetooth','bluetooth-b','bolt','bomb','book','bookmark','bookmark-o','braille','briefcase','bug','building','building-o','bullhorn','bullseye','bus','cab','calculator','calendar','calendar-check-o','calendar-minus-o','calendar-o','calendar-plus-o','calendar-times-o','camera','camera-retro','car','caret-square-o-down','caret-square-o-left','caret-square-o-right','caret-square-o-up','cart-arrow-down','cart-plus','cc','certificate','check','check-circle','check-circle-o','check-square','check-square-o','child','circle','circle-o','circle-o-notch','circle-thin','clock-o','clone','close','cloud','cloud-download','cloud-upload','code','code-fork','coffee','cog','cogs','comment','comment-o','commenting','commenting-o','comments','comments-o','compass','copyright','creative-commons','credit-card','credit-card-alt','crop','crosshairs','cube','cubes','cutlery','dashboard','database','deaf','deafness','desktop','diamond','dot-circle-o','download','drivers-license','drivers-license-o','edit','ellipsis-h','ellipsis-v','envelope','envelope-o','envelope-open','envelope-open-o','envelope-square','eraser','exchange','exclamation','exclamation-circle','exclamation-triangle','external-link','external-link-square','eye','eye-slash','eyedropper','fax','feed','female','fighter-jet','file-archive-o','file-audio-o','file-code-o','file-excel-o','file-image-o','file-movie-o','file-pdf-o','file-photo-o','file-picture-o','file-powerpoint-o','file-sound-o','file-video-o','file-word-o','file-zip-o','film','filter','fire','fire-extinguisher','flag','flag-checkered','flag-o','flash','flask','folder','folder-o','folder-open','folder-open-o','frown-o','futbol-o','gamepad','gavel','gear','gears','gift','glass','globe','graduation-cap','group','hand-grab-o','hand-lizard-o','hand-paper-o','hand-peace-o','hand-pointer-o','hand-rock-o','hand-scissors-o','hand-spock-o','hand-stop-o','handshake-o','hard-of-hearing','hashtag','hdd-o','headphones','heart','heart-o','heartbeat','history','home','hotel','hourglass','hourglass-1','hourglass-2','hourglass-3','hourglass-end','hourglass-half','hourglass-o','hourglass-start','i-cursor','id-badge','id-card','id-card-o','image','inbox','industry','info','info-circle','institution','key','keyboard-o','language','laptop','leaf','legal','lemon-o','level-down','level-up','life-bouy','life-buoy','life-ring','life-saver','lightbulb-o','line-chart','location-arrow','lock','low-vision','magic','magnet','mail-forward','mail-reply','mail-reply-all','male','map','map-marker','map-o','map-pin','map-signs','meh-o','microchip','microphone','microphone-slash','minus','minus-circle','minus-square','minus-square-o','mobile','mobile-phone','money','moon-o','mortar-board','motorcycle','mouse-pointer','music','navicon','newspaper-o','object-group','object-ungroup','paint-brush','paper-plane','paper-plane-o','paw','pencil','pencil-square','pencil-square-o','percent','phone','phone-square','photo','picture-o','pie-chart','plane','plug','plus','plus-circle','plus-square','plus-square-o','podcast','power-off','print','puzzle-piece','qrcode','question','question-circle','question-circle-o','quote-left','quote-right','random','recycle','refresh','registered','remove','reorder','reply','reply-all','retweet','road','rocket','rss','rss-square','s15','search','search-minus','search-plus','send','send-o','server','share','share-alt','share-alt-square','share-square','share-square-o','shield','ship','shopping-bag','shopping-basket','shopping-cart','shower','sign-in','sign-language','sign-out','signal','signing','sitemap','sliders','smile-o','snowflake-o','soccer-ball-o','sort','sort-alpha-asc','sort-alpha-desc','sort-amount-asc','sort-amount-desc','sort-asc','sort-desc','sort-down','sort-numeric-asc','sort-numeric-desc','sort-up','space-shuttle','spinner','spoon','square','square-o','star','star-half','star-half-empty','star-half-full','star-half-o','star-o','sticky-note','sticky-note-o','street-view','suitcase','sun-o','support','tablet','tachometer','tag','tags','tasks','taxi','television','terminal','thermometer','thermometer-0','thermometer-1','thermometer-2','thermometer-3','thermometer-4','thermometer-empty','thermometer-full','thermometer-half','thermometer-quarter','thermometer-three-quarters','thumb-tack','thumbs-down','thumbs-o-down','thumbs-o-up','thumbs-up','ticket','times','times-circle','times-circle-o','times-rectangle','times-rectangle-o','tint','toggle-down','toggle-left','toggle-off','toggle-on','toggle-right','toggle-up','trademark','trash','trash-o','tree','trophy','truck','tty','tv','umbrella','universal-access','university','unlock','unlock-alt','unsorted','upload','user','user-circle','user-circle-o','user-o','user-plus','user-secret','user-times','users','vcard','vcard-o','video-camera','volume-control-phone','volume-down','volume-off','volume-up','warning','wheelchair','wheelchair-alt','wifi','window-close','window-close-o','window-maximize','window-minimize','window-restore','wrench']
    };
    // ==============================
    // HTML Tag
    // ==============================
    var HTMLTag = {
        'iconPicker': function(){
            return (
                '<div class="iconpicker">'+
                    '<div class="iconpicker-selected-icon">' +
                    '</div>' +
                    '<div class="iconpicker-selecter">' +
                        '<i class="fa fa-angle-down"></i>' +
                    '</div>' +
                    '<div class="iconpicker-content">' +
                        '<div class="iconpicker-search">'+
                            '<div class="iconpicker-search-click">'+
                                '<i class="fa fa-search"></i>'+
                            '</div>'+
                            '<div class="iconpicker-search-click-display">'+
                                '<input type="text" class="iconpicker-search-input">'+
                            '</div>'+
                        '</div>'+
                        '<div class="iconpicker-list">'+
                        '</div>'+
                    '</div>'+
                '</div>'
            );
        },
        'iconPickerIcon': function(value){
            return (
                '<div class="iconpicker-list-icon" data-iconName="'+value+'">'+
                    '<div class="iconpicker-list-icon-i">'+
                        '<i class="fa fa-' + value +'"></i>'+
                    '</div>'+
                    '<div class="iconpicker-list-icon-word">'+
                         value+
                    '</div>'+
                '</div>'
            );
        },
        'icon': function(value){
            return '<i class="fa fa-'+value+'"></i>';
        }
    };
    // ==============================
    // Picker Class 
    // ==============================
    var Iconpicker = function (element,config){
        this.element = element;
        this.outputType = config.outputType;
    };
    // ==============================
    // Picker class Fucntion
    // ==============================
    Iconpicker.prototype.search = function(searchValue){
        return AwesomeIcon.icons.filter(function(value){
            if( value.indexOf(searchValue) == -1){
                return false;
            }
            return true;
        });
    };

    Iconpicker.prototype.load = function() {
        var element = this.element;
        //0.
        if(element.prev(".iconpicker").length > 0){
            return;
        }

        //1.add HTMLtag
        element.before( HTMLTag.iconPicker() );
        
        //2.add icons button
        AwesomeIcon.icons.map(function(value,index){
            element.prev(".iconpicker").find(".iconpicker-list").append( HTMLTag.iconPickerIcon( value ) );
        });

        this.self = element.prev('.iconpicker');
        element.addClass('is-icon-pciker');

        //3.Selected
        if( element.data('iconname') === null || element.data('iconname') === undefined){
            return this;
        }
        //3.1 remove iconClassFix
        var selectVal = element.data('iconname');
        //3.2 add icon and input word
        element.prev(".iconpicker").find('.iconpicker-selected-icon').append( HTMLTag.icon( selectVal ) );
        element.val(this.getIconValue( selectVal ));

        return this;
    }

    Iconpicker.prototype.getIconValue = function(value) {
        if(this.outputType === 'icon-name'){
            return value;
        }
        if( this.outputType === 'html' ){
            return HTMLTag.icon(value);
        }

    };
    // ==============================
    // Main iconpicker
    // ==============================
    $.fn.iconpicker = function (config) {
        this.each(function (){
            //----------------------------------------
            /*Iconpicker Class                      */
            //----------------------------------------
            if( $(this).hasClass('is-iconpciker') ){
                return;
            }
            var $iconpciker = new Iconpicker($(this), ((typeof config === 'object') ? config : { "outputType": "icon-name" }) ).load();
            var picker = $iconpciker.self;
            
            //----------------------------------------
            /*Iconpicker search keyponel Icons      */
            //----------------------------------------
            $iconpciker.self.on('keyup','.iconpicker-search-input',function(e){
                e.stopPropagation();
                var inputVal = $(this).val();

                picker.find('.iconpicker-list').empty();

                $iconpciker.search( inputVal ).map(function(value){
                    picker.find('.iconpicker-list')
                         .append( HTMLTag.iconPickerIcon( value) );
                });
            });
            //----------------------------------------
            /*Iconpicker search keyponel Icons      */
            //----------------------------------------
            $iconpciker.self.on('click','.iconpicker-search-input',function(e){
                e.stopPropagation();
            });
            //----------------------------------------
            /*Iconpicker selecter to open icon list */
            //----------------------------------------
            $iconpciker.self.on('click', '.iconpicker-selecter', function (e) {
                e.stopPropagation();

                picker.find('.iconpicker-content').toggleClass('active');
            });
            //---------------------------------------------
            /*Iconpicker search icon to open search input*/
            //---------------------------------------------
            $iconpciker.self.on('click', '.iconpicker-search-click', function (e) {
                e.stopPropagation();

                picker.find('.iconpicker-content').toggleClass('searching');
            });
            //----------------------------------------
            /*Iconpicker list icon to add input val */
            //----------------------------------------
            $iconpciker.self.on('click','.iconpicker-list-icon',function(e){
                e.stopPropagation();

                picker.find('.iconpicker-selected-icon').empty();
                picker.find('.iconpicker-selected-icon').append( HTMLTag.icon( $(this).data('iconname') ) );

                $output = $iconpciker.getIconValue( $(this).data('iconname') );
                $iconpciker.element.val( $output );
            });
        });
        //-------------------------------------------
        /*Cancel Iconpicker select list status(css)*/
        //-------------------------------------------
        $(window).on('click',function(){
            $('.iconpicker-content').removeClass('active');
            $('.iconpicker-content').removeClass('searching');
        });
    };
})(jQuery);