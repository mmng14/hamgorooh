<style>
    .user-photo {
        width: 130px;
    }

    .author-thumb img {
        max-width: 50px;
    }

    .chat-message-item-current {
        background-color: #7c5ac2;
        color: #fff;
        float: left;
        direction: ltr;
    }

    .chat-message-item {
        padding: 13px;
        background-color: #f0f4f9;
        margin-top: 0;
        border-radius: 10px;
        margin-bottom: 5px;
        font-size: 12px;
    }

    .chat-others-li {
        text-align: right;
        direction: ltr;
        margin-right: 20px
    }

    .chat-others-div {
        direction: ltr;
    }

    .chat-others-span {
        margin-right: 25px;
        background: #7c5ac2;
        color: #f0f4f9;
    }

    .chat-message-field .notification-event {
        width: 90% !important;
    }
</style>



<div class="main-header">
    <div class="content-bg-wrap bg-group"></div>
    <div class="container">
        <div class="row">
            <div class="col col-lg-8 m-auto col-md-8 col-sm-12 col-12">
                <div class="main-header-content">
                    <h3>اعلانهای من</h1>
                </div>
            </div>
        </div>
    </div>
    <!--
	<img class="img-bottom" src="img/group-bottom.png" alt="friends"> -->

</div>

<div class="container">
            <div class="row">
                <div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <!-- Tab panes -->
                    <input type="hidden" id="_csrf" name="_csrf" value="<?php echo $_csrf; ?>" />
                    <div class="ui-block responsive-flex" id="results">
                        <div class="loading-div" id="loader"></div>
                    </div>
                </div>
            </div>
        </div>


<!-- ... end Your Account Personal Information -->


<script>
    var HOST_NAME = "<?php echo $HOST_NAME;  ?>";
</script>
<script src="<?= $HOST_NAME  ?>app/users/scripts/notifications.js"></script>