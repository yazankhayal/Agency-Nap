<div class="ho-section newsletter-area bg-grey ptb-50">
    <div class="container">
        <div class="newsletter">
            <div class="newsletter-title">
                <h2>{{$lang->Subscribe_desc}} <span>{{$lang->Our_Newsletter}}!</span></h2>

            </div>
            <div class="newsletter-content">
                <form method="POST" action="{{route('newsletter')}}" data-name="newsletter2"
                      class="newsletter2 ajaxForm newsletter-form">
                    {{csrf_field()}}
                    <input id="email" name="email" type="email" placeholder="{{$lang->Email}}">
                    <button type="submit">{{$lang->Subscribe}}</button>
                </form>
                <!-- mailchimp-alerts start -->
                <div class="mailchimp-alerts text-centre">
                    <div class="mailchimp-submitting"></div><!-- mailchimp-submitting end -->
                    <div class="mailchimp-success"></div><!-- mailchimp-success end -->
                    <div class="mailchimp-error"></div><!-- mailchimp-error end -->
                </div><!-- mailchimp-alerts end -->
            </div>
            <div class="newsletter-socialicons socialicons socialicons-radial">
                <ul>
                    @if($hp_contact->facebook != null)
                        <li>
                            <a href="{{$hp_contact->facebook}}">
                                <i class="ion ion-logo-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if($hp_contact->twitter != null)
                        <li>
                            <a href="{{$hp_contact->twitter}}">
                                <i class="ion ion-logo-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if($hp_contact->instagram != null)
                        <li>
                            <a href="{{$hp_contact->instagram}}">
                                <i class="ion ion-logo-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if($hp_contact->pinterest != null)
                        <li>
                            <a href="{{$hp_contact->pinterest}}" target="_blank">
                                <i class="ion ion-logo-youtube" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
