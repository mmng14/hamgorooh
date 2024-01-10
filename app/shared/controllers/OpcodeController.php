<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' &&  isset($_POST['check']) && $_POST['check'] == "GET_ADMIN_OP_CODES") {

    page_access_check_ajax(array(1,2,3,4,5), $HOST_NAME);

    $_SESSION["INSERT_CODE"]=GUIDv4();
    $_SESSION["UPDATE_CODE"]=GUIDv4();
    $_SESSION["DELETE_CODE"]=GUIDv4();
    $_SESSION["MULTI_DELETE_CODE"]=GUIDv4();
    $_SESSION["ACTIVATE_CODE"]=GUIDv4();
    $_SESSION["DEACTIVATE_CODE"]=GUIDv4();
	$_SESSION["ACTIVATE_TOPMENU_CODE"]=GUIDv4();
    $_SESSION["DEACTIVATE_TOPMENU_CODE"]=GUIDv4();	
	$_SESSION["ACTIVATE_PAYMENT_CODE"]=GUIDv4();
    $_SESSION["DEACTIVATE_PAYMENT_CODE"]=GUIDv4(); 
	$_SESSION["CUSTOMIZE_CODE"]=GUIDv4();
	$_SESSION["UNCUSTOMIZE_CODE"]=GUIDv4();
	$_SESSION["GET_DATE_AND_PRICE_CODE"]=GUIDv4();
    $_SESSION["GET_PRICE_CODE"]=GUIDv4();
    $_SESSION["SEND_TO_SUBJECTS_CODE"]=GUIDv4();
	$_SESSION["UPDATE_TO_SUBJECTS_CODE"]=GUIDv4();
	$_SESSION["DELETE_TO_SUBJECTS_CODE"]=GUIDv4();
	$_SESSION["SEND_TO_ALL_SUBJECTS_CODE"]=GUIDv4();
    $_SESSION["EDIT_CODE"]=GUIDv4();
    $_SESSION["SET_UPLOAD_FOLDER_CODE"]=GUIDv4();
	$_SESSION["SEND_TO_TELEGRAM_CODE"]=GUIDv4();
	$_SESSION["SEND_TO_REPORTAGE_CODE"]=GUIDv4();
	$_SESSION["SET_GROUP_ACCESS_CODE"]=GUIDv4();
	$_SESSION["SET_CATEGORY_CODE"]=GUIDv4();
	$_SESSION["SET_USER_TYPE_CODE"]=GUIDv4();
	$_SESSION["PASSWORD_CHANGE_CODE"]=GUIDv4();
	$_SESSION["GET_CATEGORY_LIST_CODE"]=GUIDv4();
	$_SESSION["GET_SUBCATEGORY_LIST_CODE"]=GUIDv4();
	$_SESSION["GET_CITY_LIST_CODE"]=GUIDv4();
	$_SESSION["LISTING_CODE"]=GUIDv4();
	$_SESSION["ACCEPT_REQUEST_CODE"]=GUIDv4();
	$_SESSION["REJECT_REQUEST_CODE"]=GUIDv4();
	$_SESSION["POST_IMAGE_UPLOAD_CODE"]=GUIDv4();
	$_SESSION["POST_IMAGE_LIST_CODE"]=GUIDv4();  

    echo json_encode(
        array(
            "status"=>"1",
            "insert_code"=>$_SESSION["INSERT_CODE"],
            "update_code"=>$_SESSION["UPDATE_CODE"],
            "delete_code"=>$_SESSION["DELETE_CODE"],
            "multi_delete_code"=>$_SESSION["MULTI_DELETE_CODE"],
            "activate_code"=>$_SESSION["ACTIVATE_CODE"],
            "deactivate_code"=>$_SESSION["DEACTIVATE_CODE"],
            "activate_topmenu_code"=>$_SESSION["ACTIVATE_TOPMENU_CODE"],
            "deactivate_topmenu_code"=>$_SESSION["DEACTIVATE_TOPMENU_CODE"],
            "activate_payment_code"=>$_SESSION["ACTIVATE_PAYMENT_CODE"],
            "deactivate_payment_code"=>$_SESSION["DEACTIVATE_PAYMENT_CODE"],
            "customize_code"=>$_SESSION["CUSTOMIZE_CODE"],
            "uncustomize_code"=>$_SESSION["UNCUSTOMIZE_CODE"],
            "get_date_and_price_code"=>$_SESSION["GET_DATE_AND_PRICE_CODE"],
            "get_price_code"=>$_SESSION["GET_PRICE_CODE"],
            "send_to_subjects_code"=>$_SESSION["SEND_TO_SUBJECTS_CODE"],
            "update_to_subjects_code"=>$_SESSION["UPDATE_TO_SUBJECTS_CODE"],
            "delete_to_subjects_code"=>$_SESSION["DELETE_TO_SUBJECTS_CODE"],
            "send_to_all_subjects_code"=>$_SESSION["SEND_TO_ALL_SUBJECTS_CODE"],
            "edit_code"=>$_SESSION["EDIT_CODE"],
            "set_upload_folder_code"=>$_SESSION["SET_UPLOAD_FOLDER_CODE"],
            "send_to_telegram_code"=>$_SESSION["SEND_TO_TELEGRAM_CODE"],
            "send_to_reportage_code"=>$_SESSION["SEND_TO_REPORTAGE_CODE"],
            "set_group_access_code"=>$_SESSION["SET_GROUP_ACCESS_CODE"],
            "set_category_code"=>$_SESSION["SET_CATEGORY_CODE"],
            "set_user_type_code"=>$_SESSION["SET_USER_TYPE_CODE"],
            "password_change_code"=>$_SESSION["PASSWORD_CHANGE_CODE"],
            "get_category_list_code"=>$_SESSION["GET_CATEGORY_LIST_CODE"],
            "get_subcategory_list_code"=>$_SESSION["GET_SUBCATEGORY_LIST_CODE"],
            "get_city_list_code"=>$_SESSION["GET_CITY_LIST_CODE"],
            "listing_code"=>$_SESSION["LISTING_CODE"],
            "accept_request_code"=>$_SESSION["ACCEPT_REQUEST_CODE"],
            "reject_request_code"=>$_SESSION["REJECT_REQUEST_CODE"],
            "post_image_upload_code"=>$_SESSION["POST_IMAGE_UPLOAD_CODE"],
            "post_image_list_code"=>$_SESSION["POST_IMAGE_LIST_CODE"],
        )
    );
    exit;
}

