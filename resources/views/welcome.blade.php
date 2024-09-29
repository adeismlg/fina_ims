<!-- resources/views/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fina-Apps</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
    <link rel="shortcut icon" href="{{ asset('landing/images/favicon.ico') }}" title="Favicon"/>
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/namari-color.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/font-awesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet">
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status" class="la-ball-triangle-path">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!--End of Preloader-->

    <div class="page-border" data-wow-duration="0.7s" data-wow-delay="0.2s">
        <div class="top-border wow fadeInDown animated"></div>
        <div class="right-border wow fadeInRight animated"></div>
        <div class="bottom-border wow fadeInUp animated"></div>
        <div class="left-border wow fadeInLeft animated"></div>
    </div>

    <div id="wrapper">

        <header id="banner" class="scrollto clearfix" data-enllax-ratio=".5">
            <div id="header" class="nav-collapse">
                <div class="row clearfix">
                    <div class="col-1">
                        <!--Logo-->
                        <div id="logo">
                            <img src="{{ asset('landing/images/logo.png') }}" id="banner-logo" alt="Landing Page"/>
                            <img src="{{ asset('landing/images/logo-2.png') }}" id="navigation-logo" alt="Landing Page"/>
                        </div>
                        <!--End of Logo-->

                        <aside>
                            <!--Social Icons in Header-->
                            <ul class="social-icons">
                                <li><a target="_blank" title="Facebook" href="https://www.facebook.com/username"><i class="fa fa-facebook fa-1x"></i><span>Facebook</span></a></li>
                                <li><a target="_blank" title="Google+" href="http://google.com/+username"><i class="fa fa-google-plus fa-1x"></i><span>Google+</span></a></li>
                                <li><a target="_blank" title="Twitter" href="http://www.twitter.com/username"><i class="fa fa-twitter fa-1x"></i><span>Twitter</span></a></li>
                                <li><a target="_blank" title="Instagram" href="http://www.instagram.com/username"><i class="fa fa-instagram fa-1x"></i><span>Instagram</span></a></li>
                                <li><a target="_blank" title="behance" href="http://www.behance.net"><i class="fa fa-behance fa-1x"></i><span>Behance</span></a></li>
                            </ul>
                            <!--End of Social Icons in Header-->
                        </aside>

                        <!--Main Navigation-->
                        <nav id="nav-main">
                            <ul>
                                <li><a href="#banner">Home</a></li>
                                <li><a href="#about">About</a></li>
                                <li><a href="#gallery">Gallery</a></li>
                                <li><a href="#features">Features</a></li>
                                <li><a href="#testimonials">Testimonials</a></li>
                                <li><a href="{{ url('login') }}">Login</a></li>
                            </ul>
                        </nav>
                        <!--End of Main Navigation-->

                        <div id="nav-trigger"><span></span></div>
                        <nav id="nav-mobile"></nav>

                    </div>
                </div>
            </div><!--End of Header-->

            <!--Banner Content-->
            <div id="banner-content" class="row clearfix">
                <div class="col-38">
                    <div class=" section-heading">
                        <h1>Protect Your Business from Financial Fraud</h1>
                        <h2>FraudGuard uses advanced technology to detect and prevent financial fraud, safeguarding your company's assets and reputation.</h2>
                    </div>
                    <!--Call to Action-->
                    <a href="#features" class="button">LEARN MORE</a>
                    <!--End Call to Action-->
                </div>
            </div><!--End of Row-->
        </header>

        <!--Main Content Area-->
        <main id="content">
            <!--Introduction-->
            <section id="about" class="introduction scrollto">
                <div class="row clearfix">
                    <div class="col-3">
                        <div class="section-heading">
                            <h3>SECURITY</h3>
                            <h2 class="section-title">How FraudGuard Protects Your Business</h2>
                            <p class="section-subtitle">FraudGuard leverages cutting-edge technology to offer unparalleled protection against financial fraud. Our application is designed to identify fraudulent activities before they impact your business.</p>
                        </div>
                    </div>
                    <div class="col-2-3">
                        <!--Icon Block-->
                        <div class="col-2 icon-block icon-top wow fadeInUp" data-wow-delay="0.1s">
                            <div class="icon">
                                <i class="fa fa-html5 fa-2x"></i>
                            </div>
                            <div class="icon-block-description">
                                <h4>Advanced Security</h4>
                                <p>Utilizes sophisticated algorithms to detect and prevent fraud with high accuracy.</p>
                            </div>
                        </div>
                        <!--End of Icon Block-->
                        <!--Icon Block-->
                        <div class="col-2 icon-block icon-top wow fadeInUp" data-wow-delay="0.3s">
                            <div class="icon">
                                <i class="fa fa-bolt fa-2x"></i>
                            </div>
                            <div class="icon-block-description">
                                <h4>Real-Time Analytics</h4>
                                <p>Monitor transactions in real-time to catch and address potential fraud instantly.</p>
                            </div>
                        </div>
                        <!--End of Icon Block-->
                        <!--Icon Block-->
                        <div class="col-2 icon-block icon-top wow fadeInUp" data-wow-delay="0.5s">
                            <div class="icon">
                                <i class="fa fa-shield fa-2x"></i>
                            </div>
                            <div class="icon-block-description">
                                <h4>Customizable Alerts</h4>
                                <p>Set up alerts and notifications to stay informed about suspicious activities.</p>
                            </div>
                        </div>
                        <!--End of Icon Block-->
                    </div>
                </div>
            </section>
            <!--End of Introduction-->

            <!--Features-->
            <section id="features" class="scrollto">
                <div class="row clearfix">
                    <div class="col-3">
                        <div class="section-heading">
                            <h3>FEATURES</h3>
                            <h2 class="section-title">FraudGuard's Key Features</h2>
                            <p class="section-subtitle">Explore the advanced features of FraudGuard that make it the leading solution for protecting your business from financial fraud.</p>
                        </div>
                    </div>
                    <div class="col-2-3">
                        <!--Feature Block-->
                        <div class="col-2 feature-block wow fadeInUp" data-wow-delay="0.1s">
                            <div class="icon">
                                <i class="fa fa-lock fa-2x"></i>
                            </div>
                            <div class="feature-description">
                                <h4>Multi-Layer Security</h4>
                                <p>FraudGuard offers multiple layers of security to safeguard your financial transactions from various types of fraud.</p>
                            </div>
                        </div>
                        <!--End of Feature Block-->
                        <!--Feature Block-->
                        <div class="col-2 feature-block wow fadeInUp" data-wow-delay="0.3s">
                            <div class="icon">
                                <i class="fa fa-cogs fa-2x"></i>
                            </div>
                            <div class="feature-description">
                                <h4>Customizable Settings</h4>
                                <p>Tailor the application’s settings to fit your business’s unique needs and fraud prevention strategies.</p>
                            </div>
                        </div>
                        <!--End of Feature Block-->
                        <!--Feature Block-->
                        <div class="col-2 feature-block wow fadeInUp" data-wow-delay="0.5s">
                            <div class="icon">
                                <i class="fa fa-bar-chart fa-2x"></i>
                            </div>
                            <div class="feature-description">
                                <h4>Comprehensive Reporting</h4>
                                <p>Get detailed reports and analytics to monitor fraud prevention efforts and identify potential areas of improvement.</p>
                            </div>
                        </div>
                        <!--End of Feature Block-->
                    </div>
                </div>
            </section>
            <!--End of Content Section-->

            <!--Testimonials-->
            <section id="testimonials" class="text-center scrollto">
                <div class="section-heading">
                    <h3>TESTIMONIALS</h3>
                    <h2 class="section-title">What Our Clients Say</h2>
                    <p class="section-subtitle">Hear from our clients about how FraudGuard has positively impacted their business and prevented financial fraud.</p>
                </div>
                <div class="row clearfix">
                    <!--Testimonial Block-->
                    <div class="col-4 testimonial-block wow fadeInUp" data-wow-delay="0.1s">
                        <div class="testimonial-content">
                            <p>"FraudGuard has revolutionized the way we handle financial transactions. Its real-time analytics and comprehensive reporting are invaluable."</p>
                            <h4>Jane Doe</h4>
                            <h5>CEO, Company A</h5>
                        </div>
                    </div>
                    <!--End of Testimonial Block-->
                    <!--Testimonial Block-->
                    <div class="col-4 testimonial-block wow fadeInUp" data-wow-delay="0.3s">
                        <div class="testimonial-content">
                            <p>"The customizable settings of FraudGuard allowed us to tailor the application to our specific needs. Highly recommend!"</p>
                            <h4>John Smith</h4>
                            <h5>CTO, Company B</h5>
                        </div>
                    </div>
                    <!--End of Testimonial Block-->
                    <!--Testimonial Block-->
                    <div class="col-4 testimonial-block wow fadeInUp" data-wow-delay="0.5s">
                        <div class="testimonial-content">
                            <p>"With FraudGuard, we feel secure knowing that our financial data is protected with the latest technology."</p>
                            <h4>Emily Johnson</h4>
                            <h5>CFO, Company C</h5>
                        </div>
                    </div>
                    <!--End of Testimonial Block-->
                </div>
            </section>
            <!--End of Testimonials-->

            

        </main>
        <!--End of Main Content Area-->

        <!--Footer-->
        <footer id="footer">
            <div class="row clearfix">
                <div class="col-1">
                    <div class="footer-content">
                        <p>&copy; 2024 FraudGuard. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        <!--End of Footer-->

        
    </div>

    <!-- Include JavaScript resources -->
    <script src="landing/js/jquery.1.8.3.min.js"></script>
    <script src="landing/js/wow.min.js"></script>
    <script src="landing/js/featherlight.min.js"></script>
    <script src="landing/js/featherlight.gallery.min.js"></script>
    <script src="landing/js/jquery.enllax.min.js"></script>
    <script src="landing/js/jquery.scrollUp.min.js"></script>
    <script src="landing/js/jquery.easing.min.js"></script>
    <script src="landing/js/jquery.stickyNavbar.min.js"></script>
    <script src="landing/js/jquery.waypoints.min.js"></script>
    <script src="landing/js/images-loaded.min.js"></script>
    <script src="landing/js/lightbox.min.js"></script>
    <script src="landing/js/site.js"></script>

</body>
</html>
