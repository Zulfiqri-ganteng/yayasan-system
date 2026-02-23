<?= $this->extend('frontend/layouts/main') ?>
<?= $this->section('content') ?>

<?= view('frontend/partials/page_header', [
    'pageLabel' => lang('App.contact'),
    'pageTitle' => lang('App.contact_unit', ['name' => $institutionName])
]) ?>

<section class="contact-wrapper py-5">
    <div class="container">
        <div class="row g-5">

            <!-- INFO -->
            <div class="col-lg-4">
                <div class="contact-card">

                    <h4 class="mb-4 fw-semibold">
                        <?= lang('App.contact_information') ?>
                    </h4>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h6><?= lang('App.address') ?></h6>
                            <p><?= esc($profil['alamat'] ?? '-') ?></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h6><?= lang('App.phone') ?></h6>
                            <p><?= esc($profil['no_telp'] ?? '-') ?></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h6><?= lang('App.email') ?></h6>
                            <p><?= esc($profil['email'] ?? '-') ?></p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MAP -->
            <div class="col-lg-4">
                <div class="map-box">
                    <?php if (!empty($profil['google_maps'])): ?>
                        <?= $profil['google_maps'] ?>
                    <?php else: ?>
                        <iframe class="w-100 h-100 border-0"
                            src="https://maps.google.com/maps?q=Indonesia&t=&z=5&ie=UTF8&iwloc=&output=embed"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    <?php endif; ?>
                </div>
            </div>

            <!-- FORM -->
            <div class="col-lg-4">
                <div class="contact-form-box">
                    <h4 class="mb-4 fw-semibold">
                        <?= lang('App.send_message') ?>
                    </h4>

                    <form method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <input type="text" name="name" required>
                            <label><?= lang('App.full_name') ?></label>
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" required>
                            <label><?= lang('App.email') ?></label>
                        </div>

                        <div class="form-group">
                            <input type="text" name="subject">
                            <label><?= lang('App.subject') ?></label>
                        </div>

                        <div class="form-group">
                            <textarea name="message" rows="4" required></textarea>
                            <label><?= lang('App.message') ?></label>
                        </div>

                        <button type="submit" class="btn-submit">
                            <?= lang('App.send_message_btn') ?>
                        </button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>