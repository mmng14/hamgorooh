<link href="<?php echo $HOST_NAME; ?>resources/plugins/tags/bootstrap-tagsinput.css" rel="stylesheet" />

<style>
    #loadMorePhotos,#loadMoreResource {
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
                        <input type="hidden" name="this_subject_id" id="this_subject_id" value="<?php echo $this_subject_id; ?>" />
                        <input type="hidden" name="this_category_id" id="this_category_id" value="<?php echo $this_category_id; ?>" />

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
                                <input type="hidden" id="subject_id" name="subject_id" value="<?php echo $this_subject_id; ?>" />
                                <input type="hidden" id="category_id" name="category_id" value="<?php echo $this_category_id; ?>" />
                                <input type="hidden" id="page_num" name="page_num" value="<?php echo $page_number; ?>" />

                                <div class="row">
                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">گروه</label>
                                            <input type="text" name="category_id" id="category_id" disabled class="form-control" value="<?php if (isset($this_category_name)) echo $this_category_name; ?>" />
                                        </div>
                                    </div>
                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class=" control-label">زیر گروه</label>
                                            <select class="form-control" id="sub_category_id" name="sub_category_id">
                                                <option value="0">انتخاب کنید</option>
                                                <?php


                                                foreach ($selected_subcategory_rows as $selected_subcategory_row) {
                                                    if ($selected_subcategory_row["id"] == $selected_subcategory_id) {
                                                        echo "<option selected value=\"" . $selected_subcategory_row['id'] . "\" />" . $selected_subcategory_row['name'] . "</option>";
                                                    } else {
                                                        echo "<option value=\"" . $selected_subcategory_row['id'] . "\" />" . $selected_subcategory_row['name'] . "</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">عنوان</label>
                                            <input type="text" name="title" id="title" class="form-control full-width" value="<?php echo $edit_title; ?>" />
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


                                                <div class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="آپلود تصویر">
                                                    <svg class="olymp-camera-icon" data-toggle="modal" data-target="#update-header-photo">
                                                        <use xlink:href="#olymp-camera-icon"></use>
                                                    </svg>
                                                </div>

                                                <div class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="انتخاب تصویر از لیست">
                                                    <svg class="olymp-computer-icon" onclick="loadPhotoList();" data-toggle="modal" data-target="#choose-from-my-photo">
                                                        <use xlink:href="#olymp-computer-icon"></use>
                                                    </svg>
                                                </div>

                                                <!-- <div href="#" class="options-message" data-toggle="tooltip" data-placement="top" data-original-title="ADD LOCATION">
                                                    <svg class="olymp-small-pin-icon" >
                                                        <use xlink:href="#olymp-small-pin-icon"></use>
                                                    </svg>
                                                </div> -->

                                                <span>تصاویری که در داخل محتوا قرار می گیرند را از این قسمت آپلود یا انتخاب نمایید</span>

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
                                                <option <?php if ($edit_comment_status == 1) echo "  selected "; ?> value="1">دارد</option>
                                                <option <?php if ($edit_comment_status == 0) echo "  selected "; ?> value="0">ندارد</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label class="control-label">نوع پست</label>
                                            <select class="form-control" id="post_status" name="post_status">
                                                <option <?php if ($edit_post_status == 1) echo "  selected "; ?> value="1">پست</option>
                                                <option <?php if ($edit_post_status == 2) echo "  selected "; ?> value="2">منبع</option>
                                            </select>
                                        
                                        </div>
                                    </div>


                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="display:none;">
                                        <div class="form-group label-floating">
                                            <label class="control-label">فایل ضمیمه</label>
                                            <select class="form-control" id="has_attachment" name="has_attachment">
                                                <option value="1">دارد</option>
                                                <option value="0">ندارد</option>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="col col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" style="display:none;">
                                        <div class="form-group label-floating">
                                            <label for="parent_id" class=" control-label">پست پدر</label>
                                            <select class="form-control" id="parent_id" name="parent_id">
                                                <option value="0" selected="selected">انتخاب کنید</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                        <input type="button" name="btnClear" id="btnClear" class="btn btn-info" onclick="clearForm();" value="بازنشانی" />
                                        <input type="hidden" name="<?php echo $add_update; ?>" id="add_update" value="1" />
                                        <a id="select_source" onclick="loadResourceList();"   data-toggle="modal" data-target="#choose-from-resources" style="color:#fff;background:#008000;" class="btn btn-md btn-primary color-white">
                                                <i class="fa fa-anchor" aria-hidden="true"></i>
                                                &nbsp;
                                                انتخاب منبع داخلی
                                        </a>
                                        <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-md btn-primary">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            &nbsp;
                                            تایید
                                        </button>
                                        <a href="<?php echo $HOST_NAME; ?>admin/posts/<?php echo $this_category_id ?>" name="cancel" id="cancel" class="btn btn-md btn-danger">
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


    <!-- Window-popup Choose from my Photo -->
    <div class="modal fade" id="choose-from-resources" tabindex="-1" role="dialog" aria-labelledby="choose-from-my-resource" aria-hidden="true">
        <div class="modal-dialog window-popup choose-from-my-photo" role="document">

            <div class="modal-content">
                <div class="close icon-close" data-dismiss="modal" aria-label="Close">
                    <svg class="olymp-close-icon">
                        <use xlink:href="#olymp-close-icon"></use>
                    </svg>
                </div>
                <div class="modal-header">
                    <h6 class="title">انتخاب منبع</h6>

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
                            <a class="nav-link active" data-toggle="tab" href="#resourceList" role="tab" aria-expanded="false">
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
                        <div class="tab-pane active" id="resourceList" role="tabpanel" aria-expanded="false">
                            <div class="container">
                                <div class="row">
                                    <!-- <div class="col col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">

                                            <label> گروها :</label>
                                            <select id="sub_category_filter" name="sub_category_filter" class="form-control selectpicker" aria-controls="sample_1">
                                                <option value="0">
                                                    انتخاب کنید
                                                </option>

                                            </select>

                                        </div>
                                    </div> -->
                                    <div class="col col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label> عبارت جستجو :</label>
                                            <input type="text" class="form-control full-width" name="txtResourceSearch" id="txtResourceSearch">
                                        </div>
                                    </div>
                                    <div class="col col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <div class="form-group label-floating">
                                            <label for="imgSearch">  </label>
                                            <button class="btn btn-blue btn-search form-control"  onclick="loadResourceList('search');" name="imgResourceSearch" id="imgResourceSearch" type="button"><i class="fa fa-search fa-2x"></i> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="resourceListContainer">

                            </div>

                            <div id="loadMoreResource">

                                <div id="load-more-resource-button" onclick="loadResourceList('paging');" class="btn btn-control btn-more" data-load-link="" data-container="">
                                    <input type="hidden" id="resourceListPageNumber" value="1" />
                                    <svg class="olymp-three-dots-icon">
                                        <use xlink:href="#olymp-three-dots-icon"></use>
                                    </svg>
                                </div>
                            </div>
                          

                        </div>
                    </div>
              
                </div>
                <div class="modal-footer" >
                <a href="#" data-dismiss="modal" class="btn btn-secondary btn-lg btn--half-width">لغو</a>
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
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/post_add.js"></script>

<script>
    if (typeof(CKEDITOR) !== "undefined") {
        CKEDITOR.env.isCompatible = true;
    }
</script>