<!-- footer section start -->
<footer class="xs-footer-section">
    <div class="xs-footer-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 row xs-footer-info-and-payment">
                    <div class="col-lg-12">
                        <div class="xs-footer-logo footer-logo-v2">
                            <a href="index.html">
                                <img src="/images/logo_v3.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 media">
                        <span class="icon icon-support d-flex"></span>
                        <div class="media-body">
                            <h5>Hai bisogno di aiuto? Chiama il <strong>333 9523601</strong></h5>
                            <table style="color: #555; font-size: 1.1em; margin: 15px 0;">
                                <tr>
                                    <td style="padding-right: 15px; font-weight: bold;">9:00 - 13:00</td>
                                    <td>Lun - Ven</td>
                                </tr>
                                <tr>
                                    <td style="padding-right: 15px; font-weight: bold;">14:00 - 18:00</td>
                                    <td>Festivi esclusi</td>
                                </tr>
                            </table>
                            <a href="mailto:ordini@aurorapromotion.it" class="btn" style="background-color: #cccbcb;"><i class="icon icon-email"></i> SCRIVICI</a>
                        </div>
                    </div><!-- .media END -->
                    <div class="col-lg-5 col-md-5 media">
                        <span class="icon icon-highlight d-flex"></span>
                        <div class="media-body">
                            <h5><strong>Pagamenti sicuri</strong></h5>
                            <ul class="xs-payment-card">
                                <li>
                                    <a href="https://stripe.com/it" target="_blank">
                                        <img src="/images/credit-cards/stripe.png" alt="stripe">
                                    </a>
                                </li>
                            </ul><!-- .xs-payment-card END -->
                            <div class="xs-footer-secure-info">
                                <ul class="footer-secured-by-icons">
                                    <li>
                                        <img src="/images/credit-cards/bonifico.png" alt="bonifico">
                                    </li>
                                </ul>
                            </div><!-- .xs-footer-secure-info END -->
                        </div>
                    </div><!-- .media END -->
                    <div class="col-md-3 col-lg-3 footer-widget">
                        <h3 class="widget-title">Link utili</h3>
                        <ul class="xs-list">
                            @guest
                                <li><a href="#">Accedi</a></li>
                            @endguest
                            @auth
                                <li><a href="{{ route('shop') }}">Shop</a></li>
                                <li><a href="{{ route('cart.index') }}">Carrello</a></li>
                                <li><a href="{{ route('terms-and-conditions') }}">Termini e Condizioni</a></li>
                                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                                <li><a href="{{ route('cookie-policy') }}">Cookie Policy</a></li>
                            @endauth
                        </ul><!-- .xs-list END -->
                    </div><!-- .footer-widget END -->
                </div>
            </div>
        </div>
    </div><!-- .xs-footer-main END -->
    <div class="xs-copyright copyright-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="xs-copyright-text">
                        &copy; 2018 <a href="http://aurorapromotion.it/" target="_blank">Auro.ra Promotion</a> Via Salento 33, 00162 Roma Tel. +39 06 4403213
                    </div><!-- .xs-copyright-text END -->
                </div>
                <div class="col-md-6">
                    <ul class="xs-social-list version-2">
                        <li><span class="th-copyright">Made with <i style="color: #D9534F;" class="fa fa-heart"></i> by <a style="text-decoration: underline;" href="http://www.nimble-solutions.com" target="_blank">Nimble Solutions</a></span></li>
                    </ul><!-- .xs-social-list END -->
                </div>
            </div>
        </div>
    </div><!-- .xs-copyright .copyright-gray END -->
    <!-- back to top -->
    <div class="xs-back-to-top-wraper">
        <a href="#" class="xs-back-to-top btn btn-warning">Torna su<i class="icon icon-arrow-right"></i></a>
    </div>
    <!-- End back to top -->
</footer>