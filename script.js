/**
 * @author http://www.cosmosfarm.com/
 */

function kboard_editor_execute(form){
	jQuery.fn.exists = function(){
		return this.length>0;
	};
	/*
	 * 잠시만 기다려주세요.
	 */
	if(jQuery(form).data('submitted')){
		alert(kboard_localize_strings.please_wait);
		return false;
	}
	// if(!GA_ContactForm.validate_RequiredField(jQuery('form#'+form))) {return false;}

	/*
	 * 폼 유효성 검사
	 */
	if(jQuery('input[name=member_display]', form).eq(1).exists() && !jQuery('input[name=member_display]', form).eq(1).val()){
		// 이름 필드가 있을 경우 필수로 입력합니다.
		alert(kboard_localize_strings.please_enter_the_name);
		jQuery('[name=member_display]', form).eq(1).focus();
		return false;
	}
	if(jQuery('input[name=kboard_option_email]', form).eq(1).exists() && !jQuery('input[name=kboard_option_email]', form).eq(1).val()){
		// 이메일 필드가 있을 경우 필수로 입력합니다.
		alert(kboard_localize_strings.please_enter_the_email);
		jQuery('[name=kboard_option_email]', form).eq(1).focus();
		return false;
	}
	if(!jQuery('input[name=title]', form).val()){
		// 제목 필드는 항상 필수로 입력합니다.
		alert(kboard_localize_strings.please_enter_the_title);
		jQuery('input[name=title]', form).focus();
		return false;
	}
	if(jQuery('input[name=captcha]', form).exists() && !jQuery('input[name=captcha]', form).val()){
		// 캡챠 필드가 있을 경우 필수로 입력합니다.
		alert(kboard_localize_strings.please_enter_the_CAPTCHA);
		jQuery('input[name=captcha]', form).focus();
		return false;
	}

	jQuery(form).data('submitted', 'submitted');
	jQuery('[type=submit]', form).text(kboard_localize_strings.please_wait);
	jQuery('[type=submit]', form).val(kboard_localize_strings.please_wait);
	return true;
}


/**
 * @author jake
 */

// 폼
var GA_ContactForm = {

	_errorNm: 'has-error', // error 클래스 이름
	_errorMsg: '.error_mg', // error 안내메시지 요소
	_blur: '.blur_chk', // blur 요소
	_requiredClass: '.required_field', // required 요소
	_parents: '.contact_row', // 부모 요소
	_agree: '.contact_agree', // agreement 요소
	_SubmitBtn: '.js-submit-btn', //
	_flag: 1, // focus flag
	_firstEl: '', // focus input 요소

	/**
	 * Init Function.
	 */
	init: function (){
		jQuery(GA_ContactForm._SubmitBtn).click(function(e) {
			e.preventDefault();
			var form = jQuery(this).attr('data-form');
			if(GA_ContactForm.validate_RequiredField(jQuery('form#'+form))) {
				jQuery('form#'+form).submit();
			}
		});

		// blur요소 + required요소 blur시 validation확인
		jQuery(GA_ContactForm._parents+' '+GA_ContactForm._blur+GA_ContactForm._requiredClass).blur(function(){
			GA_ContactForm.value_checker(this);
		});

		jQuery('.v_agr').click(function(){
			jQuery(this).parents('.agr_con').find('.agr_box').slideDown();
		})
	},

	/**
	 * 필수입력 필드 validation 확인
	 */
	validate_RequiredField: function (el){
		// console.log(el);
		var agree = el.find(GA_ContactForm._agree);
		if ( agree.length > 0 && !agree.is(':checked') ){
			el.find(GA_ContactForm._errorMsg).show().html("개인정보 수집 동의를 확인해주세요.");
			alert("개인정보 수집 동의를 확인해주세요.");
			agree.focus();
			return false;
		}

		GA_ContactForm._flag=1;

		// 필수입력 필드 validation 확인
		el.find('.required_field').each(function(){
			GA_ContactForm.value_checker(jQuery(this));
		});


		if(el.find(GA_ContactForm._parents).hasClass(GA_ContactForm._errorNm)) {
			el.find(GA_ContactForm._errorMsg).show().html("입력하신 정보를 다시 확인해주세요.");
			if (GA_ContactForm._firstEl) {GA_ContactForm._firstEl.focus();GA_ContactForm._flag=1;};
			return false;
		}else{ return true; }
	},

	/**
	 * input(jQuery 객체) value 값 확인
	 */
	value_checker: function (elem){
		if (!(elem instanceof jQuery)) var elem = jQuery(elem); // check jQuery object
		var _p = elem.parents(GA_ContactForm._parents);
		var _v = elem.val();
		if( !_v ) {
			this.result_validation(false, _p);
			if (GA_ContactForm._flag) {GA_ContactForm._firstEl = elem;GA_ContactForm._flag=0;};
		} else {
			var e = elem.attr('data-validate');
			if( e == 'name' ){ this.validate_name(_v,_p) }
			else if ( e == 'phone' ){ this.validate_phone(_v,_p) }
			else if ( e == 'email' ){ this.validate_email(_v,_p) }
			else{ this.result_validation(true, _p); }
		}
	},
	// maxlength 속성 안되는 input type='number'일 경우
	maxLengthCheck: function (object){
		if (object.value.length > object.maxLength){
		object.value = object.value.slice(0, object.maxLength);
		}
	},

	/**
	 * 이름 validation
	 */
	validate_name: function (_v, _p){
		var Regx_sp = /[~!@\#$%<>^&*\()\-=+_\’]/gi;  // 특수문자
		var Regx_kr = /^[가-힝]{2,6}$/; // 한글, 2~6자 가능. ㄱㄴㄷ~, 띄어쓰기 불가능
		var Regx_en = /^[a-zA-Z\s]+$/; // 영문, 띄어쓰기 가능
		var isValid = false;
		if(!Regx_sp.test(_v)) { // 특수문자
			if( !_v.match(/\d/g) ){ // 숫자 (글로벌 flag 'g'를 쓸 경우 .match 사용)
				if (Regx_kr.test(_v) || Regx_en.test(_v) ) {
					isValid = true;
				}
			}
		}
		this.result_validation(isValid, _p);
	},

	/**
	 * 휴대전화 validation
	 */
	validate_phone: function (_v, _p){
		var isValid = false;
		var phone_num = this.chk_tel.checkDigit(_v);
		var len = phone_num.length;
		var idx = phone_num.substring(0,1);
		if (len>=8 && len<14 && idx<=1) {isValid=true;};
		this.result_validation(isValid, _p);
	},

	/**
	 * 이메일 validation
	 */
	validate_email: function (_v, _p){
		var stringRegx = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		var isValid = false;
		if(stringRegx.test(_v)) { // 이메일
			isValid = true;
		}
		this.result_validation(isValid, _p);
	},

	/**
	 * validation 결과 처리
	 */
	result_validation: function (isValid, _p){
		if (isValid) {
			_p.removeClass(GA_ContactForm._errorNm);
		}else{
			_p.addClass(GA_ContactForm._errorNm);
			if (GA_ContactForm._flag) {GA_ContactForm._firstEl = _p.find('.required_field');GA_ContactForm._flag=0;};
		};
	},

	/**
	 * 연락처 관련 객체
	 */
	chk_tel : (function() {
		var chk_tel = {
			exe: function (str, field){
				var str;
				str = this.checkDigit(str);
				len = str.length;
				if(len==8){
					if(str.substring(0,2)==02){
						// this.error_numbr(str, field);
					}else{
						field.value  = this.phone_format(1,str);
					}
				}else if(len==9){
					if(str.substring(0,2)==02){
						field.value = this.phone_format(2,str);
					}else{
						// this.error_numbr(str, field);
					}
				}else if(len==10){
					if(str.substring(0,2)==02){
						field.value = this.phone_format(2,str);
					}else{
						field.value = this.phone_format(3,str);
					}
				}else if(len==11){
					if(str.substring(0,2)==02){
						// this.error_numbr(str, field);
					}else{
						field.value  = this.phone_format(3,str);
					}
				}else{
				// this.error_numbr(str, field);
				}
			},
			checkDigit: function (num){
				var Digit = "1234567890";
				var string = num;
				var len = string.length
				var retVal = "";
				for (i = 0; i < len; i++){
					if (Digit.indexOf(string.substring(i, i+1)) >= 0){
						retVal = retVal + string.substring(i, i+1);
					}
				}
				return retVal;
			},
			phone_format: function (type, num){
				if(type==1){
					return num.replace(/([0-9]{4})([0-9]{4})/,"$1-$2");
				}else if(type==2){
					return num.replace(/([0-9]{2})([0-9]+)([0-9]{4})/,"$1-$2-$3");
				}else{
					return num.replace(/(^01.{1}|[0-9]{3})([0-9]+)([0-9]{4})/,"$1-$2-$3");
				}
			},
			error_numbr: function (str, field){
				alert("정상적인 번호가 아닙니다.");
				field.value = "";
				field.focus();
				return;
			}
		};
		return chk_tel;
	})(),


}; // END GA_ContactForm
setTimeout(GA_ContactForm.init,0); // 페이지 로딩 후 실행 (JS 이벤트루프 참고)

//console.log(GA_ContactForm);
