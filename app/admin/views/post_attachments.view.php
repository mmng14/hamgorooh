<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">مدیریت ضمایم </div>
                            <input type="hidden" id="selected_post_id" name="selected_post_id" value="<?= $selected_post["id"] ?>" />
                            <input type="hidden" id="post_subject_id" name="post_subject_id" value="<?= $selected_post["subject_id"] ?>" />
                            <input type="hidden" id="post_category_id" name="post_category_id" value="<?= $selected_post["category_id"] ?>" />
                            <div class="block-btn align-right">
                                <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-md-2" onclick="clearForm();">افزودن +</a>

                            </div>
                            <?php if (isset($msg)) echo $msg; ?>

                            <div class="block-btn align-right">
                                <label> مرتب سازی : </label>
                                <select id="cmbsort" name="cmbsort" onChange="loadData();" class="selectpicker form-control " aria-controls="sample_1">
                                    <option value="1">قدیمی تر</option>
                                    <option value="2">جدید تر</option>
                                </select>
                            </div>
                            <div class="block-btn align-right">
                                <label> تعداد سطرها :</label>
                                <select id="cmbnumberPage" name="cmbnumberPage" onChange="loadData();" class="selectpicker form-control" aria-controls="sample_1">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                    <option value="1000">1000</option>
                                </select>
                            </div>

                            <a href="#" class="more"><svg class="olymp-three-dots-icon">
                                    <use xlink:href="#olymp-three-dots-icon"></use>
                                </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Tab panes -->
                    <h6 class="title"> <span style="color: #999;"> ضمایم مربوط به :  </span><b><?= $selected_post["title"] ?></b></h6>
                    <div class="ui-block responsive-flex" id="results">
                        <div class="loading-div" id="loader"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Window-popup Create Photo Album -->

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="create-photo-album" aria-hidden="true">
            <div class="modal-dialog window-popup create-photo-album" role="document">
                <div class="modal-content">
                    <a href="#" class="close icon-close" data-dismiss="modal" aria-label="Close">
                        <svg class="olymp-close-icon">
                            <use xlink:href="#olymp-close-icon"></use>
                        </svg>
                    </a>

                    <div class="modal-header">
                        <h6 class="title">افزودن / ویرایش ضمایم منابع</h6>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">

                            <div id="imageSelectBox" class="col-md-12 callout-warning text-center">

                                <img id="uploadImage" width="200" height="120" />

                                <label for="upload" class="btn btn-primary text-center upload-lable-btn">انتخاب
                                    تصویر</label>
                                <input type="file" name="upload" id="upload" class="post-file-upload" />
                                <input type="hidden" name="photo_address" id="photo_address" value="" />
                            </div>


                        </div>
                        <form enctype="multipart/form-data" name="formPostAttachments" id="formPostAttachments" role="form" method="post">
                            <input type="hidden" id="hashId" name="hashId" />
                            <input type="hidden" id="post_id" name="post_id" value="<?= $selected_post["id"] ?>" />
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <div class="form-group">
                                <label for="title" class="control-label">عنوان</label>
                                <input type="text" class="form-control " name="title" id="title">
                            </div>

                            <div class="form-group">
                                <label for="description" class="control-label">توضیحات</label>
                                <!-- <textarea class="form-control ckeditor" name="description" id="description" cols="45" rows="8" style="resize:none"></textarea> -->
                                <textarea class="form-control" name="description" id="description" cols="45" rows="8" style="resize:none"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="link_address" class="control-label">لینک ضمیمه</label>
                                <input type="text" class="form-control " name="link_address" id="link_address">
                            </div>
                            <div class="form-group">
                                <label for="attachment_type" class="control-label">نوع ضمیمه</label>
                                <select class="form-control" id="attachment_type" name="attachment_type">
                                    <option value="0" selected="selected">انتخاب کنید</option>
                                    <option value="1">فایل PDF</option>
                                    <option value="2">فایل WORD</option>
                                    <option value="3">فایل صوتی</option>
                                    <option value="4">فایل ویدیویی</option>
                                    <option value="5">لینک</option>

                                </select>
                            </div>
                            <div class="form-group">
                                
                                <label for="parent_id" class=" control-label">ضمیمه پدر</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="0" selected="selected">انتخاب کنید</option>

                                </select>

                            </div>
                            <div class="form-group">
                                <label for="ordering" class="control-label">ترتیب </label>
                                <input type="text" class="form-control" name="ordering" id="ordering">

                            </div>
                            <div class="form-group">
                                <!-- <label class="control-label">وضعیت</label>

                                <input type="checkbox" name="status" id="status" class="checkboxes" value="1" /> -->

                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="status" id="status" class="checkboxes" value="1">
                                        وضعیت
                                    </label>
                                </div>

                            </div>

                            <button type="submit" id="save" name="save" class="btn btn-green btn-md btn-send">ذخیره</button>
                            <button class="btn btn-grey btn-md" data-dismiss="modal">بستن</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- ... end Window-popup Create Photo Album -->
    </div>
</div>

<!-- /.content-wrapper -->

<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>

<script src="<?php echo $HOST_NAME; ?>resources/ckeditor/ckeditor.js"></script>
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/post_attachments.js"></script>