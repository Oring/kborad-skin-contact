<?php
/**
 * @author jake
 */
$gomi_contact_skin_dir_name = basename(dirname(__FILE__));

if(!function_exists('gomi_contact_kboard_extends_setting')){
	add_filter('kboard_'.$gomi_contact_skin_dir_name.'_extends_setting', 'gomi_contact_kboard_extends_setting', 10, 3);
	function gomi_contact_kboard_extends_setting($html, $meta, $board_id){

		function field_checked($a, $b){ return ( $a == $b ) ? 'checked' : ''; }

		$board = new KBoard($board_id);

		$gomi_contact_f = array('없음', '일반', '필수');
		$gomi_contact_f_username = $board->meta->gomi_contact_f_username ? $board->meta->gomi_contact_f_username : 2;
		$gomi_contact_f_email = $board->meta->gomi_contact_f_email ? $board->meta->gomi_contact_f_email : 0;
		$gomi_contact_f_tel = $board->meta->gomi_contact_f_tel ? $board->meta->gomi_contact_f_tel : 0;
		$gomi_contact_f_subject = $board->meta->gomi_contact_f_subject ? $board->meta->gomi_contact_f_subject : 0;
		$gomi_contact_f_content = $board->meta->gomi_contact_f_content ? $board->meta->gomi_contact_f_content : 0;

		echo '<table class="form-table"><tbody>';
		$gomi_contact_privacy = $board->meta->gomi_contact_privacy ? $board->meta->gomi_contact_privacy : '<p>1. 수집항목: 이메일, 비밀번호, 문의내용 및 기타 고객이 직접 입력한 내용</p>
<p>2. 수집목적: 고객문의 ,접수, 처리결과 안내</p>
<p>3. 보유 및 이용기간: 상담 문의 접수 시점 및 상담 완료 후 6개월이며, 세부사항은 ‘개인정보처리방침’을 확인</p>
<p>(단, 관련 법령에 의거 보존할 필요성이 있는 경우에는 관련 법령에 따라 보존 가능)</p>';

		echo '<tr valign="top">';
		echo '<th scope="row">개인정보처리방침</th><td>';
		wp_editor($gomi_contact_privacy, 'gomi_contact_privacy', array('editor_height'=>200));
		echo '<p class="description">비회원으로 글 작성 시 개인정보처리방침에 대한 내용을 입력해주세요.</p>';
		echo '</td></tr>';

		echo '<tr valign="top">';
		echo '<th scope="row">사용필드</th><td>';
		echo '<p class="description">사용하실 필드를 </p>';
		echo '<p class="description">워드프레스 내장 에디터에서는 표시되지 않습니다.</p>';

		/* 사용필드 */
		echo '<table><tbody>';
		echo '<tr>';
		echo '<td>이름</td>';
		foreach ($gomi_contact_f as $k => $v) {
			echo '<td><label><input type="radio" name="gomi_contact_f_username" value="'.$k.'" '.field_checked($gomi_contact_f_username,$k).'>'.$v.'</label></td>';
		}
		echo '</tr>';

		echo '<tr>';
		echo '<td>이메일</td>';
		foreach ($gomi_contact_f as $k => $v) {
			echo '<td><label><input type="radio" name="gomi_contact_f_email" value="'.$k.'" '.field_checked($gomi_contact_f_email,$k).'>'.$v.'</label></td>';
		}
		echo '</tr>';

		echo '<tr>';
		echo '<td>연락처</td>';
		foreach ($gomi_contact_f as $k => $v) {
			echo '<td><label><input type="radio" name="gomi_contact_f_tel" value="'.$k.'" '.field_checked($gomi_contact_f_tel,$k).'>'.$v.'</label></td>';
		}
		echo '</tr>';

		echo '<tr>';
		echo '<td>제목</td>';
		echo '<td><label><input type="radio" name="gomi_contact_f_subject" value="0" ';
		echo ( $gomi_contact_f_subject == 0 ) ? 'checked' : '';
		echo '>없음</label></td>';
		echo '<td><label><input type="radio" name="gomi_contact_f_subject" value="2" ';
		echo ( $gomi_contact_f_subject == 2 ) ? 'checked' : '';
		echo '>필수</label></td>';
		echo '</tr>';

		echo '<tr>';
		echo '<td>내용</td>';
		foreach ($gomi_contact_f as $k => $v) {
			echo '<td><label><input type="radio" name="gomi_contact_f_content" value="'.$k.'" '.field_checked($gomi_contact_f_content,$k).'>'.$v.'</label></td>';
		}
		echo '</tr>';
		echo '</tbody></table>';
		/* //끝 사용필드 */

		echo '</td></tr>';

		echo '</tbody></table>';

		return $html;
	}
}



if(!function_exists('gomi_contact_kboard_extends_setting_update')){
	add_filter('kboard_'.$gomi_contact_skin_dir_name.'_extends_setting_update', 'gomi_contact_kboard_extends_setting_update', 10, 2);
	function gomi_contact_kboard_extends_setting_update($board_meta, $board_id){
		$board_meta->gomi_contact_privacy = isset($_POST['gomi_contact_privacy'])?$_POST['gomi_contact_privacy']:'';
		$board_meta->gomi_contact_f_username = isset($_POST['gomi_contact_f_username'])?$_POST['gomi_contact_f_username']:'';
		$board_meta->gomi_contact_f_email = isset($_POST['gomi_contact_f_email'])?$_POST['gomi_contact_f_email']:'';
		$board_meta->gomi_contact_f_tel = isset($_POST['gomi_contact_f_tel'])?$_POST['gomi_contact_f_tel']:'';
		$board_meta->gomi_contact_f_subject = isset($_POST['gomi_contact_f_subject'])?$_POST['gomi_contact_f_subject']:'';
		$board_meta->gomi_contact_f_content = isset($_POST['gomi_contact_f_content'])?$_POST['gomi_contact_f_content']:'';
	}
}
