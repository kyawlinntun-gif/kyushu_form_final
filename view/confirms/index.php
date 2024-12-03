<?php 
    // Unset Errors
    if(isset($_SESSION['errors'])) {
        unset($_SESSION['errors']);
    }
    // Get Data
    isset($_SESSION['data']) ? $data = json_decode($_SESSION['data']) : '';
?>
<?php view('layouts/header.php', ['title' => 'Confirm']); ?>
    <div class="container" >
        <div class="inner_container">
            <p class="req"><strong>Please complete the application form below.</strong></p>
        </div>
        <div class="form_container">
            <form action="/store" method="POST">
                <div class="f_container">
                    <div class="inner_container">
                        <h3><span class="star_icon">Representative Applicant</span></h3>
                        <!-- Name -->
                        <div class="form_gp">
                            <h5 class="title">Full Name</h5> 
                            <div class="fullname">
                                <div class="first-item">
                                    <input type="text" id="name" placeholder="First Name" name="firstName" value="<?= $data->firstName; ?>" disabled />
                                </div>
                                <div class="second-item">
                                    <input type="text" placeholder="Last Name" name="lastName" value="<?= $data->lastName; ?>" disabled />
                                </div>
                            </div>
                        </div>
                        <!-- Date of Birth -->
                        <div class="form_gp">
                            <h5 class="title">Date of Birth</h5>
                            <input type="date" id="dateOfBirth" name="dob" value="<?= $data->dob; ?>" disabled />
                        </div>
                        <!-- Gender -->
                        <div class="form_gp">
                            <h5 class="title">Gender</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio"><?= $data->gRadio; ?>
                                        <input type="radio" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <!-- Nationality -->
                        <div class="form_gp">
                            <h5 class="title">Nationality</h5>
                            <ul>
                                <?php if($data->nationality): ?>
                                <li>
                                    <label class="all_checks_radio others-input"><?= $data->nationality === 'singaporean' ? $data->nationality : $data->nationalityInput; ?>
                                        <input type="radio" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- Occupation -->
                        <div class="form_gp">
                            <h5 class="title">Occupation</h5>
                            <input type="text" id="occupation" placeholder="Type..." name="occupation" value="<?= $data->occupation; ?>" disabled />
                        </div>
                        <!-- Religion -->
                        <div class="form_gp">
                            <h5 class="title">Religion</h5>
                            <p >(We will try to caster to religion preferences, but should you not wish to specify, please answer "prefer not to say")</p>
                            <input type="text" id="religion" placeholder="Type..." name="religion" value="<?= $data->religion; ?>" disabled />
                        </div>
                        <!-- SNS username -->
                        <div class="form_gp">
                            <h5 class="title">SNS username<span class="sub_txt">(Facebook/Instagram/Tiktok/Youtube)</h5>
                            <p >*Leave the option blank if you do not have any Social Media account</p>
                            <input type="text" id="sns" placeholder="Type..." name="snsUsername" value="<?= $data->snsUsername; ?>" disabled />
                        </div>
                        <!-- have been to japan -->
                        <div class="form_gp">
                            <h5 class="title">Have you been to Japan before?</h5>
                            <ul>
                                <?php if($data->jpRadio === 'never'): ?>
                                <li>
                                    <label class="all_checks_radio">Never
                                        <input type="radio" name="jpRadio" id="never_input" class="c-form_radio" value="never" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php elseif($data->jpRadio === 'once'): ?>
                                <li>
                                    <label class="all_checks_radio">Once
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="once" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php elseif($data->jpRadio === 'twice'): ?>
                                <li>
                                    <label class="all_checks_radio">Twice
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="twice" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php elseif($data->jpRadio === 'thrice'): ?>
                                <li>
                                    <label class="all_checks_radio">Thrice
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="thrice" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php elseif($data->jpRadio === 'more than 3 times'): ?>
                                <li>
                                    <label class="all_checks_radio">More than 3 times
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="more than 3 times" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- Region visited in past Japan travels -->
                        <?php if($data->region): ?>
                        <div class="visited_japan form_gp">
                            <h5 class="title">Region(s) visited in past Japan travels</h5>
                            <div class="region">
                                <ul class="custom-checkbox">
                                    <?php foreach($data->region as $item): ?>
                                        <li>
                                            <label class="all_checks_label"><?= ucfirst($item); ?>
                                                <input type="checkbox" disabled checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Dietary  Restrictions-->
                        <div class="form_gp">
                            <h5 class="title">Dietary Restrictions<span class="sub_txt">(Including Alcohol)</span> </h5>
                            <input type="text" id="dietary" placeholder="Type..." name="dietary" value="<?= $data->dietary; ?>" disabled />
                        </div>
                        <!-- Email -->
                        <div class="form_gp">
                            <h5 class="title">Email Address</h5>
                            <input type="email" id="email"placeholder="Email" name="email" value="<?= $data->email; ?>" disabled />
                        </div>
                        <!-- Phone Number -->
                        <div class="form_gp">
                            <h5 class="title">Phone Number</h5>
                            <input type="text" id="phone" placeholder="Phone Number" name="phone" value="<?= $data->phone; ?>" disabled />
                        </div>
                        <hr class="form_gp">
                        <!-- Travel Companion 01 -->
                        <h3 class="form_gp"><span class="star_icon">Travel Companion 01</span></h3>
                        <!-- Name -->
                        <div class="form_gp">
                            <h5 class="title">Full Name</h5>
                            <div class="fullname">
                                <div class="first-item">
                                    <input type="text" id="name" placeholder="First Name" value="<?= $data->tFirstName; ?>" disabled />
                                </div>
                                <div class="second-item">
                                    <input type="text" placeholder="Last Name" value="<?= $data->tLastName; ?>" disabled />
                                </div>
                            </div>
                        </div>
                        <!-- Date of Birth -->
                        <div class="form_gp">
                            <h5 class="title">Date of Birth</h5>
                            <input type="date" id="dateOfBirth" value="<?= $data->tDob; ?>" disabled />
                        </div>
                        <!-- Gender -->
                        <div class="form_gp">
                            <h5 class="title">Gender</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio"><?= ucfirst($data->sgRadio); ?>
                                        <input type="radio" name="sgRadio" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <!-- Nationality -->
                        <div class="form_gp">
                            <h5 class="title">Nationality</h5>
                            <ul>
                                <?php if($data->tNationality): ?>
                                <li>
                                    <label class="all_checks_radio others-input"><?= $data->tNationality === 'singaporean' ? $data->tNationality : $data->tNationalityInput; ?>
                                        <input type="radio" checked disabled>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- Relationship with applicate -->
                        <div class="form_gp">
                            <h5 class="title">Relationship with applicant</h5>
                            <input type="text" id="relationship"placeholder="Type..." value="<?= $data->relationship; ?>" disabled />
                        </div>
                        <!-- Dietary  Restrictions-->
                        <div class="form_gp">
                            <h5 class="title">Dietary Restrictions<span class="sub_txt">(Including Alcohol)</span></h5>
                            <input type="text" id="dietary" placeholder="Type..." value="<?= $data->tDietary; ?>" disabled />
                        </div>
                    </div>
                </div>
                <div class="files_upload">
                   <div class="f_container">
                        <div class="inner_container">
                            <div class="form_gp img_upload">
                                <h5 class="title">Please upload a photo that shows all applicate in the photo</h5>
                                <figure class="upload_img">
                                    <img src="./../assets/img/<?= $data->uploadAvatar ?>" alt="<?= $data->uploadAvatar ?>">
                                </figure>
                            </div>

                            <div class="form_gp">
                                <h5 class="title">The full name of the name who will receives the trip to Japan as their birthday gift</h5>
                                <div class="fullname">
                                    <div class="first-item">
                                        <input type="text" id="person" class="fname" placeholder="First Name" value="<?= $data->gFirstName; ?>" disabled />
                                    </div>
                                    <div class="second-item">
                                        <input type="text" placeholder="Last Name" value="<?= $data->gLastName; ?>" disabled />
                                    </div>
                                </div>
                            </div>
                            <div class="form_gp">
                                <h5 class="title">Please let us know your preferred traveling period</h5>
                                <ul>
                                    <?php foreach($data->tPeriod as $item): ?>
                                    <li>
                                        <label class="all_checks_label"><?= $item ?>
                                            <input type="checkbox" checked disabled >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="form_gp">
                                <h5 class="title">Please upload your introductory video below</h5>
                                <ul>
                                    <li>
                                        <label class="all_checks_label">Yes
                                            <input type="checkbox" name="uVideo" <?= $data->uVideo ? 'checked' : ''; ?> disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="form_gp">
                                <h5 class="title">Please let us know how you came across this campaign</h5>
                                <ul>
                                    <?php foreach($data->campaign as $item): ?>
                                    <li>
                                        <label class="all_checks_label">
                                            <?php if($item === 'other'): ?>
                                                <?= $data->campaignInput; ?>
                                            <?php else: ?>
                                                <?= $item; ?>
                                            <?php endif; ?>
                                            <input type="checkbox" checked disabled >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="f_container">
                    <div class="policy">
                        <label class="all_checks_label">By checking this box, you agree to the campaign’s <a href="#">Terms and Conditions</a> and confirm that you have read JAPAN by Japan’s <a href="#">Privacy Policy</a>.
                            <input type="checkbox" class="policy_input all_input" name="policy" <?= $data->policy ? 'checked' : ''; ?> disabled >
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
                <div class="btn_submit">
                    <a href="/" class="back_button">Back</a>
                    <button type="submit" name="submit" value="confirm" class="submit_btn"
                    <?= !$data->policy ? 'disabled' : ''; ?>
                    >
                        <span>Confirm</span>
                    </button>
                </div>
            </form>
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
    </div>
<?php view('layouts/footer.php'); ?>