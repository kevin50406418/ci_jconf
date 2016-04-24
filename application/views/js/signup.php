<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script>
$(function() {
    $(".chosen-select").chosen({
        no_results_text:"找不到國家"
    });
    $("#addr_6").twzipcode({
        css:[ "form-control", "form-control", "form-control" ],
        zipcodeName:"user_postcode",
        countyName:"user_addcounty",
        districtName:"user_area"
    });
    $("#register").validate({
        rules:{
            user_id:{
                required:true
            },
            user_pw:{
                required:true,
                minlength:6
            },
            user_pw2:{
                required:true,
                minlength:6,
                equalTo:"#user_pw"
            },
            user_firstname:{
                required:true
            },
            user_lastname:{
                required:true
            },
            user_org:{
                required:true,
                maxlength:40
            },
            user_email:{
                required:true,
                email:true
            },
            user_phoneO:{
                required:true,
            },
            user_phoneext:{
                maxlength:10,
                number:true
            },
            user_postcode:{
                required:true,
                minlength:3,
                number:true
            },
            user_postadd:{
                required:true,
                maxlength:80
            },
            user_cellphone:{
                maxlength:13
            },
            user_research:{
                required:true,
                minlength:4
            }
        },
        messages:{
            user_id:{
                required:"<?php echo lang('user_id_required')?>"
            },
            user_pw:{
                required:"<?php echo lang('user_pw_required')?>",
                minlength:"<?php echo lang('user_pw_minlength')?>"
            },
            user_pw2:{
                required:"<?php echo lang('user_pw2_required')?>",
                minlength:"<?php echo lang('user_pw2_minlength')?>",
                equalTo:"<?php echo lang('user_pw2_equalTo')?>"
            },
            user_firstname:{
                required:"<?php echo lang('user_firstname_required')?>"
            },
            user_lastname:{
                required:"<?php echo lang('user_lastname_required')?>"
            },
            user_org:"<?php echo lang('user_org_required')?>",
            user_email:{
                required:"<?php echo lang('user_email_required')?>",
                email:"<?php echo lang('user_email_email')?>"
            },
            user_phoneO:{
                required:"<?php echo lang('user_phoneO_required')?>",
                number:"<?php echo lang('user_phoneO_number')?>"
            },
            user_phoneext:{
                maxlength:"<?php echo lang('user_phoneO_3_maxlength')?>",
                number:"<?php echo lang('user_phoneO_3_number')?>"
            },
            user_postcode:{
                required:"<?php echo lang('user_postcode_required')?>",
                minlength:"<?php echo lang('user_postcode_minlength')?>",
                number:"<?php echo lang('user_postcode_number')?>"
            },
            user_postadd:{
                required:"<?php echo lang('user_postadd_required')?>",
                maxlength:"<?php echo lang('user_postadd_maxlength')?>"
            },
            user_cellphone:{
                maxlength:"<?php echo lang('user_cellphone_maxlength')?>",
                number:"<?php echo lang('user_cellphone_number')?>"
            },
            user_research:{
                required:"<?php echo lang('user_research_required')?>",
                minlength:"<?php echo lang('user_research_minlength')?>"
            }
        },
        highlight:function(element) {
            $(element).closest(".form-group").addClass("has-error");
        },
        unhighlight:function(element) {
            $(element).closest(".form-group").removeClass("has-error");
        },
        errorElement:"span",
        errorClass:"help-block",
        errorPlacement:function(error, element) {
            if (element.parent(".input-group").length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
});</script>
