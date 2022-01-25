@extends('layout')

@section('content')
    <div id="container">
        <div id="center">
            <div id="content" class="clearfix">
                <div class="element-invisible"><a id="main-content"></a></div>
                <div class="region region-content">
                    <div id="block-system-main" class="block block-system">


                        <div class="content">
                            <div id="node-59" class="node node-page clearfix" about="/residential-strata" typeof="foaf:Document">


                                <span property="dc:title" content="Residential Strata" class="rdf-meta element-hidden"></span><span property="sioc:num_replies" content="0" datatype="xsd:integer" class="rdf-meta element-hidden"></span>

                                <div class="content">
                                </div>



                            </div>
                        </div>
                    </div>
                    <div id="block-strata-residential" class="block block-strata">


                        <div class="content">
                            <div id="mask" style="display: none;"></div><div id="boxes"></div>

                            <div id="dialog1" class="dialog hidden">
                                <p>Please enter correct email address.</p>
                                <br />
                                <p>Click <b>[OK]</b> to return to the form.</p>
                            </div>
                            <div id="dialog2" class="dialog hidden">
                                <p>Please fill in all mandatory fields marked with red border.</p>
                                <br />
                                <p>Click <b>[OK]</b> to return to the form.</p>
                            </div>
                            <div id="dialog3" class="dialog hidden">
                                <p>Only .doc, .docx, .txt, .rtf, .pdf, .jpg, .jpeg and.bmp extensions allowed.</p>
                                <br />
                                <p>Click <b>[OK]</b> to return to the form.</p>
                            </div>
                            <div id="dialog4" class="dialog hidden">
                                <p>File size should not exeed 10MB.</p>
                                <br />
                                <p>Click <b>[OK]</b> to return to the form.</p>
                            </div>
                            <div id="dialog5" class="dialog hidden">
                                <p>Download error.</p>
                                <br />
                                <p>Click <b>[OK]</b> to return to the form.</p>
                            </div>
                            <div id="dialog6" class="dialog hidden">
                                <p>Unfortunately we are not offering Common Property Stand alone cover.</p>
                                <br />
                                <p>Click <b>[OK]</b> to return to the form.</p>
                            </div>




                            <div>
                                <div id="lefthand">
                                    <ul>
                                        <li><a href="#" id="li0" class="ajax empty">Colonial strata insurance</a>
                                            <ul>
                                                <li><a href="#" id="li1" class="ajax li grey empty">Claims history</a></li>
                                                <li><a href="#" id="li2" class="ajax li grey empty">Situation</a></li>
                                                <li><a href="#" id="li3" class="ajax li grey empty">Risks</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <form method="post" id="retrieve">
                                        <div>
                                            <label>Enter Quote Number</label>
                                            <input type="text" name="quotenum">
                                        </div>
                                        <div>
                                            <label>Enter your email</label>
                                            <input type="text" name="quoteemail">
                                        </div>
                                        <input type="submit" value="Retrieve Quote" id="retrievesubmit">
                                    </form>
                                </div>
                                <div id="righthand">
                                    <form autocomplete="off">
                                        <div id="dynamic">
                                            <h2 class="h2" id="block0">Colonial strata insurance</h2>
                                            <fieldset class="top_level"><legend id="legend1">Policy details</legend>
                                                <div>
                                                    <div class="mandatory inline">
                                                        <label class="top">Policy period<span class="mandatory">*</span></label>
                                                        <input type="text" name="s01" id="s01" class="calendar element short" value="" readonly="readonly"><span class="to">to</span>
                                                    </div>
                                                    <div class="inline">
                                                        <input type="text" name="s02" id="s02" class="element short empty" value="" readonly="readonly">
                                                    </div>
                                                </div>
                                                <div class="s03 element-div mandatory" id="d-s03">
                                                    <label class="top">Who are you insured with<span class="mandatory">*</span></label>
                                                    <select class="selectOrOther" data-id="s03">
                                                        <option value="Please Select">Please Select</option>
                                                        <option value="AMP">AMP</option>
                                                        <option value="Allianz">Allianz</option>
                                                        <option value="CHU">CHU</option>
                                                        <option value="Calliden">Calliden</option>
                                                        <option value="Chubb">Chubb</option>
                                                        <option value="Lumley">Lumley</option>
                                                        <option value="None - previosly uninsured">None - previosly uninsured</option>
                                                        <option value="QBE">QBE</option>
                                                        <option value="SUU">SUU</option>
                                                        <option value="Vero">Vero</option>
                                                        <option value="Zurich">Zurich</option>
                                                        <option value="Other">Other – please provide details</option>
                                                    </select>
                                                    <div id="s03other" class="hidden">
                                                        <label class="otherLabel">Please specify</label>
                                                        <input type="text" class="other" value="" data-id="s03">
                                                    </div>
                                                    <input type="hidden" id="s03" name="s03" class="element empty" value="">
                                                </div>
                                                <div class="s0 element-div no" id="d-s0">
                                                    <label class="top">Is this insurance required for Common Property only?</label>
                                                    <label class="radio_yn">
                                                        <input class="radio_y radioYn" data-id="s0" type="radio" id="s0_yes" name="yns0" value="yes">Yes</label>
                                                    <label class="radio_yn">
                                                        <input class="radio_n radioYn" data-id="s0" type="radio" id="s0_no" name="yns0" value="no" checked="">No</label>
                                                    <input type="hidden" class="element" id="s0" name="s0" value="no">
                                                </div>
                                            </fieldset>
                                            <fieldset class="top_level"><legend id="legend1">Insured details</legend>
                                                <div class="mandatory">
                                                    <label class="top">SP or CTS or OC number<span class="mandatory">*</span></label>
                                                    <input type="text" name="s04" id="s04" value="" class="element empty">
                                                </div>
                                                <div class="mandatory">
                                                    <label class="top">Email<span class="mandatory">*</span></label>
                                                    <input type="text" name="s05" id="s05" value="" class="element empty">
                                                </div>
                                                <div class="mandatory">
                                                    <label class="top">Contact number<span class="mandatory">*</span></label>
                                                    <input type="text" name="s06" id="s06" value="" class="element empty">
                                                </div>
                                                <div class="mandatory">
                                                    <label class="top">Contact name<span class="mandatory">*</span></label>
                                                    <input type="text" name="s07" id="s07" value="" class="element empty">
                                                </div>
                                            </fieldset>
                                            <input type="hidden" class="lastblock" id="" value="0">
                                        </div>
                                        <a href="#" id="prev" class="nav ajax hidden">Prev</a>
                                        <a href="#" id="next" class="nav ajax">Next</a>
                                        <a href="#" id="submit" class="getquote hidden ajax"></a>
                                    </form>
                                </div>
                                <div class="clear"></div>
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
@endsection

@section('js')

{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/jquery/1.10/jquery.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/jquery-extend-3.4.0.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/jquery-html-prefilter-3.5.0-backport.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/jquery.once.js?v=1.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/drupal.js?r5zt2g"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.core.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.widget.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.datepicker.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/ui/jquery.ui.datepicker-1.13.0-backport.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/modules/locale/locale.datepicker.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.button.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.mouse.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.draggable.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.position.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/ui/jquery.ui.position-1.13.0-backport.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.resizable.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/jquery_update/replace/ui/ui/minified/jquery.ui.dialog.min.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/misc/ui/jquery.ui.dialog-1.13.0-backport.js?v=1.10.2"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/libraries/colorbox/jquery.colorbox-min.js?r5zt2g"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/colorbox/js/colorbox.js?r5zt2g"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/colorbox/styles/default/colorbox_style.js?r5zt2g"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/modules/custom/strata/js/residential.js?r5zt2g"></script>--}}
{{--    <script type="text/javascript" src="https://colonialstrata.com.au/sites/all/libraries/js/common.js?r5zt2g"></script>--}}
    <script src="{{ asset('js/jquery.ui.core.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.widget.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.datepicker.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.datepicker-1.13.0-backport.js') }}"></script>
{{--    <script src="{{ asset('js/locale.datepicker.js') }}"></script>--}}
<script src="{{ asset('js/jquery.ui.button.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.mouse.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.draggable.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.position.min.js') }}"></script>
<script src="{{ asset('js/jquery.ui.resizable.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.dialog.min.js') }}"></script>
    <script src="{{ asset('js/residential.js') }}"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.core.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.button.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.resizable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.ui.dialog.min.css') }}">
@endsection
