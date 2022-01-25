@extends('layout')

@section('content')
    <div id="container">
        <div id="center">
            <div id="content" class="clearfix">
                <div class="element-invisible"><a id="main-content"></a></div>
                <div class="region region-content">
                    <div id="block-system-main" class="block block-system">


                        <div class="content">
                            <div id="node-2" class="node node-page clearfix" about="/homepage" typeof="foaf:Document">


                                <span property="dc:title" content="Strata insurance"
                                      class="rdf-meta element-hidden"></span><span property="sioc:num_replies"
                                                                                   content="0" datatype="xsd:integer"
                                                                                   class="rdf-meta element-hidden"></span>

                                <div class="content">
                                    <div class="field field-name-body field-type-text-with-summary field-label-hidden">
                                        <div class="field-items">
                                            <div class="field-item even" property="content:encoded"><p><a
                                                        href="{{ route('residential') }}" id="hs"><img
                                                            alt="Residential Strata"
                                                            src="/images/res_strata.jpg"><span
                                                            class="getQuote"></span></a><a
                                                        href="{{ route('commercial-strata') }}"
                                                        id="cs"><img alt="Commercial Strata"
                                                                     src="/images/com_strata.jpg"><span
                                                            class="getQuote"></span></a></p>
                                                <div id="fronttext">
                                                    <h2>Strata Insurance</h2>
                                                    <div class="afterh2">
                                                        <p>Strata Insurance, that is also referred to as Body Corporate
                                                            insurance within some states, provides cover for the common
                                                            property that comes within the management of the strata
                                                            title to a shared property. Although the cost of providing
                                                            Strata Insurance is the responsibility of the strata title
                                                            owners the premium is normally divided between the
                                                            individual unit owners and added to their strata fees. It is
                                                            a legal requirement that strata title owners have Strata
                                                            Insurance in place.</p>
                                                        <p>As a body corporate you will, quite rightly, be seeking the
                                                            <strong>most suitable Strata Insurance that provides exactly
                                                                the cover that you and the unit owners require</strong>
                                                            to provide complete peace of mind but that is also <strong>good
                                                                value for money</strong>. Here at Colonial Insurance,
                                                            our experienced and knowledgeable team can provide a
                                                            tailor-made competitive Residential Strata Insurance
                                                            quotation from our extensive panel of insurance companies
                                                            for your consideration.</p>
                                                        <p>These insurance companies, subject to underwriting, are able
                                                            to provide the option of cover in the event of flooding.
                                                            Owners Corporate Committees will also be reassured to read
                                                            that we can arrange cover with no limitation on the sum
                                                            insured for the building. Furthermore, both you and the unit
                                                            holders will be pleased to note that <strong>Colonial
                                                                Insurance will rebate 50% of the commission to
                                                                you</strong> through a reduction in your premium thus,
                                                            probably, providing you with a significant saving.</p>
                                                        <p>All you need to do is to spend a couple of minutes completing
                                                            our online quotation form and we will do the rest. This will
                                                            save you having to spend hours of your valuable time
                                                            researching various insurance companies that provide Strata
                                                            Insurance and obtaining individual quotations.
                                                            Alternatively, you can e-mail or send us a fax enclosing a
                                                            copy of your existing Strata Insurance policy schedule
                                                            enabling us to obtain, on your behalf, a comparable
                                                            competitive quotation for your perusal.</p>
                                                        <p>Assuming that you are pleased with the quotation, we can
                                                            arrange to place you on risk as quickly as is required.
                                                            Furthermore, the insurance companies that we use allow you
                                                            to pay either monthly or annually for the cover that is a
                                                            useful option if your strata fund does not have sufficient
                                                            funds to meet the annual cost upfront.</p>
                                                        <p>We very much look forward to hearing from you.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="right">
            <div class="region region-sidebar-right">
                <div id="block-block-1" class="block block-block">


                    <div class="content">
                        <p><a href="https://colonialstrata.com.au/contact-us"><img alt="Contact Us"
                                                                                   src="/images/callback.jpg"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
@endsection
