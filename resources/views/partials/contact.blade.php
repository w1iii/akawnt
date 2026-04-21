<section id="contact">

    {{-- Form --}}
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @error('email_unique')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @error('phone_unique')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <form action="{{ route('apply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="Juan" value="{{ old('first_name') }}" required />
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Dela Cruz" value="{{ old('last_name') }}" required />
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="juan@email.com" value="{{ old('email') }}" required />
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+63 123 456 7890" value="{{ old('phone') }}" required />
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Position Applying For</label>
                                <select name="position" class="form-select @error('position') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select a position</option>
                                    <option value="Certified Public Accountant (CPA)" @if(old('position') == 'Certified Public Accountant (CPA)') selected @endif>Certified Public Accountant (CPA)</option>
                                    <option value="Tax Accountant" @if(old('position') == 'Tax Accountant') selected @endif>Tax Accountant</option>
                                    <option value="Audit Associate" @if(old('position') == 'Audit Associate') selected @endif>Audit Associate</option>
                                    <option value="Bookkeeper" @if(old('position') == 'Bookkeeper') selected @endif>Bookkeeper</option>
                                    <option value="Payroll Specialist" @if(old('position') == 'Payroll Specialist') selected @endif>Payroll Specialist</option>
                                    <option value="Financial Analyst" @if(old('position') == 'Financial Analyst') selected @endif>Financial Analyst</option>
                                    <option value="Other" @if(old('position') == 'Other') selected @endif>Other</option>
                                </select>
                                @error('position')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Resume (PDF, DOC, DOCX)</label>
                                <input type="file" name="resume" class="form-control @error('resume') is-invalid @enderror" accept=".pdf,.doc,.docx" required />
                                <small class="text-muted">Max file size: 5 MB</small>
                                @error('resume')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message / Cover Letter</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" placeholder="Tell us about yourself..." value="{{ old('message') }}" required></textarea>
                                @error('message')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-primary-custom w-100 text-center">
                                    Submit Application <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
