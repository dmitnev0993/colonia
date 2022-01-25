@extends('layout')

@section('content')
    @if(session('success'))
        <div id="container">
            <div id="center">
                <div id="content" class="clearfix">
                    <div class="element-invisible"><a id="main-content"></a></div>
                    <div class="region region-content">
                        <div id="block-system-main" class="block block-system">


                            <div class="content">
                                <div id="node-23" class="node node-special clearfix" about="/contact-us" typeof="sioc:Item foaf:Document">


                                    <h1>Contact us</h1>
                                    <span property="dc:title" content="Contact us" class="rdf-meta element-hidden"></span><span property="sioc:num_replies" content="0" datatype="xsd:integer" class="rdf-meta element-hidden"></span>

                                    <div class="content">
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div id="block-callback-callback" class="block block-callback">


                            <div class="content">

                                <h2>Thank you, your submission has been received.</h2><form action="/contact-us" method="post" id="callback-form" accept-charset="UTF-8"><div><input type="hidden" name="form_build_id" value="form-8771ySRNVTQv4PZBaqUzEdLKYsRHHRS2Y2ubaE-_Wcs">
                                        <input type="hidden" name="form_id" value="callback_form">
                                    </div></form>
                                <div class="addresses">
                                    <p><strong>Our Business Hours</strong><br>Monday - Friday 9am to 5pm<br>Saturday &amp; Sunday - Closed</p>
                                    <p>Our postal address: Colonial Insurance Pty Ltd, PO Box A2202 Sydney South NSW 1235<br>Our head office address: Colonial Insurance Pty Ltd, 183 Kent St Sydney NSW 2000</p>
                                </div>  </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="right">
                <div class="region region-sidebar-right">
                    <div id="block-block-1" class="block block-block">


                        <div class="content">
                            <p><a href="/contact-us"><img alt="Contact Us" src="/images/callback.jpg"></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    @else
        <div id="container">
            <div id="center">
                <div id="content" class="clearfix">
                    <div class="element-invisible"><a id="main-content"></a></div>
                    <div class="region region-content">
                        <div id="block-system-main" class="block block-system">


                            <div class="content">
                                <div id="node-23" class="node node-special clearfix" about="/contact-us" typeof="sioc:Item foaf:Document">


                                    <h1>Contact us</h1>
                                    <span property="dc:title" content="Contact us" class="rdf-meta element-hidden"></span><span property="sioc:num_replies" content="0" datatype="xsd:integer" class="rdf-meta element-hidden"></span>

                                    <div class="content">
                                    </div>



                                </div>
                            </div>
                        </div>
                        <div id="block-callback-callback" class="block block-callback">


                            <div class="content">
                                <form action="/contact-us" method="post" id="callback-form" accept-charset="UTF-8"><div><input type="hidden" name="recapcha_response" value="">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="form_build_id" value="form-98zbSum5gl6KeJGLXCWmXAYQVb8fU0kxj8NKfk70kow">
                                        <input type="hidden" name="form_id" value="callback_form">
                                        <div class="form-item form-type-textfield form-item-name">
                                            <label for="edit-name">Your Name <span class="form-required" title="This field is required.">*</span></label>
                                            <input type="text" id="edit-name" name="name" value="" size="60" maxlength="128" class="form-text required">
                                        </div>
                                        <div class="form-item form-type-textfield form-item-phone">
                                            <label for="edit-phone">Your Phone Number <span class="form-required" title="This field is required.">*</span></label>
                                            <input type="text" id="edit-phone" name="phone" value="" size="60" maxlength="128" class="form-text required">
                                        </div>
                                        <div class="form-item form-type-textfield form-item-email">
                                            <label for="edit-email">E-mail <span class="form-required" title="This field is required.">*</span></label>
                                            <input type="text" id="edit-email" name="email" value="" size="60" maxlength="128" class="form-text required">
                                        </div>
                                        <div class="form-item form-type-select form-item-state">
                                            <label for="edit-state">State <span class="form-required" title="This field is required.">*</span></label>
                                            <select id="edit-state" name="state" class="form-select required"><option value="" selected="selected">Please Select</option><option value="NSW">NSW</option><option value="QLD">QLD</option><option value="SA">SA</option><option value="TAS">TAS</option><option value="VIC">VIC</option><option value="WA">WA</option><option value="NT">NT</option><option value="ACT">ACT</option></select>
                                        </div>
                                        <div class="form-item form-type-textarea form-item-message">
                                            <label for="edit-message">Your Message </label>
                                            <div class="form-textarea-wrapper"><textarea id="edit-message" name="message" cols="60" rows="5" class="form-textarea"></textarea></div>
                                        </div>
                                        <div><label></label><div class="form-textarea-wrapper recapcha-wrapper"><div class="g-recaptcha" data-sitekey="6Lda4hQTAAAAANO4EB1OKRsVqpUglpTw3Tz56GZY" style="max-width:100%;overflow: hidden;"><div style="width: 304px; height: 78px;"><div><iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6Lda4hQTAAAAANO4EB1OKRsVqpUglpTw3Tz56GZY&amp;co=aHR0cHM6Ly9jb2xvbmlhbHN0cmF0YS5jb20uYXU6NDQz&amp;hl=ru&amp;v=TDBxTlSsKAUm3tSIa0fwIqNu&amp;size=normal&amp;cb=e1tjql313zql" width="304" height="78" role="presentation" name="a-ws0ldy9fp9b8" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea></div><iframe style="display: none;"></iframe></div></div></div><input type="submit" id="edit-submit" name="op" value="Request a callback" class="form-submit"></div></form>  </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="right">
                <div class="region region-sidebar-right">
                    <div id="block-block-1" class="block block-block">


                        <div class="content">
                            <p><a href="/contact-us"><img alt="Contact Us" src="/images/callback.jpg"></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    @endif
@endsection
