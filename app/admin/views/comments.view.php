<link href="<?php echo $HOST_NAME; ?>resources/plugins/tags/bootstrap-tagsinput.css" rel="stylesheet" />

<style>
    .center {
        position: absolute;
        left: 50%;
        top: 50%;
    }

    #myDiv {
        display: none;
        text-align: center;
    }
    .block-btn{
        padding-left: 4px !important;
    }

    .btn-search{
        padding: 15px 10px !important;
    }

    .btn{
        cursor: pointer;
    }
</style>


<!-- Content Wrapper. Contains page content -->
<div class="container">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <form id="frmPosts">
                        <div class="ui-block responsive-flex">
                            <div class="ui-block-title">
                                <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />

                                <div class="block-btn align-right">
                                

                                </div>
                                <input type="hidden" name="site_name" id="site_name" value="<?php echo $HOST_NAME; ?>" />
                                <input type="hidden" name="this_subject_id" id="this_subject_id" value="<?php echo $selected_subject_id; ?>" />
                                <input type="hidden" name="this_category_id" id="this_category_id" value="<?php echo $selected_category_id; ?>" />
                                <input type="hidden" name="this_post_id" id="this_post_id" value="<?php echo $selected_post_id; ?>" />
                                <input type="hidden" id="page_num" name="page_num" value="<?php if (isset($page_number)) echo $page_number; ?>" />

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
                                <?php if (isset($msg)) echo $msg; ?>

                                <div class="block-btn align-right">
                                    <label>  عبارت جستجو :</label>

                                    <div class="input-group input-group-sm">
                                        <span class="input-group-btn">
                                            <button class="btn btn-blue btn-search" name="imgSearch" id="imgSearch" type="button"><i class="fa fa-search fa-2x"></i> </button>

                                        </span>
                                        <input type="text" class="form-control" name="txtsearch" id="txtsearch" >
                                    </div>
                                </div>


                                <div class="block-btn align-right">
                                    <label>تعداد سطرها : </label>
                                    <select id="cmbnumberPage" name="cmbnumberPage"  class="form-control selectpicker" aria-controls="sample_1">
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

                                <div class="block-btn align-right">
                                    <label>مرتب سازی : </label>
                                    <select id="cmbsort" name="cmbsort"  class="form-control selectpicker" aria-controls="sample_1">
                                        <option value="1">قدیمی تر</option>
                                        <option value="2">جدید تر</option>
                                    </select>
                                </div>


                                <a href="#" class="more"><svg class="olymp-three-dots-icon">
                                        <use xlink:href="#olymp-three-dots-icon"></use>
                                    </svg></a>

                            </div>

                        </div>
                    </form>
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

    </div>
</div>
<!-- /.content-wrapper -->


<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?php echo $HOST_NAME; ?>app/admin/scripts/comments.js"></script>