<!-- Content Wrapper. Contains page content -->
<style>
    /* Important part */
    .modal-dialog {
        overflow-y: initial !important
    }

    .modal-body {
        height: 80vh;
        overflow-y: auto;
    }
</style>
<div class="container">
    <div class="row">

        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="ui-block responsive-flex">
                        <div class="ui-block-title">
                            <div class="h6 title">منابع مربوط به <?php if (isset($this_subject_name)) echo $this_subject_name; ?> </div>

                            <div class="block-btn align-right">
                                <a id="select_resource" data-toggle="modal" data-target="#add-resource" onclick="clearData();" style="color:#fff;background:#008000;" class="btn btn-md btn-primary color-white">
                                    <i class="fa fa-anchor" aria-hidden="true"></i>
                                    &nbsp;
                                    افزودن منبع

                                </a>
                            </div>

                            <?php if (isset($msg)) echo $msg; ?>

                            <a href="<?= $HOST_NAME ?>/admin/subjects/" class="more">
                                <svg class="olymp-popup-left-arrow">
                                    <use xlink:href="#olymp-popup-left-arrow"></use>
                                </svg>
                            </a>
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

        <!-- Modal -->
        <!-- Window-popup Add Resources -->

        <div class="modal fade" id="add-resource" tabindex="-1" role="dialog" aria-labelledby="add-resource" aria-hidden="true">
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
                                <img id="resource_photo" src="" width="180" style="display: inline-block;" />
                            </div>

                        </div>
                        <form enctype="multipart/form-data" name="frmSubjectResources" id="frmSubjectResources" role="form" method="post">
                            <input type="hidden" name="this_subject_id" id="this_subject_id" value="<?php echo $this_subject_id; ?>" />
                            <input type="hidden" id="hashId" name="hashId" />
                            <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                            <input type="hidden" name="resource_id" id="resource_id" />
                            <input type="hidden" name="photo_address" id="photo_address" />

                            <div class="form-group">
                                <a id="select_source" onclick="loadResourceList();" data-toggle="modal" data-target="#choose-from-resources" style="color:#fff;background:#008000;" class="btn btn-md btn-primary color-white full-width">
                                    <i class="fa fa-anchor" aria-hidden="true"></i>
                                    &nbsp;
                                    انتخاب منبع

                                </a>
                            </div>

                            <div class="form-group">
                                <label for="title" class="control-label">عنوان</label>
                                <input type="text" class="form-control " name="title" id="title" readonly>
                            </div>
                            <div class="form-group">
                                <label class="control-label">توضیحات</label>

                                <textarea name="brief_description" id="brief_description" class="form-control" cols="45" rows="3" style="resize: none"></textarea>

                            </div>
                            <div class="form-group">
                                <input type="hidden" id="category_ids" name="category_ids" />
                                <label for="categories" class=" control-label">گروههای مرتبط</label>
                                <div id="categories_div">
                                    <select id="categories" name="categories" class="form-control multi-select-full full-width" multiple="multiple">
                                        <?php foreach ($subject_categories as $subject_category) : ?>
                                            <option value="<?= $subject_category['id'] ?>"> <?= $subject_category['name'] ?> </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label> : اهمیت</label>
                                <select id="importance" name="importance" onChange="loadData();" class="form-control" aria-controls="sample_1">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label class="control-label">ترتیب</label>

                                <input type="text" class="form-control" name="ordering" id="ordering">

                            </div>
                            <div class="form-group">

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

        <!-- Window-popup Choose from my resources -->
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
                                                <label for="imgSearch"> </label>
                                                <button class="btn btn-blue btn-search form-control" onclick="loadResourceList('search');" name="imgResourceSearch" id="imgResourceSearch" type="button"><i class="fa fa-search fa-2x"></i> </button>
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
                    <div class="modal-footer">
                        <a href="#" data-dismiss="modal" class="btn btn-secondary btn-lg btn--half-width">لغو</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- ... end Window-popup Choose from my resources -->

    </div>
</div>
<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<link rel="stylesheet" href="<?php echo $HOST_NAME; ?>resources/plugins/filter-multi-select/filter_multi_select.css" />
<script src="<?php echo $HOST_NAME; ?>resources/plugins/filter-multi-select/filter-multi-select-bundle.min.js"></script>


<link rel="stylesheet" href="<?php echo $HOST_NAME; ?>resources/plugins/selects/select2.min.css" />
<script src="<?php echo $HOST_NAME; ?>resources/plugins/selects/select2.min.js"></script>

<script src="<?php echo $HOST_NAME; ?>resources/plugins/selects/uniform.min.js"></script>
<script src="<?php echo $HOST_NAME; ?>resources/plugins/selects/bootstrap_multiselect.js"></script>

<script src="<?php echo $HOST_NAME;  ?>app/admin/scripts/subject_resources.js"></script>