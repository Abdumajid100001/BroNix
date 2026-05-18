<footer id="footer" class="footer bnx-footer">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="bnx-footer__brand">
                    <span class="bnx-brand__mark">B</span>
                    <span>
                        <strong>{{ __('messages.site.app_name') }}</strong>
                        <small>{{ __('messages.common.free_platform') }}</small>
                    </span>
                </a>
                <p class="bnx-footer__text">{{ __('messages.footer.description') }}</p>
            </div>

            <div class="col-sm-6 col-lg-2">
                <h4>{{ __('messages.footer.nav_title') }}</h4>
                <ul class="bnx-footer__links">
                    <li><a href="{{ request()->routeIs('home') ? '#hero' : route('home') . '#hero' }}">{{ __('messages.common.home') }}</a></li>
                    <li><a href="{{ route('business.page') }}">{{ __('messages.common.businesses') }}</a></li>
                    <li><a href="{{ route('booking.page') }}">{{ __('messages.common.booking') }}</a></li>
                    <li><a href="{{ request()->routeIs('home') ? '#contact' : route('home') . '#contact' }}">{{ __('messages.common.contacts') }}</a></li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-3">
                <h4>{{ __('messages.footer.assistant_title') }}</h4>
                <ul class="bnx-footer__links">
                    <li><button type="button" class="bnx-footer__button" data-bnx-open-assistant>{{ __('messages.footer.assistant_budget') }}</button></li>
                    <li><button type="button" class="bnx-footer__button" data-bnx-prompt="{{ __('messages.prompts.popular_salons') }}">{{ __('messages.footer.assistant_popular') }}</button></li>
                    <li><button type="button" class="bnx-footer__button" data-bnx-prompt="{{ __('messages.prompts.good_schedule') }}">{{ __('messages.footer.assistant_affordable') }}</button></li>
                </ul>
            </div>

            <div class="col-lg-3">
                <h4>{{ __('messages.footer.owners_title') }}</h4>
                <p class="bnx-footer__text">{{ __('messages.footer.owners_description') }}</p>
                <div class="bnx-footer__actions">
                    <a href="{{ route('register') }}" class="btn btn-primary">{{ __('messages.common.create_account') }}</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">{{ __('messages.common.login') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="bnx-footer__bottom">
        <div class="container-xl d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="mb-0">&copy; {{ now()->year }} {{ __('messages.site.app_name') }}. {{ __('messages.footer.copyright') }}</p>
            <span>{{ __('messages.footer.bottom_note') }}</span>
        </div>
    </div>
</footer>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>

<script src="{{ asset('assets/public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/public/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/public/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/public/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/public/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/public/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/public/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/public/js/main.js') }}"></script>
<script src="{{ asset('assets/public/js/assistant-widget.js') }}"></script>
</body>
</html>