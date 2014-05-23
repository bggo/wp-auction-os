jQuery(document).ready(
                       function()
                       {
                            jQuery("#auction-settings-form").submit(
                            function(){
                            var pm = jQuery("#auction-settings-form #wdm_paypal_id").val();
                            var wm = jQuery("#auction-settings-form #wdm_wire_transfer_id").val();
                            var mm = jQuery("#auction-settings-form #wdm_mailing_id").val();
                            
                            if(pm == '' && wm == '' && mm == '')
                            {
                                alert("You should fill data for atleast one payment method.");
                                return false;
                            }
                                return true;
                            }
                            );
                            jQuery("#wdm-add-auction-form").submit(
                            function(){
                                
                            var bn = new Number;
                            var ob = new Number;
                            var lb = new Number;
                            var inc = new Number;
                            var tl,ds,edt;
                            
                            tl = jQuery("#wdm-add-auction-form #auction_title").val();
                            ds = jQuery("#wdm-add-auction-form #auction_description").val();
                            bn = jQuery("#wdm-add-auction-form #buy_it_now_price").val();
                            ob = jQuery("#wdm-add-auction-form #opening_bid").val();
                            lb = jQuery("#wdm-add-auction-form #lowest_bid").val();
                            inc = jQuery("#wdm-add-auction-form #incremental_value").val();
                            edt = jQuery("#wdm-add-auction-form #end_date").val();
                            
                            var pd = jQuery("#payment_method #wdm_method_paypal").attr("disabled");
                            
                            if(!tl)
                            {
                                    alert("Please enter Product Title.");
                                    return false; 
                            }
                            
                            if(!ds)
                            {
                                    alert("Please enter Product Description.");
                                    return false; 
                            }
                            
                            if(!edt)
                            {
                                    alert("Please enter Ending Date/Time.");
                                    return false; 
                            }
                            
                            if(pd == 'disabled')
                            {
                                if(bn)
                                {
                                    alert("You should fill PayPal email address in 'Settings' tab to enable 'Buy Now' feature.");
                                    jQuery("#wdm-add-auction-form #buy_it_now_price").val("");
                                    return false;
                                }
                                
                                if(!ob)
                                {
                                    alert("Please enter Opening Bid amount.");
                                    return false;
                                }
                                
                                if(!lb)
                                {
                                    alert("Please enter Lowest Price (Reserve Price).");
                                    return false;
                                }
                                
                            }
                            else
                            {
                                if(!ob && !bn)
                                {
                                    alert("Please enter either Opening Bid amount or Buy Now price.");
                                    return false;
                                }
                                
                                if(ob && !lb)
                                {
                                    alert("You have entered Opening Bid. Please also enter Lowest Price (Reserve Price).");
                                    return false;
                                }
                                
                                if(lb && !ob)
                                {
                                    alert("You have entered Lowest Price. Please also enter Opening Bid amount.");
                                    return false;
                                }
                                
                                if(inc && !ob)
                                {
                                    alert("You have entered Incremental Value. Please also enter Opening Bid amount.");
                                    return false;
                                }
                            }
                                if(Number(lb) < Number(ob))
                                {
                                    alert("Lowest/Reserve price should be more than or equal to Opening Bid.");
                                    return false;
                                }
                                
                                if(bn)
                                {
                                   if(Number(bn) < Number(lb))
                                   {
                                        alert("Buy Now price should be more than or equal to Lowest/Reserve price.");
                                        return false;
                                   }
                                }
                                return true;
                            }
                            );
                            
                       }
                       );