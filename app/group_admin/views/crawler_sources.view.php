<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">مدیریت منابع</div>
                            <input type="hidden" name="selected_subject_id" id="selected_subject_id" value="<?php echo $selected_subject_id; ?>" />
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
                        <h6 class="title">افزودن / ویرایش منابع</h6>
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
                        <form enctype="multipart/form-data" name="formCrawlerSources" id="formCrawlerSources" role="form" method="post">
                            <input type="hidden" id="hashId" name="hashId" />
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <div class="form-group">
                                <label for="category_type" class="control-label">نوع</label>
                                <input type="text" class="form-control " name="category_type" id="category_type">
                            </div>
                            <div class="form-group">
                                
                                <label for="category_id" class="control-label">دسته بندی</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="0">انتخاب کنید</option>
                                    <?php foreach ($categories as $category): ?> 
                                        <option value="<?= $category['id'] ?>" > <?= $category['name'] ?> </option>
                                    <?php endforeach ?> 
                                </select>

                            </div>
                            <div class="form-group">
                                
                                <label for="sub_category_id" class="control-label">زیر گروه</label>
                                <select class="form-control" id="sub_category_id" name="sub_category_id">
                                    <option value="0">انتخاب کنید</option>
             
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="site_name" class="control-label">عنوان سایت </label>
                                <input type="text" class="form-control " name="site_name" id="site_name">
                            </div>
                            <div class="form-group">
                                <label for="crawler" class="control-label">عنوان ربات</label>
                                <input type="text" class="form-control " name="crawler" id="crawler">
                            </div>
                            <div class="form-group">
                                <label for="source_name" class="control-label">عنوان منبع</label>
                                <input type="text" class="form-control" name="source_name" id="source_name">
                            </div>
                            <div class="form-group">
                                <label for="source_link" class="control-label">آدرس منبع </label>
                                <input type="text" class="form-control" name="source_link" id="source_link">
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
<script src="<?php echo $HOST_NAME; ?>app/group_admin/scripts/crawler_sources.js"></script>