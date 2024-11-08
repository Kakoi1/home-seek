{{-- resources/views/terms-of-service.blade.php --}}

@extends('layouts.app')

@section('title', 'Terms of Service')

@section('content')
<style>
    /* public/css/privacy-policy.css */

    /* Body and Layout */


    .containers {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    h1,
    h2,
    h3 {
        color: #2c3e50;
    }

    p {
        margin-bottom: 1.5em;
        font-size: 1rem;
        color: #555;
    }

    ul {
        list-style-type: disc;
        padding-left: 20px;
        margin-bottom: 1.5em;
    }

    strong {
        font-weight: bold;
    }

    /* Card Styles */
    .cards {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }

    /* Header */
    .card-headers {
        text-align: center;
        padding-bottom: 20px;
    }

    .card-headers h2 {
        font-size: 2rem;
        color: #333;
    }

    /* Section Titles */
    h3 {
        font-size: 1.5rem;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    /* Footer */

    /* Responsive Design */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        .card {
            padding: 15px;
        }

        h2 {
            font-size: 1.5rem;
        }

        h3 {
            font-size: 1.2rem;
        }

        p {
            font-size: 0.9rem;
        }
    }
</style>
<div class="containers">
    <div class="cards">
        <div class="card-headers">
            <h2>Terms of Service</h2>
        </div>
        <div class="card-body">
            <p>Effective date: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>

            <p>Welcome to {{ config('app.name') }}! These Terms of Service ("Terms") govern your use of our website,
                services, and applications ("Services"). By accessing or using our Services, you agree to be bound by
                these Terms.</p>

            <h3>1. Acceptance of Terms</h3>
            <p>By using our Services, you agree to comply with and be bound by these Terms. If you do not agree to these
                Terms, you must not use our Services.</p>

            <h3>2. Changes to the Terms</h3>
            <p>We reserve the right to modify these Terms at any time. When we do, we will update the "Effective date"
                at the top of this page. Your continued use of the Services after any changes constitutes your
                acceptance of the revised Terms.</p>

            <h3>3. User Responsibilities</h3>
            <p>As a user of our Services, you agree to:</p>
            <ul>
                <li>Provide accurate and complete information when registering for the Services.</li>
                <li>Comply with all applicable laws and regulations while using our Services.</li>
                <li>Not use our Services for any unlawful or prohibited activities.</li>
            </ul>

            <h3>4. Account Security</h3>
            <p>You are responsible for maintaining the confidentiality of your account credentials and for all
                activities under your account. Notify us immediately if you believe your account has been compromised.
            </p>

            <h3>5. Restrictions on Use</h3>
            <p>You may not use our Services to:</p>
            <ul>
                <li>Engage in illegal activities.</li>
                <li>Impersonate any person or entity, or falsely state or otherwise misrepresent your affiliation with
                    any person or entity.</li>
                <li>Distribute malware or any harmful code or files.</li>
            </ul>

            <h3>6. Termination of Services</h3>
            <p>We may suspend or terminate your access to the Services at our discretion, without notice, if we believe
                you have violated these Terms or are engaging in unlawful activity.</p>

            <h3>7. Limitation of Liability</h3>
            <p>Our liability to you is limited to the maximum extent permitted by law. We are not liable for any
                indirect, incidental, special, or consequential damages, or any loss of data, revenue, or profits
                arising from your use of our Services.</p>

            <h3>8. Indemnification</h3>
            <p>You agree to indemnify and hold harmless {{ config('app.name') }}, its affiliates, officers, employees,
                and agents from any claims, damages, liabilities, and expenses arising from your use of our Services or
                violation of these Terms.</p>

            <h3>9. Governing Law</h3>
            <p>These Terms shall be governed by and construed in accordance with the laws of your jurisdiction, without
                regard to its conflict of law principles. Any disputes arising under these Terms shall be subject to the
                exclusive jurisdiction of the courts located in your jurisdiction.</p>

            <h3>10. Contact Us</h3>
            <p>If you have any questions about these Terms of Service, please contact us at:</p>
            <p><strong>Email:</strong> lopezrolandshane@gmail.com</p>
            <p><strong>Address:</strong> Ward 2, Minglanilla, Cebu</p>
        </div>
    </div>
</div>
@endsection