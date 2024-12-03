<?php view('layouts/header.php', ['title' => 'Complete']); ?>
    <div class="container complete_container">
        <div class="banner">
            <div class="banner_content">
                <div class="f_container">
                    <div class="inner_container">
                        <figure class="banner_text"><img src="../assets/img/kyushu_txt.webp" alt="Kyushu Route"></figure>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner_color"></div>
        <div class="f_container">
            <div class="inner_container l_main">
                <h2>Thank you!<br> We have received your application. </h2>
                    <p>If you have been shortlisted, you will be notified via the email address below. 
                        <br>Please check your email periodically. (Do make sure to check your spam folder as well) <br>
                        <strong>campaign@japanbyjapan.com</strong>
                    </p>
                    <div class="btn_m_top">
                        <a href="/">Back to top</a>
                    </div>
            </div>
        </div>
        <div class="covid_contact">
            <div class="f_container">
                <p>Get Advisory Information COVID-19 situation in Japan</p>
                <a href="#">Go to Advisory Information website</a>
            </div>
        </div>
        <div class="home_contact">
            <div class="f_container">
                <ul class="nav">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Gift an unforgettable birthday in Japan​!</a></li>
                    <li><a href="#">Application form for Hiroshima and Sanin route</a></li>
                </ul>
            </div>
        </div>
        <div class="jnto ">
            <div class="f_container">
              <a href="#"  class="logo">
                <img src="../assets/img/JNTO_logo.png" alt="JNTO" />
              </a>
              <ul class="contact">
                <li ><a href="#">Home</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Privacy Policy</a> </li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">JbyJ intro</a></li>
              </ul>
              <div class="social">
                <a href="#" class=" fa-brands facebook fa-facebook-f">
                  <span>facebook</span>
                </a>
                <a href="#" class="instagram fa-brands fa-instagram">
                  <span>instagram</span>
                </a>
              </div>
            </div>
        </div>
        <div class="footer">
            <div class="f_container">
                <p>Copyright @ Japan National Tourists Organization. All Rights Reserved.</p>
            </div>
        </div>
    </div>
<?php view('layouts/footer.php'); ?>