<div id="" class="contact_group">
	<form id="gomi_contact_form" class="kboard-form" method="post" action="<?php echo $url->getContentEditorExecute()?>" enctype="multipart/form-data" >
		<?php wp_nonce_field('kboard-editor-execute', 'kboard-editor-execute-nonce')?>
		<input type="hidden" name="action" value="kboard_editor_execute">
		<input type="hidden" name="mod" value="editor">
		<input type="hidden" name="uid" value="<?php echo $content->uid?>">
		<input type="hidden" name="board_id" value="<?php echo $content->board_id?>">
		<input type="hidden" name="parent_uid" value="<?php echo $content->parent_uid?>">
		<input type="hidden" name="member_uid" value="<?php echo $content->member_uid?>">
		<input type="hidden" name="member_display" value="<?php echo $content->member_display?>">
		<input type="hidden" name="date" value="<?php echo $content->date?>">
		<input type="hidden" name="user_id" value="<?php echo get_current_user_id()?>">
		<input type="hidden" name="secret" value="true">
		<input type="hidden" name="wordpress_search" value="3">
		<input type="hidden" name="password" value="<?php echo uniqid()?>">
		
		<?php if($board->use_category):?>
			<?php if($board->initCategory1()):?>
			<div class="kboard-attr-row contact_row">
				<label class="clb attr-name" for="kboard-select-category1"><?php echo __('Category', 'kboard')?>1</label>
				<div class="cr_box attr-value">
					<select id="kboard-select-category1" name="category1">
						<option value=""><?php echo __('Category', 'kboard')?> <?php echo __('Select', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($content->category1 == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				</div>
			</div>
			<?php endif?>
			
			<?php if($board->initCategory2()):?>
			<div class="kboard-attr-row contact_row">
				<label class="clb attr-name" for="kboard-select-category2"><?php echo __('Category', 'kboard')?>2</label>
				<div class="cr_box attr-value">
					<select id="kboard-select-category2" name="category2">
						<option value=""><?php echo __('Category', 'kboard')?> <?php echo __('Select', 'kboard')?></option>
						<?php while($board->hasNextCategory()):?>
						<option value="<?php echo $board->currentCategory()?>"<?php if($content->category2 == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
						<?php endwhile?>
					</select>
				</div>
			</div>
			<?php endif?>
		<?php endif?>
		<?php if($board->meta->gomi_contact_f_username != 0):?>
		<div class="kboard-attr-row contact_row">
			<label class="clb attr-name" for="kboard-input-member-display">이름 <?php echo ( $board->meta->gomi_contact_f_username == 2 ) ? '<span class="attr-required-text">*</span>' : ''; ?></label>
			<div class="cr_box attr-value"><input class="<?php echo ( $board->meta->gomi_contact_f_username == 2 ) ? 'required_field' : ''; ?> inp blur_chk" type="text" id="kboard-input-member-display" name="member_display" value="" placeholder="이름" data-validate="name"></div>
		</div>
		<?php endif?>
		
		<?php if($board->meta->gomi_contact_f_email != 0):?>
		<div class="kboard-attr-row contact_row">
			<label class="clb attr-name" for="kboard-input-email-display">이메일 <?php echo ( $board->meta->gomi_contact_f_email == 2 ) ? '<span class="attr-required-text">*</span>' : ''; ?></label>
			<div class="cr_box attr-value"><input class="<?php echo ( $board->meta->gomi_contact_f_email == 2 ) ? 'required_field' : ''; ?> inp blur_chk" type="email" id="kboard-input-email-display" name="kboard_option_email" value="" placeholder="이메일" data-validate="email"></div>
		</div>
		<?php endif?>
		
		<?php if($board->meta->gomi_contact_f_tel != 0):?>
		<div class="kboard-attr-row contact_row">
			<label class="clb attr-name" for="kboard-input-tel-display">연락처 <?php echo ( $board->meta->gomi_contact_f_tel == 2 ) ? '<span class="attr-required-text">*</span>' : ''; ?></label>
			<div class="cr_box attr-value"><input class="<?php echo ( $board->meta->gomi_contact_f_tel == 2 ) ? 'required_field' : ''; ?> inp blur_chk" type="tel" id="kboard-input-tel-display" name="kboard_option_tel" value="" placeholder="연락처" data-validate="phone"></div>
		</div>
		<?php endif?>
		
		<?php if($board->meta->gomi_contact_f_subject != 0):?>
		<div class="kboard-attr-row contact_row kboard-attr-title">
			<label class="clb attr-name" for="kboard-input-title">제목 <?php echo ( $board->meta->gomi_contact_f_subject == 2 ) ? '<span class="attr-required-text">*</span>' : ''; ?></label>
			<div class="cr_box attr-value"><input class="<?php echo ( $board->meta->gomi_contact_f_subject == 2 ) ? 'required_field' : ''; ?> inp blur_chk" type="text" id="kboard-input-title" name="title" placeholder="제목"></div>
		</div>
		<?php else:?>
			<input type="hidden" name="title" value="제목없음">
		<?php endif?>
		
		<?php if($board->meta->max_attached_count > 0):?>
			<!-- 첨부파일 시작 -->
			<?php for($attached_index=1; $attached_index<=$board->meta->max_attached_count; $attached_index++):?>
			<div class="kboard-attr-row contact_row">
				<label class="clb attr-name" for="kboard-input-file<?php echo $attached_index?>">첨부파일<?php echo $attached_index?></label>
				<div class="cr_box attr-value">
					<?php if(isset($content->attach->{"file{$attached_index}"})):?><?php echo $content->attach->{"file{$attached_index}"}[1]?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid, "file{$attached_index}");?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');">파일삭제</a><?php endif?>
					<input type="file" id="kboard-input-file<?php echo $attached_index?>" name="kboard_attach_file<?php echo $attached_index?>">
				</div>
			</div>
			<?php endfor?>
			<!-- 첨부파일 끝 -->
		<?php endif?>
		
		<?php if($board->meta->gomi_contact_f_content != 0):?>
		<div class="kboard-attr-row contact_row">
			<label class="clb attr-name" for="kboard_content">내용 <?php echo ( $board->meta->gomi_contact_f_content == 2 ) ? '<span class="attr-required-text">*</span>' : ''; ?></label>
			<div class="cr_box attr-value">
				<?php if($board->use_editor):?>
					<?php wp_editor($content->content, 'kboard_content', array('media_buttons'=>$board->isAdmin(), 'editor_height'=>400))?>
				<?php else:?>
					<textarea class="<?php echo ( $board->meta->gomi_contact_f_content == 2 ) ? 'required_field' : ''; ?> inp blur_chk" name="kboard_content" id="kboard_content" placeholder="<?php echo $content->content?>"></textarea>
				<?php endif?>
			</div>
		</div>
		<?php endif?>
		
		<?php if($board->useCAPTCHA() && !$content->uid):?>
			<?php if(kboard_use_recaptcha()):?>
				<div class="kboard-attr-row contact_row">
					<label class="attr-name"></label>
					<div class="attr-value"><div class="g-recaptcha" data-sitekey="<?php echo kboard_recaptcha_site_key()?>"></div></div>
				</div>
			<?php else:?>
				<div class="kboard-attr-row contact_row">
					<label class="attr-name" for="kboard-input-captcha"><img src="<?php echo kboard_captcha()?>" alt=""></label>
					<div class="attr-value"><input type="text" id="kboard-input-captcha" name="captcha" value="" placeholder="<?php echo __('CAPTCHA', 'kboard')?>"></div>
				</div>
			<?php endif?>
		<?php endif?>
		<div class="agr_con">
			<div class="agr_box">
				<div class="agr_doc"><?php echo nl2br($board->meta->gomi_contact_privacy); ?></div>
			</div>
			<div class="agr_lb"><label><input type="checkbox" class="contact_agree">개인정보취급방침 동의</label> <span class="v_agr">(보기)</span></div>
		</div>
		<div class="error_mg">입력정보를 확인해주세요.</div>
		
		<div class="kboard-control">
			<div class="">
				<?php if($content->uid):?>
				<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>" class="kboard-contact-form-button-small"><?php echo __('Back', 'kboard')?></a>
				<a href="<?php echo $url->set('mod', 'list')->toString()?>" class="kboard-contact-form-button-small"><?php echo __('List', 'kboard')?></a>
				<?php elseif($board->isWriter()):?>
				<?php /* ?> <button type="submit" class="kboard-contact-form-button-large"><?php echo __('Send', 'kboard')?></button> <?php */ ?>
				<button type="submit" class="submit_button js-submit-btn" data-form="gomi_contact_form">지금 시작하세요</button>
				<?php endif?>
			</div>
			<div class="right">
				<?php if($content->uid && $board->isWriter()):?>
				<button type="submit" class="kboard-contact-form-button-small"><?php echo __('Save', 'kboard')?></button>
				<?php endif?>
			</div>
		</div>
	</form>
</div>

<?php if(kboard_execute_uid()):?>
<script>alert('<?php echo __('Your message was sent successfully. Thanks.', 'kboard')?>');</script>
<?php endif?>

<script type="text/javascript" src="<?php echo $skin_path?>/script.js?<?php echo KBOARD_VERSION?>"></script>