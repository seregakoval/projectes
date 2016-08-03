<style type="text/css" media="all">

<?php if(of_get_option('headingfontlink') != '' and of_get_option('headingfontface') != '') { ?>
    h1,h2,h3,h4,h5,h6, .h1_description {
    <?php echo of_get_option('headingfontface');?>
    }
<?php } ?>

<?php if(of_get_option('bodyfontlink') != '' and of_get_option('bodyfontface') != '') { ?>
    body, input, textarea {
    <?php echo of_get_option('bodyfontface');?>
    }
<?php } ?>
</style>