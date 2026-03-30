<section id="careers">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label">Careers</div>
            <h2 class="section-title">Open Positions</h2>
            <div class="section-divider mx-auto"></div>
            <p class="text-muted mx-auto" style="max-width:520px;">
                We're always looking for talented, driven individuals to join our growing team.
                Check out our current openings below.
            </p>
        </div>


        <!-- This can be seeded as well -->
        <div class="row g-4">
            @foreach([
                ['Full-Time', 'Certified Public Accountant (CPA)', 'Accounting', 'Prepare financial statements, ensure regulatory compliance, and manage client tax filings with accuracy.'],
                ['Full-Time', 'Tax Accountant', 'Taxation', 'Handle tax preparation, filing, and planning while ensuring compliance with current regulations.'],
                ['Full-Time', 'Audit Associate', 'Audit', 'Assist in financial audits, examine records, and ensure accuracy and compliance with accounting standards.'],
                ['Full-Time', 'Bookkeeper', 'Accounting', 'Maintain accurate financial records, track transactions, and manage day to day bookkeeping tasks.'],
                ['Full-Time', 'Payroll Specialist', 'Finance', 'Process employee salaries, manage payroll records, and ensure timely and compliant compensation.'],
                ['Full-Time', 'Financial Analyst', 'Finance', 'Analyze financial data, generate reports, and provide insights to support business decision making.'],
            ] as [$tag, $title, $dept, $desc])
            <div class="col-md-6 col-lg-4">
                <div class="job-card">
                    <span class="job-tag">{{ $tag }}</span>
                    <div class="job-title">{{ $title }}</div>
                    <div class="job-dept"><i class="bi bi-building me-1"></i>{{ $dept }}</div>
                    <p style="font-size:0.88rem;color:var(--muted);margin-bottom:1.5rem;">{{ $desc }}</p>
                    <a href="#contact" class="job-apply">
                        Apply Now <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>