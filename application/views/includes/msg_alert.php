<?php
/**
 * Created by PhpStorm.
 * User: abhishek
 * Date: 7/2/15
 * Time: 3:08 PM
 */

/*printArray(getSessionFlashData('error'),1);*/
?>
<style type="text/css">
    .fade:not(.show) {
    opacity: 1!important;
}
</style>
<?php
if (strlen(getSessionFlashData('success')) > 0 || strlen(getSessionFlashData('error')) > 0 || strlen(getSessionFlashData('info')) > 0 || strlen(getSessionFlashData('warning')) > 0) {
    ?>
    <div class="wrapper-md errorBlock" id="errorBlock">
        <div class="row">
            <div class="col-lg-12" style="">
                <?php
                if (strlen(getSessionFlashData('error')) > 0) {
                    ?>
                    <div class="alert alert-block alert-danger fade in">
                        <a class="close fa fa-times" data-dismiss="errorBlock" onclick="hideSuccessOrWarningMessage()" aria-hidden="true"></a>
                            <?php
                            echo getSessionFlashData('error');
                            ?>
                    </div>
                    <?php
                } ?>

                <?php
                if (strlen(getSessionFlashData('success')) > 0) {
                    ?>
                    <div class="alert alert-block alert-success fade in">
                        <a class="close fa fa-times" data-dismiss="errorBlock" onclick="hideSuccessOrWarningMessage()" aria-hidden="true"></a>
                            <?php
                            echo getSessionFlashData('success');
                            ?>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
    </div>
    <?php
}

?>
<script type="text/javascript">
    //hide a div after 3 seconds
    <?php
    $class = $this->router->fetch_class();
    $method = $this->router->fetch_method();
    if($class != 'leads' && $method != 'importcsv'){?>
    setTimeout('$("#errorBlock").fadeOut();', 4000);
    <?php } ?>

    //hiding the message which is come after every succes of failed operation
    function hideSuccessOrWarningMessage()  
    {
        $("#errorBlock").fadeOut();
    }
</script>