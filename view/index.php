<?php
    // Remove confrim data from session
    unset($_SESSION['confirm']);
    // Get Errors
    isset($_SESSION['errors']) ? $errors = json_decode($_SESSION['errors'], true) : '';
    // Get Data
    if(isset($_SESSION['data'])) {
        $oldData = json_decode($_SESSION['data']);
        // Remove image
        if(is_string($oldData->uploadAvatar)) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/assets/upload/' . $oldData->uploadAvatar)) {
                unlink(($_SERVER['DOCUMENT_ROOT'] . '/assets/upload/' . $oldData->uploadAvatar));
            }
        }
    }
    // When refresh, unset all session
    unset($_SESSION['errors']);
    unset($_SESSION['data']);
    print_r($oldData);
?>
<?php view('layouts/header.php', ['title' => 'Form']); ?>
    <div class="container" >
        <div class="inner_container">
            <p class="req"><strong>Please complete the application form below.</strong></p>
        </div>
        <div class="form_container">
            <form action="/create" method="POST" enctype="multipart/form-data">
                <div class="f_container">
                    <div class="inner_container">
                        <h3><span class="star_icon">Representative Applicant</span></h3>
                        <!-- Name -->
                        <div class="form_gp">
                            <h5 class="title">Full Name</h5> 
                            <div class="fullname">
                                <div class="first-item">
                                    <input type="text" id="name" placeholder="First Name" name="firstName" value="<?= isset($oldData->firstName) && $oldData->firstName ? $oldData->firstName : ''; ?>" />
                                    <?php if(isset($errors['firstName'])): ?>
                                        <span class="for_err"><?= $errors['firstName']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="second-item">
                                    <input type="text" placeholder="Last Name" name="lastName" value="<?= isset($oldData->lastName) && $oldData->lastName ? $oldData->lastName : ''; ?>" />
                                    <?php if(isset($errors['lastName'])): ?>
                                        <span class="for_err"><?= $errors['lastName']; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Date of Birth -->
                        <div class="form_gp">
                            <h5 class="title">Date of Birth</h5>
                            <input type="date" id="dateOfBirth" name="dob" value="<?= isset($oldData->dob) && $oldData->dob ? $oldData->dob : ''; ?>" />
                            <?php if(isset($errors['dob'])): ?>
                                <span class="for_err"><?= $errors['dob']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Gender -->
                        <div class="form_gp">
                            <h5 class="title">Gender</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio">Male
                                        <input type="radio" name="gRadio" value="male"
                                        <?php if(isset($oldData->gRadio) && $oldData->gRadio): ?>
                                            <?= $oldData->gRadio === 'male' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Female
                                        <input type="radio" name="gRadio" value="female"
                                        <?php if(isset($oldData->gRadio) && $oldData->gRadio): ?>
                                            <?= $oldData->gRadio === 'female' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Other
                                        <input type="radio" name="gRadio" value="other"
                                        <?php if(isset($oldData->gRadio) && $oldData->gRadio): ?>
                                            <?= $oldData->gRadio === 'other' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                            <?php if(isset($errors['gRadio'])): ?>
                                <span class="for_err"><?= $errors['gRadio']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Nationality -->
                        <div class="form_gp">
                            <h5 class="title">Nationality</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio others-input">Singaporean
                                        <input type="radio" name="nationality" class="all_input" value="singaporean" 
                                        <?= isset($oldData->nationality) && $oldData->nationality === 'singaporean' ? 'checked' : ''; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <div class="others">
                                        <label class="all_checks_radio others-input">Other:
                                            <input type="radio" name="nationality" value="other"
                                            <?= isset($oldData->nationality) && $oldData->nationality === 'other' ? 'checked' : ''; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                        <input type="text" class="<?= isset($oldData->nationality) && $oldData->nationality !== 'singaporean' ? '' : 'dim'; ?>" id="nation_opt1" name="nationalityInput" <?= isset($oldData->nationality) && $oldData->nationality === 'other' ? "" : "disabled='disabled'"; ?> name="nationality" value="<?= isset($oldData->nationalityInput) && $oldData->nationalityInput ? $oldData->nationalityInput : ''; ?>">
                                    </div>
                                </li>
                            </ul>
                            <?php if(isset($errors['nationality'])): ?>
                                <span class="for_err"><?= $errors['nationality']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Occupation -->
                        <div class="form_gp">
                            <h5 class="title">Occupation</h5>
                            <input type="text" id="occupation" placeholder="Type..." name="occupation" value="<?= isset($oldData->occupation) && $oldData->occupation ? $oldData->occupation : ''; ?>" />
                            <?php if(isset($errors['occupation'])): ?>
                                <span class="for_err"><?= $errors['occupation']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Religion -->
                        <div class="form_gp">
                            <h5 class="title">Religion</h5>
                            <p >(We will try to caster to religion preferences, but should you not wish to specify, please answer "prefer not to say")</p>
                            <input type="text" id="religion" placeholder="Type..." name="religion" value="<?= isset($oldData->religion) && $oldData->religion ? $oldData->religion : ''; ?>" />
                            <?php if(isset($errors['religion'])): ?>
                                <span class="for_err"><?= $errors['religion']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- SNS username -->
                        <div class="form_gp">
                            <h5 class="title">SNS username<span class="sub_txt">(Facebook/Instagram/Tiktok/Youtube)</h5>
                            <p >*Leave the option blank if you do not have any Social Media account</p>
                            <input type="text" id="sns" placeholder="Type..." name="snsUsername" value="<?= isset($oldData->snsUsername) && $oldData->snsUsername ? $oldData->snsUsername : ''; ?>" />
                            <?php if(isset($errors['snsUsername'])): ?>
                                <span class="for_err"><?= $errors['snsUsername']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- have been to japan -->
                        <div class="form_gp">
                            <h5 class="title">Have you been to Japan before?</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio">Never
                                        <input type="radio" name="jpRadio" id="never_input" class="c-form_radio" value="never"
                                        <?php if(isset($oldData->jpRadio) && $oldData->jpRadio): ?>
                                            <?= $oldData->jpRadio === 'never' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Once
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="once"
                                        <?php if(isset($oldData->jpRadio) && $oldData->jpRadio): ?>
                                            <?= $oldData->jpRadio === 'once' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Twice
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="twice"
                                        <?php if(isset($oldData->jpRadio) && $oldData->jpRadio): ?>
                                            <?= $oldData->jpRadio === 'twice' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Thrice
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="thrice"
                                        <?php if(isset($oldData->jpRadio) && $oldData->jpRadio): ?>
                                            <?= $oldData->jpRadio === 'thrice' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">More than 3 times
                                        <input type="radio" name="jpRadio" class="c-form_radio" value="more than 3 times"
                                        <?php if(isset($oldData->jpRadio) && $oldData->jpRadio): ?>
                                            <?= $oldData->jpRadio === 'more than 3 times' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                            <?php if(isset($errors['jpRadio'])): ?>
                                <span class="for_err"><?= $errors['jpRadio']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Region visited in past Japan travels -->
                        <div class="visited_japan form_gp">
                            <h5 class="title">Region(s) visited in past Japan travels</h5>
                            <div class="region">
                                <h5 class="title">Hokkaido / Tohoku region</h5>
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Hokkaido
                                            <input type="checkbox" name="region[]" value="hokkaido"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'hokkaido' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Aomori
                                            <input type="checkbox" name="region[]" value="aomori"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'aomori' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Iwate
                                            <input type="checkbox" name="region[]" value="iwate"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'iwate' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Miyagi
                                            <input type="checkbox" name="region[]" value="miyagi"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'miyagi' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Akita
                                            <input type="checkbox" name="region[]" value="akita"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'akita' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li><li>
                                        <label class="all_checks_label">Yamagata
                                            <input type="checkbox" name="region[]" value="yamagata"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'yamagata' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Fukushima
                                            <input type="checkbox" name="region[]" value="fukushima"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'fukushima' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Kanto region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Ibaraki
                                            <input type="checkbox" name="region[]" value="ibaraki"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'ibaraki' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Tochigi
                                            <input type="checkbox" name="region[]" value="tochigi"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'tochigi' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Gunma
                                            <input type="checkbox" name="region[]" value="gunma"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'gunma' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Saitama
                                            <input type="checkbox" name="region[]" value="saitama"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'saitama' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Chiba
                                            <input type="checkbox" name="region[]" value="chiba"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'chiba' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Tokyo
                                            <input type="checkbox" name="region[]" value="tokyo"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'tokyo' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Kanagawa
                                            <input type="checkbox" name="region[]" value="kanagawa"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'kanagawa' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Hokuriku Shinetesu region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Niigata
                                            <input type="checkbox" name="region[]" value="niigata"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'niigata' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Toyama
                                            <input type="checkbox" name="region[]" value="toyama"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'toyama' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Ishikawa
                                            <input type="checkbox" name="region[]" value="ishikawa"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'ishikawa' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Yamanashi
                                            <input type="checkbox" name="region[]" value="yamanashi"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'yamanashi' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Nagano
                                            <input type="checkbox" name="region[]" value="nagano"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'nagano' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Chubu region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Shizuoka
                                            <input type="checkbox" name="region[]" value="shizuoka"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'shizuoka' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Aichi
                                            <input type="checkbox" name="region[]" value="aichi"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'aichi' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Gifu
                                            <input type="checkbox" name="region[]" value="gifu"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'gifu' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Mie
                                            <input type="checkbox" name="region[]" value="mie"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'mie' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Fukui
                                            <input type="checkbox" name="region[]" value="fukui"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'fukui' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Kinki region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Shiga
                                            <input type="checkbox" name="region[]" value="shiga"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'shiga' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Kyoto
                                            <input type="checkbox" name="region[]" value="kyoto"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'kyoto' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Osaka
                                            <input type="checkbox" name="region[]" value="osaka"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'osaka' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Hyogo
                                            <input type="checkbox" name="region[]" value="hyogo"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'hyogo' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Nara
                                            <input type="checkbox" name="region[]" value="nara"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'nara' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Wakayama
                                            <input type="checkbox" name="region[]" value="wakayama"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'wakayama' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Chugoku region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Tottori
                                            <input type="checkbox" name="region[]" value="tottori"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'tottori' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Shimane
                                            <input type="checkbox" name="region[]" value="shimane"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'shimane' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Okayama
                                            <input type="checkbox" name="region[]" value="okayama"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'okayama' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Hiroshima
                                            <input type="checkbox" name="region[]" value="hiroshima"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'hiroshima' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Yamaguchi
                                            <input type="checkbox" name="region[]" value="yamaguchi"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'yamaguchi' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Shikoku region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Tokushima
                                            <input type="checkbox" name="region[]" value="tokushima"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'tokushima' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Kagawa
                                            <input type="checkbox" name="region[]" value="kagawa"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'kagawa' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Ehima
                                            <input type="checkbox" name="region[]" value="ehima"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'ehima' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Kochi
                                            <input type="checkbox" name="region[]" value="kochi"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'kochi' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="region">
                                <h5 class="title">Kyushu / Okinawa region</h5> 
                                <ul class="custom-checkbox">
                                    <li>
                                        <label class="all_checks_label">Fukuoka
                                            <input type="checkbox" name="region[]" value="fukuoka"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'fukuoka' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Saga
                                            <input type="checkbox" name="region[]" value="saga"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'saga' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Nagasaki
                                            <input type="checkbox" name="region[]" value="nagasaki"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'nagasaki' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Kumamoto
                                            <input type="checkbox" name="region[]" value="kumamoto"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'kumamoto' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Oita
                                            <input type="checkbox" name="region[]" value="oita"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'oita' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Miyazaki
                                            <input type="checkbox" name="region[]" value="miyazaki"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'miyazaki' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Kagoshima
                                            <input type="checkbox" name="region[]" value="kagoshima"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'kagoshima' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Okinawa
                                            <input type="checkbox" name="region[]" value="okinawa"
                                            <?php if(isset($oldData->region) && $oldData->region): ?>
                                                <?php foreach($oldData->region as $item): ?>
                                                    <?= $item === 'okinawa' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <?php if(isset($errors['region'])): ?>
                                <span class="for_err"><?= $errors['region']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Dietary  Restrictions-->
                        <div class="form_gp">
                            <h5 class="title">Dietary Restrictions<span class="sub_txt">(Including Alcohol)</span> </h5>
                            <input type="text" id="dietary" placeholder="Type..." name="dietary" value="<?= isset($oldData->dietary) && $oldData->dietary ? $oldData->dietary : ''; ?>" />
                            <?php if(isset($errors['dietary'])): ?>
                                <span class="for_err"><?= $errors['dietary']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Email -->
                        <div class="form_gp">
                            <h5 class="title">Email Address</h5>
                            <input type="text" id="email"placeholder="Email" name="email" value="<?= isset($oldData->email) && $oldData->email ? $oldData->email : ''; ?>" />
                            <?php if(isset($errors['email'])): ?>
                                <span class="for_err"><?= $errors['email']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Phone Number -->
                        <div class="form_gp">
                            <h5 class="title">Phone Number</h5>
                            <input type="text" id="phone"placeholder="Phone Number" name="phone" value="<?= isset($oldData->phone) ? $oldData->phone : ''; ?>" />
                            <?php if(isset($errors['phone'])): ?>
                                <span class="for_err"><?= $errors['phone']; ?></span>
                            <?php endif; ?>
                        </div>
                        <hr class="form_gp">
                        <!-- Travel Companion 01 -->
                        <h3 class="form_gp"><span class="star_icon">Travel Companion 01</span></h3>
                        <!-- Name -->
                        <div class="form_gp">
                            <h5 class="title">Full Name</h5>
                            <div class="fullname">
                                <div class="first-item">
                                    <input type="text" id="name" placeholder="First Name" name="tFirstName" value="<?= isset($oldData->tFirstName) && $oldData->tFirstName ? $oldData->tFirstName : ''; ?>" />
                                    <?php if(isset($errors['tFirstName'])): ?>
                                        <span class="for_err"><?= $errors['tFirstName']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="second-item">
                                    <input type="text" placeholder="Last Name" name="tLastName" value="<?= isset($oldData->tLastName) && $oldData->tLastName ? $oldData->tLastName : ''; ?>" />
                                    <?php if(isset($errors['tLastName'])): ?>
                                        <span class="for_err"><?= $errors['tLastName']; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Date of Birth -->
                        <div class="form_gp">
                            <h5 class="title">Date of Birth</h5>
                            <input type="date" id="dateOfBirth" name="tDob" value="<?= isset($oldData->tDob) && $oldData->tDob ? $oldData->tDob : ''; ?>" />
                            <?php if(isset($errors['tDob'])): ?>
                                <span class="for_err"><?= $errors['tDob']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Gender -->
                        <div class="form_gp">
                            <h5 class="title">Gender</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio">Male
                                        <input type="radio" name="sgRadio" value="male"
                                        <?php if(isset($oldData->sgRadio) && $oldData->sgRadio): ?>
                                            <?= $oldData->sgRadio === 'male' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Female
                                        <input type="radio" name="sgRadio" value="female"
                                        <?php if(isset($oldData->sgRadio) && $oldData->sgRadio): ?>
                                            <?= $oldData->sgRadio === 'female' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="all_checks_radio">Other
                                        <input type="radio" name="sgRadio" value="other"
                                        <?php if(isset($oldData->sgRadio) && $oldData->sgRadio): ?>
                                            <?= $oldData->sgRadio === 'other' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            </ul>
                            <?php if(isset($errors['sgRadio'])): ?>
                                <span class="for_err"><?= $errors['sgRadio']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Nationality -->
                        <div class="form_gp">
                            <h5 class="title">Nationality</h5>
                            <ul>
                                <li>
                                    <label class="all_checks_radio others-input">Singaporean
                                        <input type="radio" name="tNationality" value="singaporean"
                                        <?php if(isset($oldData->tNationality) && $oldData->tNationality): ?>
                                            <?= $oldData->tNationality === 'singaporean' ? 'checked' : ''; ?>
                                        <?php endif; ?>
                                        >
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                                <li>
                                    <div class="others">
                                        <label class="all_checks_radio others-input">Other:
                                            <input type="radio" name="tNationality" class="all_input" value="other"
                                            <?php if(isset($oldData->tNationality) && $oldData->tNationality): ?>
                                                <?= $oldData->tNationality === 'other' ? 'checked' : ''; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                        <input type="text" class="<?= isset($oldData->tNationality) && $oldData->tNationality === 'other' ? '' : 'dim'; ?>" id="nation_opt2" name="tNationalityInput" <?= isset($oldData->tNationality) && $oldData->tNationality === 'other' ? '' : 'disabled="disbaled"'; ?>
                                        <?php if(isset($oldData->tNationality) && $oldData->tNationality === 'other'): ?>
                                            value="<?= isset($oldData->tNationalityInput) && $oldData->tNationalityInput ? $oldData->tNationalityInput : ''; ?>"
                                        <?php endif; ?>
                                        >
                                    </div>
                                </li>
                            </ul>
                            <?php if(isset($errors['tNationality'])): ?>
                                <span class="for_err"><?= $errors['tNationality']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Relationship with applicate -->
                        <div class="form_gp">
                            <h5 class="title">Relationship with applicant</h5>
                            <input type="text" id="relationship"placeholder="Type..." name="relationship" value="<?= isset($oldData->relationship) && $oldData->relationship ? $oldData->relationship : ''; ?>" />
                            <?php if(isset($errors['relationship'])): ?>
                                <span class="for_err"><?= $errors['relationship']; ?></span>
                            <?php endif; ?>
                        </div>
                        <!-- Dietary  Restrictions-->
                        <div class="form_gp">
                            <h5 class="title">Dietary Restrictions<span class="sub_txt">(Including Alcohol)</span></h5>
                            <input type="text" id="dietary" placeholder="Type..." name="tDietary" value="<?= isset($oldData->tDietary) && $oldData->tDietary ? $oldData->tDietary : ''; ?>" />
                            <?php if(isset($errors['tDietary'])): ?>
                                <span class="for_err"><?= $errors['tDietary']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="files_upload">
                   <div class="f_container">
                        <div class="inner_container">
                            <div class="form_gp img_upload">
                                <h5 class="title">Please upload a photo that shows all applicate in the photo</h5>
                                <input type="file" name="uploadAvatar" accept="image/png, image/jpeg" />
                                <figure class="upload_img"><img src="../assets/img/JNTO_logo.png" alt=""></figure>
                                <?php if(isset($errors['uploadAvatar'])): ?>
                                    <span class="for_err"><?= $errors['uploadAvatar']; ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="form_gp">
                                <h5 class="title">The full name of the name who will receives the trip to Japan as their birthday gift</h5>
                                <div class="fullname">
                                    <div class="first-item">
                                        <input type="text" id="person" class="fname" placeholder="First Name" name="gFirstName" value="<?= isset($oldData->gFirstName) && $oldData->gFirstName ? $oldData->gFirstName : ''; ?>" />
                                        <?php if(isset($errors['gFirstName'])): ?>
                                            <span class="for_err"><?= $errors['gFirstName']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="second-item">
                                        <input type="text" placeholder="Last Name" name="gLastName" value="<?= isset($oldData->gLastName) && $oldData->gLastName ? $oldData->gLastName : ''; ?>" />
                                        <?php if(isset($errors['gLastName'])): ?>
                                            <span class="for_err"><?= $errors['gLastName']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form_gp">
                                <h5 class="title">Please let us know your preferred traveling period</h5>
                                <ul>
                                    <li>
                                        <label class="all_checks_label">Early January 2024
                                            <input type="checkbox" name="tPeriod[]" value="Early January 2024"
                                            <?php if(isset($oldData->tPeriod) && $oldData->tPeriod): ?>
                                                <?php foreach($oldData->tPeriod as $item): ?>
                                                    <?= $item === 'Early January 2024' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Mid January 2024
                                            <input type="checkbox" name="tPeriod[]" value="Mid January 2024"
                                            <?php if(isset($oldData->tPeriod) && $oldData->tPeriod): ?>
                                                <?php foreach($oldData->tPeriod as $item): ?>
                                                    <?= $item === 'Mid January 2024' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Late January 2024
                                            <input type="checkbox" name="tPeriod[]" value="Late January 2024"
                                            <?php if(isset($oldData->tPeriod) && $oldData->tPeriod): ?>
                                                <?php foreach($oldData->tPeriod as $item): ?>
                                                    <?= $item === 'Late January 2024' ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <?php if(isset($errors['tPeriod'])): ?>
                                    <span class="for_err"><?= $errors['tPeriod']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form_gp">
                                <h5 class="title">Please upload your introductory video below</h5>
                                <span class="click_upload">Click here to upload</span>
                                <p class="intro_vd">Have you uploaded your introductory video?</p>
                                <ul>
                                    <li>
                                        <label class="all_checks_label">Yes
                                            <input type="checkbox" name="uVideo" <?= isset($oldData->uVideo) && $oldData->uVideo ? 'checked' : ''; ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <?php if(isset($errors['uVideo'])): ?>
                                    <span class="for_err"><?= $errors['uVideo'] ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="pr_vdo_uploader">
                                <div class="pr_modal_inner">
                                    <span class="close"></span>
                                    <div class="pr_vdo_item">
                                        <iframe src="https://app.box.com/f/c29a6af23f4049a09cde0f088f728b93" height="550" width="800"></iframe>
                                    </div>
                                </div>
                            </div>
                            <div class="form_gp">
                                <h5 class="title">Please let us know how you came across this campaign</h5>
                                <ul>
                                    <li>
                                        <label class="all_checks_label">JNTO's Website (japan.travel)
                                            <input type="checkbox" name="campaign[]" value="JNTO's Website (japan.travel)"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?php $itemDecode = htmlspecialchars_decode($item); ?>
                                                    <?= $itemDecode === "JNTO's Website (japan.travel)" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">JNTO's Facebook (Visit Japan Now)
                                            <input type="checkbox" name="campaign[]" value="JNTO's Facebook (Visit Japan Now)"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item == "JNTO's Facebook (Visit Japan Now)" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">JNTO's Instagram (@visitjapansg)
                                            <input type="checkbox" name="campaign[]" value="JNTO's Instagram (@visitjapansg)"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "JNTO's Instagram (@visitjapansg)" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">JAPAN by Japan EDM
                                            <input type="checkbox" name="campaign[]" value="JAPAN by japan EDM"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "JAPAN by japan EDM" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Japan Travel Fair
                                            <input type="checkbox" name="campaign[]" value="Japan Travel Fair"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "Japan Travel Fair" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Social media
                                            <input type="checkbox" name="campaign[]" value="Social media"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "Social media" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Online news sites
                                            <input type="checkbox" name="campaign[]" value="Online news sites"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "Online news sites" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Radio
                                            <input type="checkbox" name="campaign[]" value="Radio"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "Radio" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <label class="all_checks_label">Friends/Family
                                            <input type="checkbox" name="campaign[]" value="Friends/Family"
                                            <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "Friends/Family" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            >
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <li>
                                        <div class="others">
                                            <label class="all_checks_label others-input">Other:
                                                <input type="checkbox" class="all_input" name="campaign[]" value="other"
                                                <?php if(isset($oldData->campaign) && $oldData->campaign): ?>
                                                <?php foreach($oldData->campaign as $item): ?>
                                                    <?= $item === "other" ? 'checked' : ''; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                                >
                                                <span class="checkmark"></span>
                                            </label>
                                            <input type="text" class="remove_dim_class" name="campaignInput"
                                            <?php if(isset($oldData->campaignInput) && $oldData->campaignInput): ?>
                                                value="<?= $oldData->campaignInput; ?>"
                                            <?php endif; ?>
                                            >
                                        </div>
                                    </li>
                                </ul>
                                <?php if(isset($errors['campaign'])): ?>
                                    <span class="for_err"><?= $errors['campaign'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="f_container">
                    <div class="policy">
                        <label class="all_checks_label">By checking this box, you agree to the campaign’s <a href="#">Terms and Conditions</a> and confirm that you have read JAPAN by Japan’s <a href="#">Privacy Policy</a>.
                            <input type="checkbox" class="policy_input all_input" name="policy">
                            <span class="checkmark"></span>
                            <?php if(isset($errors['policy'])): ?>
                                <span class="for_err"><?= $errors['policy']; ?></span>
                            <?php endif; ?>
                        </label>
                    </div>
                </div>
                <div class="btn_submit">
                    <button type="submit" name="submit" class="submit_btn" value="create">
                        <span>Submit</span>
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