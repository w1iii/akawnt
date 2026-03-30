<section id="contact">

    <!--  THIS CAN BE CHANGED      
        Right now, contact is basically useless and is a placeholder which should be
        the apply area for Accountants
        First: Lets make seeders for accountants and admin login. (Steven knows best)
        After that we make the Admin page after they successfully log in
        This section is temporary but everything else on this main page can stay (Unless we want to change the navbar)
    -->





    <div class="container">
        <div class="row g-5">
            
        <!-- Info -->
            <div class="col-lg-4">
                <div class="section-label">Contact</div>
                <h2 class="section-title">Let's talk.</h2>
                <div class="section-divider"></div>
                <p class="text-muted mb-5">
                    Whether you have a question, a proposal idea, or just want to say hello —
                    we'd love to hear from you.
                </p>

                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Address</div>
                        <div class="contact-info-value">blank street<br>Bacolod City, Philippines</div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Email</div>
                        <div class="contact-info-value">MichaelJackerson@whomail.com</div>
                    </div>
                </div>
                <div class="contact-info-item">
                    <div class="contact-info-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <div class="contact-info-label">Phone</div>
                        <div class="contact-info-value">+63 123 456 7891</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-8">
                <div class="contact-form-wrap">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Juan" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Dela Cruz" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="juan@email.com" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <select name="subject" class="form-select">
                                    <option value="" disabled selected>Select a topic</option>
                                    <option>General Inquiry</option>
                                    <option>Job Application</option>
                                    <option>Partnership</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message</label>
                                <textarea name="message" class="form-control" rows="5"
                                            placeholder="Tell us what's on your mind..." required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-primary-custom w-100 text-center">
                                    Send Message <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>