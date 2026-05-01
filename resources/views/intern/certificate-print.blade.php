<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Certificate — {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .main-container {
            padding: 100px 20px 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            overflow-x: auto;
        }

        .cert-wrapper {
            width: 1120px;
            height: 820px;
            background: #fff;
            position: relative;
            box-shadow: 0 50px 120px rgba(0,0,0,0.15);
            flex-shrink: 0;
            margin: 0 auto;
            overflow: hidden;
        }

        /* Luxury Guilloche Background Pattern */
        .cert-wrapper::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(#f05223 0.5px, transparent 0.5px);
            background-size: 30px 30px;
            opacity: 0.03; /* Increased visibility */
            z-index: 0;
        }

        /* Triple Layer Border System */
        .cert-frame {
            padding: 15px;
            height: calc(100% - 30px);
            background: #fff;
            position: relative;
            box-sizing: border-box;
            border: 1px solid #e2e8f0;
        }

        .cert-inner {
            background: #fff;
            padding: 25px 60px;
            height: 100%;
            position: relative;
            border: 1px solid #f05223;
            outline: 4px double rgba(240, 82, 35, 0.1);
            outline-offset: -12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }

        /* Ultra-Premium Gradient Accents */
        .shape { position: absolute; z-index: 0; pointer-events: none; }
        
        .shape-1 { 
            top: -150px; right: -150px; width: 600px; height: 600px; 
            background: radial-gradient(circle at center, rgba(240, 82, 35, 0.15) 0%, rgba(240, 82, 35, 0.05) 50%, transparent 70%); 
            border-radius: 50%;
            filter: blur(40px);
        }
        
        .shape-2 { 
            bottom: -150px; left: -150px; width: 550px; height: 550px; 
            background: radial-gradient(circle at center, rgba(30, 41, 59, 0.1) 0%, rgba(240, 82, 35, 0.06) 40%, transparent 70%);
            border-radius: 50%;
            filter: blur(40px);
        }

        /* Premium Diagonal Line Pattern */
        .shape-lines {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: repeating-linear-gradient(45deg, rgba(240, 82, 35, 0.03) 0px, rgba(240, 82, 35, 0.03) 1px, transparent 1px, transparent 25px);
            z-index: 0;
        }

        /* Elegant Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            height: 450px;
            background: url("{{ asset('uploads/settings/'.\App\Models\SiteSetting::getValue('site_logo_light', 'logo.png')) }}") no-repeat center;
            background-size: contain;
            opacity: 0.035; /* Crisp visibility */
            z-index: 0;
        }

        /* Elegant Corner Elements */
        .corner { position: absolute; width: 45px; height: 45px; z-index: 2; opacity: 0.7; }
        .corner-tl { top: 15px; left: 15px; border-top: 3px solid #f05223; border-left: 3px solid #f05223; }
        .corner-tr { top: 15px; right: 15px; border-top: 3px solid #f05223; border-right: 3px solid #f05223; }
        .corner-bl { bottom: 15px; left: 15px; border-bottom: 3px solid #f05223; border-left: 3px solid #f05223; }
        .corner-br { bottom: 15px; right: 15px; border-bottom: 3px solid #f05223; border-right: 3px solid #f05223; }

        /* Header */
        .cert-header { text-align: center; position: relative; z-index: 1; margin-bottom: 15px; }
        .cert-logo { max-height: 80px; margin-bottom: 8px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05)); }
        .cert-subtitle { font-size: 0.8rem; letter-spacing: 8px; text-transform: uppercase; color: #1e293b; font-weight: 800; opacity: 0.8; }

        /* Body */
        .cert-body { text-align: center; position: relative; z-index: 1; flex-grow: 1; }
        .presents-text { font-size: 0.95rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 5px; margin-bottom: 12px; font-weight: 700; }
        
        .cert-title {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 15px;
            letter-spacing: -1.5px;
            line-height: 1;
        }

        .awarded-to { font-size: 0.9rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 5px; margin-bottom: 12px; }
        
        .recipient-name {
            font-family: 'Playfair Display', serif;
            font-size: 4.2rem;
            font-weight: 700;
            color: #f05223;
            margin-bottom: 15px;
            display: inline-block;
            padding: 0 50px 8px;
            position: relative;
            line-height: 1.1;
        }
        .recipient-name::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 2px;
            background: linear-gradient(to right, transparent, rgba(240, 82, 35, 0.4), transparent);
        }

        .cert-description {
            font-size: 1.2rem;
            color: #475569;
            line-height: 1.6;
            max-width: 850px;
            margin: 0 auto 25px;
            font-weight: 500;
        }
        .cert-description strong { color: #0f172a; font-weight: 800; border-bottom: 1px solid rgba(240, 82, 35, 0.1); }

        /* Stats Row */
        .cert-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-bottom: 25px;
        }
        .stat-item { text-align: center; border-left: 1px solid #f1f5f9; padding-left: 25px; }
        .stat-item:first-child { border: none; }
        .stat-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 3px; color: #94a3b8; font-weight: 700; }
        .stat-value { font-size: 1.1rem; font-weight: 900; color: #1e293b; }

        /* Footer */
        .cert-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            position: relative;
            z-index: 1;
            margin-top: 5px;
        }

        .signature-block { text-align: center; width: 230px; }
        .sig-line { border-bottom: 2px solid #0f172a; margin-bottom: 10px; }
        .sig-name { font-weight: 900; font-size: 1.05rem; color: #0f172a; }
        .sig-role { font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; }

        /* QR & Seal */
        .badge-group { display: flex; align-items: center; gap: 40px; }
        .qr-code {
            width: 90px; height: 90px;
            padding: 8px; background: #fff;
            border: 1px solid #f1f5f9; border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .cert-seal {
            width: 105px; height: 105px;
            background: linear-gradient(135deg, #f05223 0%, #7c2206 100%);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            position: relative; box-shadow: 0 8px 25px rgba(240, 82, 35, 0.25);
            border: 5px solid #fff;
        }
        .seal-inner { text-align: center; color: #fff; }
        .seal-logo { width: 38px; filter: brightness(0) invert(1); margin-bottom: 2px; }
        .seal-text { font-size: 0.5rem; font-weight: 900; letter-spacing: 1.5px; text-transform: uppercase; }

        /* Print Bar Customization */
        .print-bar {
            position: fixed; top: 0; left: 0; right: 0;
            background: #1e293b; color: #fff;
            padding: 15px 40px; display: flex;
            align-items: center; justify-content: space-between;
            z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        .btn-download {
            background: #f05223; color: #fff; border: none;
            padding: 10px 25px; border-radius: 6px;
            font-weight: 700; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
            transition: 0.2s;
        }
        .btn-download:hover { background: #d9441a; }
        .btn-download:disabled { background: #94a3b8; cursor: not-allowed; }

        @media print {
            body { background: #fff; padding: 0; }
            .print-bar { display: none; }
            .cert-wrapper { box-shadow: none; border: none; }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<body>

    <div class="print-bar">
        <div style="font-size:1.1rem; font-weight:800; letter-spacing:1px; display:flex; align-items:center; gap:10px;">
            <span style="color:#f05223">★</span> IITS OFFICIAL CERTIFICATION
        </div>
        <div style="display:flex; gap:12px;">
            <button class="btn-download" id="download-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                    <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                </svg>
                <span id="btn-text">Generate Premium PDF</span>
            </button>
            <a href="javascript:window.history.back()" style="background:rgba(255,255,255,0.1); color:#fff; text-decoration:none; padding:10px 20px; border-radius:6px; font-size:0.9rem; border:1px solid rgba(255,255,255,0.2);">Return</a>
        </div>
    </div>

    <div class="main-container">
        <div class="cert-wrapper" id="certificate-area">
            <div class="cert-frame">
                <div class="cert-inner">
                    <div class="shape-lines"></div>
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="watermark"></div>
                    
                    <div class="corner corner-tl"></div>
                    <div class="corner corner-tr"></div>
                    <div class="corner corner-bl"></div>
                    <div class="corner corner-br"></div>

                    <div class="cert-header">
                        <img src="{{ asset('uploads/settings/'.\App\Models\SiteSetting::getValue('site_logo_light', 'logo.png')) }}" alt="IITS Logo" class="cert-logo">
                        <div class="cert-subtitle">Excellence in Professional Development</div>
                    </div>

                    <div class="cert-body">
                        <div class="presents-text">This Academic Credential is Presented to</div>
                        <div class="cert-title">Certificate of Completion</div>

                        <div class="awarded-to">In Recognition of Outstanding Achievement by</div>
                        <div class="recipient-name">{{ $user->name }}</div>

                        <p class="cert-description">
                            For the successful completion of the intensive <strong>{{ $account->category->name }} Internship Program</strong>. 
                            The candidate has demonstrated mastery of professional workflows, technical excellence, and 
                            a commitment to innovative problem-solving in a real-world environment.
                        </p>

                        <div class="cert-stats">
                            <div class="stat-item">
                                <div class="stat-label">Specialization</div>
                                <div class="stat-value">{{ $account->category->name }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Internship ID</div>
                                <div class="stat-value">#{{ str_pad($account->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Final Performance</div>
                                <div class="stat-value" style="color:#f05223">{{ $account->performance_score }}% / 100%</div>
                            </div>
                        </div>
                    </div>

                    <div class="cert-footer">
                        <div class="signature-block">
                            <div class="sig-line"></div>
                            <div class="sig-name">Program Director</div>
                            <div class="sig-role">Innovative IT Solutions</div>
                        </div>

                        <div class="badge-group">
                            <div class="qr-code">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('/verify-certificate/'.$account->certificate->certificate_number)) }}" alt="QR" style="width:100%; height:100%;">
                            </div>
                            <div class="cert-seal">
                                <div class="seal-inner">
                                    <img src="{{ asset('uploads/settings/'.\App\Models\SiteSetting::getValue('site_logo_light', 'logo.png')) }}" class="seal-logo" alt="">
                                    <div class="seal-text">VERIFIED</div>
                                    <div class="seal-text" style="font-size:0.35rem; opacity:0.8;">OFFICIAL RECORD</div>
                                </div>
                            </div>
                        </div>

                        <div class="signature-block">
                            <div class="sig-line"></div>
                            <div class="sig-name">{{ $account->mentor?->name ?? 'Head of Department' }}</div>
                            <div class="sig-role">Industry Mentor</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('download-btn').addEventListener('click', function () {
            const btn = this;
            const btnText = document.getElementById('btn-text');
            const element = document.getElementById('certificate-area');
            
            // UI Feedback
            btn.disabled = true;
            btnText.innerText = "Processing Premium PDF...";
            
            const opt = {
                margin:       0,
                filename:     'IITS_Official_Certificate_{{ str_replace(" ", "_", $user->name) }}.pdf',
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { 
                    scale: 2, 
                    useCORS: true, 
                    letterRendering: true,
                    logging: false,
                    scrollY: 0,
                    scrollX: 0
                },
                jsPDF:        { 
                    unit: 'px', 
                    format: [1120, 820], 
                    orientation: 'landscape'
                }
            };

            // Start conversion
            html2pdf().set(opt).from(element).save().then(() => {
                btn.disabled = false;
                btnText.innerText = "Generate Premium PDF";
            }).catch(err => {
                console.error(err);
                btn.disabled = false;
                btnText.innerText = "Try Again";
            });
        });
    </script>
</body>
</html>
