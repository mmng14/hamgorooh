<div>
	<?php if (!isset($OP_CODE_LIST)) : ?>
		<input type="hidden" id="insert_code" value="<?= $_SESSION["INSERT_CODE"]; ?>" />
		<input type="hidden" id="update_code" value="<?= $_SESSION["UPDATE_CODE"]; ?>" />
		<input type="hidden" id="delete_code" value="<?= $_SESSION["DELETE_CODE"]; ?>" />
		<input type="hidden" id="multi_delete_code" value="<?= $_SESSION["MULTI_DELETE_CODE"]; ?>" />
		<input type="hidden" id="activate_code" value="<?= $_SESSION["ACTIVATE_CODE"]; ?>" />
		<input type="hidden" id="deactivate_code" value="<?= $_SESSION["DEACTIVATE_CODE"]; ?>" />
		<input type="hidden" id="activate_topmenu_code" value="<?= $_SESSION["ACTIVATE_TOPMENU_CODE"]; ?>" />
		<input type="hidden" id="deactivate_topmenu_code" value="<?= $_SESSION["DEACTIVATE_TOPMENU_CODE"]; ?>" />
		
		<input type="hidden" id="activate_hasresource_code" value="<?= $_SESSION["ACTIVATE_HASRESOURCE_CODE"]; ?>" />
		<input type="hidden" id="deactivate_hasresource_code" value="<?= $_SESSION["DEACTIVATE_HASRESOURCE_CODE"]; ?>" />
		
		<input type="hidden" id="activate_payment_code" value="<?= $_SESSION["ACTIVATE_PAYMENT_CODE"]; ?>" />
		<input type="hidden" id="deactivate_payment_code" value="<?= $_SESSION["DEACTIVATE_PAYMENT_CODE"]; ?>" />
		<input type="hidden" id="customize_code" value="<?= $_SESSION["CUSTOMIZE_CODE"]; ?>" />
		<input type="hidden" id="uncustomize_code" value="<?= $_SESSION["UNCUSTOMIZE_CODE"]; ?>" />
		<input type="hidden" id="get_date_and_price_code" value="<?= $_SESSION["GET_DATE_AND_PRICE_CODE"]; ?>" />
		<input type="hidden" id="get_price_code" value="<?= $_SESSION["GET_PRICE_CODE"]; ?>" />
		<input type="hidden" id="send_to_subjects_code" value="<?= $_SESSION["SEND_TO_SUBJECTS_CODE"]; ?>" />
		<input type="hidden" id="update_to_subjects_code" value="<?= $_SESSION["UPDATE_TO_SUBJECTS_CODE"]; ?>" />
		<input type="hidden" id="delete_to_subjects_code" value="<?= $_SESSION["DELETE_TO_SUBJECTS_CODE"]; ?>" />
		<input type="hidden" id="send_to_all_subjects_code" value="<?= $_SESSION["SEND_TO_ALL_SUBJECTS_CODE"]; ?>" />
		<input type="hidden" id="edit_code" value="<?= $_SESSION["EDIT_CODE"]; ?>" />
		<input type="hidden" id="set_upload_folder_code" value="<?= $_SESSION["SET_UPLOAD_FOLDER_CODE"]; ?>" />
		<input type="hidden" id="send_to_telegram_code" value="<?= $_SESSION["SEND_TO_TELEGRAM_CODE"]; ?>" />
		<input type="hidden" id="send_to_reportage_code" value="<?= $_SESSION["SEND_TO_REPORTAGE_CODE"]; ?>" />
		<input type="hidden" id="set_group_access_code" value="<?= $_SESSION["SET_GROUP_ACCESS_CODE"]; ?>" />
		<input type="hidden" id="set_category_code" value="<?= $_SESSION["SET_CATEGORY_CODE"]; ?>" />
		<input type="hidden" id="set_user_type_code" value="<?= $_SESSION["SET_USER_TYPE_CODE"]; ?>" />
		<input type="hidden" id="password_change_code" value="<?= $_SESSION["PASSWORD_CHANGE_CODE"]; ?>" />
		<input type="hidden" id="get_category_list_code" value="<?= $_SESSION["GET_CATEGORY_LIST_CODE"]; ?>" />
		<input type="hidden" id="get_subcategory_list_code" value="<?= $_SESSION["GET_SUBCATEGORY_LIST_CODE"]; ?>" />
		<input type="hidden" id="get_city_list_code" value="<?= $_SESSION["GET_CITY_LIST_CODE"]; ?>" />
		<input type="hidden" id="listing_code" value="<?= $_SESSION["LISTING_CODE"]; ?>" />
		<input type="hidden" id="accept_request_code" value="<?= $_SESSION["ACCEPT_REQUEST_CODE"]; ?>" />
		<input type="hidden" id="reject_request_code" value="<?= $_SESSION["REJECT_REQUEST_CODE"]; ?>" />
		<input type="hidden" id="post_image_upload_code" value="<?= $_SESSION["POST_IMAGE_UPLOAD_CODE"]; ?>" />
		<input type="hidden" id="post_image_list_code" value="<?= $_SESSION["POST_IMAGE_LIST_CODE"]; ?>" />
		<input type="hidden" id="post_resource_list_code" value="<?= $_SESSION["POST_RESOURCE_LIST_CODE"]; ?>" />
		<input type="hidden" id="notifications_list_op_code" value="<?= $_SESSION["NOTOFICATIONS_LIST_OP_CODE"]; ?>" />
		<input type="hidden" id="notifications_count_op_code" value="<?= $_SESSION["NOTOFICATIONS_COUNT_OP_CODE"]; ?>" />

	<?php else : ?>

		<?php if (strpos($OP_CODE_LIST, "INSERT_CODE") !== false) : ?>
			<input type="hidden" id="insert_code" value="<?= $_SESSION["INSERT_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "UPDATE_CODE") !== false) : ?>
			<input type="hidden" id="update_code" value="<?= $_SESSION["UPDATE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "DELETE_CODE") !== false) : ?>
			<input type="hidden" id="delete_code" value="<?= $_SESSION["DELETE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "MULTI_DELETE_CODE") !== false) : ?>
			<input type="hidden" id="multi_delete_code" value="<?= $_SESSION["MULTI_DELETE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "ACTIVATE_CODE") !== false) : ?>
			<input type="hidden" id="activate_code" value="<?= $_SESSION["ACTIVATE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "DEACTIVATE_CODE") !== false) : ?>
			<input type="hidden" id="deactivate_code" value="<?= $_SESSION["DEACTIVATE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "ACTIVATE_TOPMENU_CODE") !== false) : ?>
			<input type="hidden" id="activate_topmenu_code" value="<?= $_SESSION["ACTIVATE_TOPMENU_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "DEACTIVATE_TOPMENU_CODE") !== false) : ?>
			<input type="hidden" id="deactivate_topmenu_code" value="<?= $_SESSION["DEACTIVATE_TOPMENU_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "ACTIVATE_HASRESOURCE_CODE") !== false) : ?>
			<input type="hidden" id="activate_hasresource_code" value="<?= $_SESSION["ACTIVATE_HASRESOURCE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "DEACTIVATE_HASRESOURCE_CODE") !== false) : ?>
			<input type="hidden" id="deactivate_hasresource_code" value="<?= $_SESSION["DEACTIVATE_HASRESOURCE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "ACTIVATE_PAYMENT_CODE") !== false) : ?>
			<input type="hidden" id="activate_payment_code" value="<?= $_SESSION["ACTIVATE_PAYMENT_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "DEACTIVATE_PAYMENT_CODE") !== false) : ?>
			<input type="hidden" id="deactivate_payment_code" value="<?= $_SESSION["DEACTIVATE_PAYMENT_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "CUSTOMIZE_CODE") !== false) : ?>
			<input type="hidden" id="customize_code" value="<?= $_SESSION["CUSTOMIZE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "UNCUSTOMIZE_CODE") !== false) : ?>
			<input type="hidden" id="uncustomize_code" value="<?= $_SESSION["UNCUSTOMIZE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "UNCUSTOMIZE_CODE") !== false) : ?>
			<input type="hidden" id="get_date_and_price_code" value="<?= $_SESSION["GET_DATE_AND_PRICE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "GET_PRICE_CODE") !== false) : ?>
			<input type="hidden" id="get_price_code" value="<?= $_SESSION["GET_PRICE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SEND_TO_SUBJECTS_CODE") !== false) : ?>
			<input type="hidden" id="send_to_subjects_code" value="<?= $_SESSION["SEND_TO_SUBJECTS_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "UPDATE_TO_SUBJECTS_CODE") !== false) : ?>
			<input type="hidden" id="update_to_subjects_code" value="<?= $_SESSION["UPDATE_TO_SUBJECTS_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "DELETE_TO_SUBJECTS_CODE") !== false) : ?>
			<input type="hidden" id="delete_to_subjects_code" value="<?= $_SESSION["DELETE_TO_SUBJECTS_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SEND_TO_ALL_SUBJECTS_CODE") !== false) : ?>
			<input type="hidden" id="send_to_all_subjects_code" value="<?= $_SESSION["SEND_TO_ALL_SUBJECTS_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "EDIT_CODE") !== false) : ?>
			<input type="hidden" id="edit_code" value="<?= $_SESSION["EDIT_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SET_UPLOAD_FOLDER_CODE") !== false) : ?>
			<input type="hidden" id="set_upload_folder_code" value="<?= $_SESSION["SET_UPLOAD_FOLDER_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SEND_TO_TELEGRAM_CODE") !== false) : ?>
			<input type="hidden" id="send_to_telegram_code" value="<?= $_SESSION["SEND_TO_TELEGRAM_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SEND_TO_REPORTAGE_CODE") !== false) : ?>
			<input type="hidden" id="send_to_reportage_code" value="<?= $_SESSION["SEND_TO_REPORTAGE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SET_GROUP_ACCESS_CODE") !== false) : ?>
			<input type="hidden" id="set_group_access_code" value="<?= $_SESSION["SET_GROUP_ACCESS_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SET_CATEGORY_CODE") !== false) : ?>
			<input type="hidden" id="set_category_code" value="<?= $_SESSION["SET_CATEGORY_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "SET_USER_TYPE_CODE") !== false) : ?>
			<input type="hidden" id="set_user_type_code" value="<?= $_SESSION["SET_USER_TYPE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "PASSWORD_CHANGE_CODE") !== false) : ?>
			<input type="hidden" id="password_change_code" value="<?= $_SESSION["PASSWORD_CHANGE_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "GET_CATEGORY_LIST_CODE") !== false) : ?>
			<input type="hidden" id="get_category_list_code" value="<?= $_SESSION["GET_CATEGORY_LIST_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "GET_SUBCATEGORY_LIST_CODE") !== false) : ?>
			<input type="hidden" id="get_subcategory_list_code" value="<?= $_SESSION["GET_SUBCATEGORY_LIST_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "GET_CITY_LIST_CODE") !== false) : ?>
			<input type="hidden" id="get_city_list_code" value="<?= $_SESSION["GET_CITY_LIST_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "LISTING_CODE") !== false) : ?>
			<input type="hidden" id="listing_code" value="<?= $_SESSION["LISTING_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "ACCEPT_REQUEST_CODE") !== false) : ?>
			<input type="hidden" id="accept_request_code" value="<?= $_SESSION["ACCEPT_REQUEST_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "REJECT_REQUEST_CODE") !== false) : ?>
			<input type="hidden" id="reject_request_code" value="<?= $_SESSION["REJECT_REQUEST_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "POST_IMAGE_UPLOAD_CODE") !== false) : ?>
			<input type="hidden" id="post_image_upload_code" value="<?= $_SESSION["POST_IMAGE_UPLOAD_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "POST_IMAGE_LIST_CODE") !== false) : ?>
			<input type="hidden" id="post_image_list_code" value="<?= $_SESSION["POST_IMAGE_LIST_CODE"]; ?>" />
		<?php endif ?>
		
		<?php if (strpos($OP_CODE_LIST, "POST_RESOURCE_LIST_CODE") !== false) : ?>
			<input type="hidden" id="post_resource_list_code" value="<?= $_SESSION["POST_RESOURCE_LIST_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "NOTOFICATIONS_LIST_OP_CODE") !== false) : ?>
			<input type="hidden" id="notifications_list_op_code" value="<?= $_SESSION["NOTOFICATIONS_LIST_OP_CODE"]; ?>" />
		<?php endif ?>

		<?php if (strpos($OP_CODE_LIST, "NOTOFICATIONS_COUNT_OP_CODE") !== false) : ?>
			<input type="hidden" id="notifications_count_op_code" value="<?= $_SESSION["NOTOFICATIONS_COUNT_OP_CODE"]; ?>" />
		<?php endif ?>

	<?php endif  ?>

</div>