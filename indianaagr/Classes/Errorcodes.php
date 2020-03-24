<?php
 namespace Classes;
    
 final class Errorcodes {
            public $errorlist  =   array(
                "contact_us" => array
                (
                    "invalid_name"     => "Please enter name",
                    "invalid_email"    => "Please enter email address",
                    "invalid_mobileno" => "Please enter mobile number",
                    "invalid_comment"  => "Please enter your query",
                    "invalid_subject"  => "Please enter subject", 
                    "success"          => "Your enquiry is submited successfully!!",
                    "invalid"          => "Your enquiry is not submitted, please try angin",
                    "email_failed"     => "Failed to sending email please try again"
                ),
                "testimonial" => array
                (
                    "invalid_name"     => "Please enter name",
                    "invalid_email"    => "Please enter email address" ,
                    "invalid_contryid" => "Please select country" ,
                    "invalid_comment"  => "Please enter your query" ,
                    "success"          => "Your Feedback is submited successfully!!",
                    "invalid"          => "Your feedback is not submited please try angin",
                ),
                "subscription"=> array
                (
                    "invalid_email" => "Please enter valid email address",
                    "success"       => "You have successfully subscribe.",
                    "already_exists"=> "Email address is already subscibed please enter another email address",
                    "invalid"       => "Failed to sending email Please try again",
                ),
                "forgot_password"=> array
                (
                    "success"      => "Your password is send on registred email address please check your email",
                    "not_exist"    => "Email address is not registered with us.",
                    "invalid"      => "Please enter valid email address",
                    "invalid_email"=> "Please enter email address",
                ),
                "change_password"=> array
                (
                    "invalid-old-password" => "Please enter old password",
                    "invalid-password"     => "Please enter new password",
                    "invalid-confirm-password" => "Please enter confirm password",
                    "invalid-password-match" => "Password does not match the confirm password",
                    "invalid"               => "Please enter valid information",
                    "incomplete"            => "Please enter valid password",
                    "success"               => "Your password is changed successfully",
                    "nomatch"               => "Please enter correct current password",
                ),
                "edit_profile" => array
                (
                    "invalid-firstname"=> "Please enter first name",
                    "invalid-lastname" => "Please enter lastname",
                    "invalid-address"  => "Please enter address",
                    "invalid-state"    => "Please enter state",
                    "invalid-city"     => "Please enter city",
                    "invalid-zip"      => "Please enter zip code",
                    "success"          => "Your profile is updated successfully",
                    "Invalid"          => "Failed in updating your profile, please try again",
                ),
                "login" => array
                (
                    "invalid_email"   => "Please enter valid email address",
                    "email_not_exist" => "Email address is not registered with us",
                    "invalid_password"=> "Invalid password try again",
                    "wrong_password"  => "Invalid password ",
                    "account_unverified" => "Your account is not verified yet. Please contact administrator"
                ),
                "register" =>array
                (
                    "invalid-email"     => "Please enter a valid email id",
                    "already-exists"    => "Your email address already exists in our website. Please enter another email address or sign in as an Orientique stockist.",
                    "invalid-password"  => "Please enter password.",
                    "invalid-confirm-password" => "Please enter confirm password",
                    "invalid-password-match" => "Password does not match the confirm password",
                    "invalid-first-name" => "Please enter firstname",
                    "invalid-last-name"  => "Please enter lastname",
                    "invalid-address"   => "Please enter address",
                    "invalid-state"     => "please enter state",
                    "invalid-city"      => "Please enter city name",
                    "invalid-zip"       => "Please enter pin code number",
                    "invalid-phone"     => "Please enter phone number",
                    "invalid-company-name" => "Please enter company name",
                    "invalid-business-number" => "Please enter register business number",
                    "success"           => "You are successfully registered. Thank you for registered with us.",
                    "invalid"           => "Failed to register, please try again"
                ),
                "coupon" => array
                (
                    "no_redeem_allow" => "Your coupon redeem is not allow",
                    "min_amount"      => "Your order total amount is less then coupon minimum amount ",
                    "expire_date"     => "Please confirm coupon starting and expiry date",
                    "invalid_coupon"  => "You entered invalid coupon code please try again",
                    "success"         => "Your coupon is apply successfully.",
                    
                ),
                "checkout" => array
                (
                    "invalid_email"    => "Invalid email address." ,
                    "email_exist"      => "You are already registered with us, please login.",
                    "invalid_billing"  => "Please enter valid billing information",
                    "invalid_shipping" => "Please enter valid shipping information",
                    "incomplete"       => "Please fill all the required information",
                    "invalid"          => "Please fill valid information" ,
                    
                    "invalid_billingemail"     => "Please fill valid billing email address",
                    "invalid_billingpassword"  => "Please fill valid billing password",
                    "invalid_billingfirstname" => "Please fill valid billing firstname",
                    "invalid_billinglastname"  => "Please fill valid billing lastname",
                    "invalid_billingphone"     => "Please fill valid billing phone",
                    "invalid_billingcity"      => "Please fill valid billing city",
                    "invalid_billingzip"       => "Please fill valid billing zip",
                    "invalid_billingaddress1"  => "Please fill valid billing address line 1",
                    "invalid_billingaddress2"  => "Please fill valid billing address line 2",
                    "invalid_shippingfirstname"=> "Please fill valid shipping firstname",
                    "invalid_shippinglastname" => "Please fill valid shipping lastname",
                    "invalid_shippingphone"    => "Please fill valid shipping phone",
                    "invalid_shippingcity"     => "Please fill valid shipping city",
                    "invalid_shippingzip"      => "Please fill valid shipping zip",
                    "invalid_shippingaddress1" => "Please fill valid shipping address line 1",
                    "invalid_shippingaddress2" => "Please fill valid shipping address line 2",
                    "invalid_deliverypincode"  => 'Delivery not allowed in this pincode/area'

                ),
                "create_sub_partner" => array
                (
                    "invalid-name"       => "Please fill valid name",
                    "invalid-email"      => "Please fill valid email",
                    "invalid-partnerid"  => "Please fill valid partnerid",
                    "invalid-status"     => "Please fill valid status",
                    "success"            => "Partner profile added successfully",
                    "invalid"            => "Please fill valid information",
                    "update"             => "Partner profile updated successfully",
                    "already-email"      => "The email address is already exist please enter another email address",
                    "already-partnerid"  => "The partner id is already exist please enter another partner id.",
                ),
                "partner_profile"  => array
                (
                    "invalid-name"       => "Please fill valid  name",
                    "invalid-email"      => "Please fill valid email",
                    "invalid-partnerid"  => "Please fill valid partnerid",
                    "invalid-status"     => "Please fill valid status",
                    "success"            => "Partner profile successfully updated",
                    "invalid"            => "Please fill valid information",
                    "already-email"      => "The email address is already exist please enter another email address",
                    "already-partnerid"  => "The partner id is already exist please enter another partner id.",
                ),
                "billing_shipping" => array
                (
                    "invalid" => "Please fill valid information", 
                    "invalid_first_name" => "Please enter valid first name",
                    "invalid_last_name" => "Please enter valid last name",
                    "invalid_email" => "Please enter valid email",
                    "invalid_mobileno" => "Please enter valid mobile no",
                    "invalid_address" => "Please enter valid address",
                    "invalid_postal_code" => "Please enter valid postal code",
                    "invalid_address" => "Please enter valid addcress",
                    "success" => "Billing / Shipping information updated successfully",
                ),
                "newsletter_subscription" => array
                (
                    "invalid" => "Please fill valid information.", 
                    "invalid_email" => "Please enter valid email address.",
                    "unsubscribe" => "You are successfully unsubscribed for newsletter.",
                    "subscribe" => "You are successfully subscribed for newsletter.",
                    "already_subscribe" => "You are already subscribed for our newlsletters and updates."
                )
            );
    }
?>