<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    @include('admin.stylesheet')
</head>

<body>
    
    @include('admin.navigation')

    <!-- Right Panel -->
    @if(in_array('etemplate',$avilable))
    <div id="right-panel" class="right-panel">

        
                       @include('admin.header')
                       

        <div class="breadcrumbs">
            <div class="col-sm-8">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{{ __('Edit Email Template') }} - {{ $edit['template']->et_heading }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <a href="{{ url('/admin/email-template') }}" class="btn btn-success btn-sm"><i class="fa fa-arrow-circle-left"></i> {{ __('Back') }}</a>
                        </ol>
                    </div>
                </div>
            </div>
            
        </div>
        
        @include('admin.warning')
        
        
        <div class="content mt-3">
            <div class="animated fadeIn">
            
                <div class="row">
                
                    <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title" v-if="headerText">{{ __('Short Code') }}</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-hover table-striped table-align-middle mb-0 edit-template">
                                <tbody>
                                    <?php /* Comment */ ?>
                                    @if($et_id == 2)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Sender Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Sender Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Url') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{comm_text}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Comment') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Contact Us */ ?>
                                    @if($et_id == 3)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{message_text}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Message') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Forget Password */ ?>
                                    @if($et_id == 4)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{forgot_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Reset Password') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Newsletter Signup */ ?>
                                    @if($et_id == 6)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{activate_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Newsletter') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Product Rating & Reviews */ ?>
                                    @if($et_id == 7)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{rating}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Rating') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{rating_reason}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Rating Reason') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{rating_comment}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Comment') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Url') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Refund Request Received */ ?>
                                    @if($et_id == 8)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{ref_refund_reason}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Refund Reason') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{ref_refund_comment}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Comment') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Url') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* New Signup Email Verification */ ?>
                                    @if($et_id == 9)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{register_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Verify Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Your registered email-id is') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Contact Support */ ?>
                                    @if($et_id == 10)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{support_subject}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Subject') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{support_msg}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Message') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Url') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Payment Refund Declined */ ?>
                                    @if($et_id == 11)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{price}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Amount') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{currency}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Currency Symbol') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Payment Refund Accepted */ ?>
                                    @if($et_id == 13)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{price}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Amount') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{currency}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Currency Symbol') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Item Update Notifications */ ?>
                                    @if($et_id == 15)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Url') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Newsletter Updates */ ?>
                                    @if($et_id == 16)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{news_heading}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Subject') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{news_content}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Content') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Payment Withdrawal Request Accepted */ ?>
                                    @if($et_id == 17)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{wd_amount}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Withdraw Amount') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{currency}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Currency Symbol') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Subscription Upgrade */ ?>
                                    @if($et_id == 20)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{user_subscr_type}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Pack Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{subscr_date}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Date') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{subscri_date}}') @endphp
                                        </td>
                                        
                                        <td>
                                           {{ __('Duration') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{currency}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Currency Symbol') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{subscr_price}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Price') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Item Purchase Notifications */ ?>
                                    @if($et_id == 21)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{final_amount}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Amount') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{currency}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Currency Symbol') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{purchased_token}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Order Id') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{download_file}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Download File') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Subscription Renewal Notifications */ ?>
                                    @if($et_id == 23)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{expired_date}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Expire On') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{pack_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Pack Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{subscription_url}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Subscription Url') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Item Report Notifications */ ?>
                                    @if($et_id == 24)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{product_slug}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Product Url') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{report_issue_type}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Issue Type') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{report_subject}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Subject') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{report_message}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Message') }}
                                        </td>
                                    </tr>
                                    <?php /* Redeem Voucher Notifications */ ?>
                                    @endif
                                    @if($et_id == 25)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{voucher_code}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Voucher Code') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{credits}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Credits') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{currency}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Currency Code') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* New Ticket Received */ ?>
                                    @if($et_id == 26)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{ticket_token}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Ticket ID') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{ticket_subject}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Subject') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{ticket_priority}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Priority') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{ticket_message}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Message') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Ticket Replied By Customer */ ?>
                                    @if($et_id == 27)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{tickets_token}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Ticket ID') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{tickets_message}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Reply Message') }}
                                        </td>
                                    </tr>
                                    @endif
                                    <?php /* Ticket Replied By Admin */ ?>
                                    @if($et_id == 28)
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_name}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Name') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{from_email}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Email') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{tickets_token}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Ticket ID') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @php echo htmlentities('{{tickets_message}}') @endphp
                                        </td>
                                        
                                        <td>
                                            {{ __('Reply Message') }}
                                        </td>
                                    </tr>
                                    @endif
                                  </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                    <div class="col-md-12">
                       
                        
                        
                      
                        <div class="card">
                           @if($demo_mode == 'on')
                           @include('admin.demo-mode')
                           @else
                            <form action="{{ route('admin.edit-email-template') }}" method="post" id="setting_form" enctype="multipart/form-data">
                           {{ csrf_field() }}
                           @endif
                          
                           <div class="col-md-12">
                           
                            <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                           
                                       <div class="form-group">
                                          <label for="site_logo" class="control-label mb-1">{{ __('Subject') }} <span class="require">*</span></label>
                                                
                                            <input type="text" id="et_subject" name="et_subject" class="form-control"  value="{{ $edit['template']->et_subject }}"  data-bvalidator="required" >
                                            
                                            </div>
                                            
                                    </div>
                                </div>

                            </div>
                            </div>
                            
                            
                            
                             <div class="col-md-6" style="display:none;">
                             
                             
                             <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                             <input type="hidden" name="et_status" value="1">
                             
                                          
                                        
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
                             
                             <div class="col-md-12">
                             
                             
                             <div class="card-body">
                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                             
                                           
                                                
                                            <div class="form-group">
                                                <label for="site_title" class="control-label mb-1">{{ __('Message') }} <span class="require">*</span></label>
                                                <textarea name="et_content" id="summary-ckeditor" rows="6" class="form-control" data-bvalidator="required">{{ html_entity_decode($edit['template']->et_content) }}</textarea>
                                            </div> 
                                            
                                           <input type="hidden" name="et_id" value="{{ $et_id }}">
                             
                             
                             </div>
                                </div>

                            </div>
                             
                             
                             
                             </div>
                             
                             <div class="col-md-12 no-padding">
                             <div class="card-footer">
                                  <button type="submit" name="submit" class="btn btn-primary btn-sm">
                                     <i class="fa fa-dot-circle-o"></i> {{ __('Submit') }}
                                  </button>
                                  <button type="reset" class="btn btn-danger btn-sm">
                                      <i class="fa fa-ban"></i> {{ __('Reset') }}
                                  </button>
                             </div>
                            </div>
                             
                            
                            </form>
                            
                                                    
                                                    
                                                 
                            
                        </div> 

                     
                    
                    
                    </div>
                    

                </div>
            </div><!-- .animated -->
        </div>
        
        
        <!-- .content -->


    </div><!-- /#right-panel -->
    @else
    @include('admin.denied')
    @endif
    <!-- Right Panel -->


   @include('admin.javascript')


</body>

</html>
