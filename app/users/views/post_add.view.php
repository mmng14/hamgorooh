<link href="<?php echo $HOST_NAME; ?>resources/plugins/tags/bootstrap-tagsinput.css" rel="stylesheet" />

<style>
    #loadMorePhotos {
        clear: both;
        text-align: center;
        padding-top: 5px;
        border-top: 1px solid #eee;
    }

    .choose-photo-item {
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="ui-block">
                <div class="ui-block-title">
                    <h6 class="title"><?php echo $form_title; ?></h6>
                </div>
                <div class="ui-block-content">
                    <div class="row">
                        <!-- page start-->
                        <input type="hidden" name="site_name" id="site_name" value="<?php echo $HOST_NAME; ?>" />
                        <input type="hidden" name="this_subject_id" id="this_subject_id" value="<?php echo $selected_subject_id; ?>" />
                        <!-- <input type="hidden" name="this_category_id" id="this_category_id" value="<?php echo $this_category_id; ?>" /> -->

                        <!-- Show Message if exist -->
                        <?php if (isset($error) && $error != "") : ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-ban"></i>! خطا</h4>
                                <span><?php echo $error; ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($msg_ok) && $msg_ok != "") : ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-check"></i>عملیات موفق</h4>
                                <?php echo $msg_ok; ?>
                            </div>
                        <?php endif; ?>
                        <style>
                            /*** Just for this form**/
                            #myModal {
                                display: none;
                                /*direction: rtl;*/
                            }

                            .modal-content {
                                box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.125);
                            }

                            .modal-header {
                                background: #bbb;
                            }

                            #postImage {
                                object-fit: cover !important;
                                margin-bottom: 20px;
                                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            }
                        </style>

                        <div id="divPostForm" class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb30">

                            <div class="form-group">

                                <div class="col-md-12 callout-warning text-center">
                                    <?php
                                    $thumb_address = "";
                                    if (isset($edit_thumb_address) && $edit_thumb_address != "") {
                                        $thumb_address = $edit_thumb_address;
                                        if (strpos(strtolower($thumb_address), 'http') === false) {
                                            $thumb_address = $HOST_NAME . $thumb_address;
                                        }
                                    }
                                    ?>
                                    <?php if ($thumb_address != "") : ?>
                                        <img id="postImage" src="<?= $thumb_address ?>" width="200" height="120" />
                                    <?php else : ?>
                                        <img id="postImage" width="200" height="120" />
                                    <?php endif; ?>

                                    <label for="upload" class="btn btn-primary btn-block">انتخاب تصویر</label>
                                    <input type="file" name="upload" id="upload" class="post-file-upload" />
                                    <input type="hidden" name="photo_address" id="photo_address" value="<?php echo $edit_photo_address; ?>" />
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label class="control-label" style="display: none;">نوع فایل</label>
                                    <select class="form-control" id="post_type" name="post_type">
                                        <option selected value="0">تصویری</option>
                                        <option value="1">صوتی</option>
                                        <option value="2">ویدیویی</option>
                                    </select>
                                </div>
                            </div>
                            <form enctype="multipart/form-data" name="add_post_form" id="add_post_form" role="form" method="post">

                                <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                                <input type="hidden" id="_upload_folder" name="_upload_folder" value="<?php echo $upload_folder_session_name; ?>" />
                                <input type="hidden" name="photo_data" id="photo_data" />

                                <input type="hidden" id="post_id" name="post_id" value="<?php echo $edit_id; ?>" />
                                <input type="hidden" id="_hashId" name="_hashId" value="<?php echo $edit_id; ?>" />
                                <input type="hidden" id="subject_id" name="subject_id" value="<?php echo $selected_subject_id; ?>" />
                                <!-- <input type="hidden" id="category_id" name="category_id" value="<?php echo $this_category_id; ?>" /> -->
                                <input type="hidden" id="page_num" name="page_num" value="<?php echo $page_number; ?>" />

                                <div class="row">
                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">گروه</label>
                                            <!-- <input type="text" name="category_id" id="category_id" disabled class="form-control" value="<?php if (isset($this_category_name)) echo $this_category_name; ?>" /> -->
                                            <select id="category_id" name="category_id" class="form-control selectpicker text-center" aria-controls="sample_1">
                                                <option value="0" <?php if ($category_filter == "") echo "selected" ?>>
                                                    انتخاب کنید
                                                </option>
                                                <?php if (isset($category_filter_rows) && $category_filter_rows != null) : ?>
                                                    <?php foreach ($category_filter_rows as $category_filter_row) : ?>
                                                        <option value="<?php echo $category_filter_row["id"]; ?>" <?php if (isset($selected_category_id) && $category_filter_row["id"] == $selected_category_id) echo " selected "; ?>>
                                                            <?php echo $category_filter_row["name"]; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class=" control-label">زیر گروه</label>
                                            <select class="form-control text-center" id="sub_category_id" name="sub_category_id">
                                                <option value="0">انتخاب کنید</option>
                                                <?php
                                                if (isset($selected_subcategory_rows)) {
                                                    foreach ($selected_subcategory_rows as $selected_subcategory_row) {
                                                        if (isset($selected_subcategory_id) && $selected_subcategory_row["id"] == $selected_subcategory_id) {
                                                            echo "<option selected value=\"" . $selected_subcategory_row['id'] . "\" />" . $selected_subcategory_row['name'] . "</option>";
                                                        } else {
                                                            echo "<option value=\"" . $selected_subcategory_row['id'] . "\" />" . $selected_subcategory_row['name'] . "</option>";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">عنوان</label>
                                            <input type="text" name="title" id="title" class="form-control full-width text-center" value="<?php echo $edit_title; ?>" />
                                        </div>
                                    </div>

                                    <!-- <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">کلمات کلیدی</label>
                                            <input type="text" name="keywords" id="keywords" class="form-control full-width" style="width: 100%;" value="<?php echo $edit_keywords; ?>" />
                                        </div>
                                    </div> -->

                                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">توضیحات مختصر</label>
                                            <textarea name="brief_description" id="brief_description" class="form-control" rows="5"><?php echo $edit_brief_description; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">

                                            <div class="add-options-message">
                                                <label class="control-label">توضیحات</label><br /><br />


                                                <div class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="افزودن تصاویر">
                                                    <svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo">
                                                        <use xlink:href="#olymp-camera-icon"></use>
                                                    </svg>
                                                </div>
                                                <!--                                                <div href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="TAG YOUR FRIENDS">-->
                                                <!--                                                    <svg class="olymp-computer-icon">-->
                                                <!--                                                        <use xlink:href="#olymp-computer-icon"></use>-->
                                                <!--                                                    </svg>-->
                                                <!--                                                </div>-->
                                                <!---->
                                                <!--                                                <div href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="ADD LOCATION">-->
                                                <!--                                                    <svg class="olymp-small-pin-icon">-->
                                                <!--                                                        <use xlink:href="#olymp-small-pin-icon"></use>-->
                                                <!--                                                    </svg>-->
                                                <!--                                                </div>-->

                                                <span>تصاویری که در داخل محتوا قرار می گیرند را از این قسمت وارد نمایید</span>

                                            </div>
                                            <textarea class="ckeditor" name="description" id="description" rows="20"><?php echo $edit_content; ?></textarea>
                                            <input type="text" name="content_photos" id="content_photos" class="form-control" value="" />

                                        </div>
                                    </div>



                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">نام منبع</label>
                                            <input type="text" class="form-control" name="source_name" id="source_name" value="<?php echo $edit_source_name; ?>">
                                        </div>
                                    </div>
                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">لینک منبع</label>
                                            <input type="text" class="form-control" name="source_link" id="source_link" value="<?php echo $edit_source_link; ?>" placeholder="(به همراه //:http)">
                                        </div>
                                    </div>

                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">نظردهی</label>
                                            <select class="form-control" id="comment_status" name="comment_status">
                                                <option value="1">دارد</option>
                                                <option value="0">ندارد</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">فایل ضمیمه</label>
                                            <select class="form-control" id="has_attachment" name="has_attachment">
                                                <option value="1">دارد</option>
                                                <option value="0">ندارد</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                        <input type="button" name="btnClear" id="btnClear" class="btn btn-info" onclick="clearForm();" value="بازنشانی" />
                                        <input type="hidden" name="<?php echo $add_update; ?>" id="add_update" value="1" />
                                        <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-md btn-primary">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            &nbsp;
                                            تایید
                                        </button>
                                        <a href="<?php echo $HOST_NAME; ?>users/posts/<?php echo $selected_subject_id ?>" name="cancel" id="cancel" class="btn btn-md btn-danger">
                                            <i class="fa fa-window-close" aria-hidden="true"></i>
                                            &nbsp;
                                            بستن
                                        </a>
                                    </div>

                                </div>

                            </form>

                        </div>
                        <!-- page end-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Window-popup Upload Photo -->
    <div class="modal fade" id="update-header-photo" tabindex="-1" role="dialog" aria-labelledby="update-header-photo" aria-hidden="true">
        <div class="modal-dialog window-popup update-header-photo" role="document">
            <div class="modal-content">

                <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon">
                        <use xlink:href="#olymp-close-icon"></use>
                    </svg>
                </a>

                <div class="modal-header">
                    <h6 class="title">بارگذاری تصاویر</h6>
                    <img id="uploadedImage" width="30" height="20" style="border:4px solid #fff;" />
                </div>

                <div class="modal-body">

                    <div class="upload-photo-item">
                        <label for="upload_image" class="btn-block text-center" style="cursor: pointer;">
                            <svg class="olymp-computer-icon">
                                <use xlink:href="#olymp-computer-icon"></use>
                            </svg>
                            <h6 class="text-center">بارگذاری تصاویر</h6>
                        </label>
                        <input type="file" name="upload_image" id="upload_image" class="post-file-upload" />
                        <input type="hidden" name="image_data" id="image_data" />
                        <span></span>
                    </div>

                    <div class="upload-photo-item" onclick="loadPhotoList();" data-toggle="modal" data-target="#choose-from-my-photo">

                        <svg class="olymp-photos-icon">
                            <use xlink:href="#olymp-photos-icon"></use>
                        </svg>

                        <h6 class="text-center">انتخاب از لیست تصاویر</h6>
                        <span></span>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- ... end Window-popup Upload Photo -->

    <!-- Window-popup Choose from my Photo -->
    <div class="modal fade" id="choose-from-my-photo" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-photo" aria-hidden="true">
        <div class="modal-dialog window-popup choose-from-my-photo" role="document">

            <div class="modal-content">
                <div class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon">
                        <use xlink:href="#olymp-close-icon"></use>
                    </svg>
                </div>
                <div class="modal-header">
                    <h6 class="title">انتخاب از لیست تصاویر</h6>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">
                                <svg class="olymp-photos-icon">
                                    <use xlink:href="#olymp-photos-icon"></use>
                                </svg>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#photoList" role="tab" aria-expanded="false">
                                <svg class="olymp-albums-icon">
                                    <use xlink:href="#olymp-albums-icon"></use>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="modal-body">
                    <!-- Tab panes -->
                    <div class="tab-content">

                        <div class="tab-pane active" id="photoList" role="tabpanel" aria-expanded="false">

                            <div id="photoListContainer">

                            </div>

                            <div id="loadMorePhotos">

                                <div id="load-more-photos-button" onclick="loadPhotoList();" class="btn btn-control btn-more" data-load-link="" data-container="">
                                    <input type="hidden" id="photoListPageNumber" value="1" />
                                    <svg class="olymp-three-dots-icon">
                                        <use xlink:href="#olymp-three-dots-icon"></use>
                                    </svg>
                                </div>
                            </div>

                            <!-- <button onclick="selectFromPhotoList(0);" class="btn btn-primary btn-lg disabled btn--half-width">تایید </button> -->
                            <a href="#" data-dismiss="modal" class="btn btn-secondary btn-lg btn--half-width">لغو</a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- ... end Window-popup Choose from my Photo -->

</div>

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>resources/plugins/tags/bootstrap-tagsinput.js"></script>
<script src="<?php echo $HOST_NAME; ?>resources/ckeditor/ckeditor.js"></script>
<!--<script src="--><?php //echo $HOST_NAME;  
                    ?>
<!--app/scripts/users/imageResize.js"></script>-->
<script src="<?php echo $HOST_NAME; ?>app/users/scripts/post_add.js"></script>

<script>
    if (typeof(CKEDITOR) !== "undefined") {
        CKEDITOR.env.isCompatible = true;
    }
</script>