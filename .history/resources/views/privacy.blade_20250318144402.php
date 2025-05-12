@extends('layouts.app')

@section('title', 'Privacy Policy - MyArtisan')
@section('description', 'MyArtisan\'s privacy policy explains how we collect, use, and protect your personal information when using our platform.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-amber-800">Privacy Policy</h1>
            <p class="mt-4 text-gray-600">Last Updated: {{ date('F d, Y', strtotime('-2 months')) }}</p>
        </div>
    </div>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto prose prose-amber lg:prose-lg">
            <h2>Introduction</h2>
            <p>
                At MyArtisan, we respect your privacy and are committed to protecting your personal data. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our platform.
            </p>
            <p>
                Please read this Privacy Policy carefully. If you do not agree with the terms of this Privacy Policy, please do not access the platform.
            </p>

            <h2>Information We Collect</h2>

            <h3>Personal Information</h3>
            <p>We may collect personal information that you provide directly to us, including:</p>
            <ul>
                <li>Contact information (such as name, email address, phone number)</li>
                <li>Account information (such as username, password)</li>
                <li>Profile information (such as profile photos, biography)</li>
                <li>Transaction information (such as purchase history, shipping details)</li>
                <li>Communications with us (such as customer service inquiries)</li>
            </ul>

            <h3>For Artisans</h3>
            <p>If you register as an artisan on our platform, we may collect additional information including:</p>
            <ul>
                <li>Business details (such as business name, location, craft categories)</li>
                <li>Portfolio images and descriptions</li>
                <li>Certification and qualification information</li>
                <li>Banking and payment information</li>
            </ul>

            <h3>Automatically Collected Information</h3>
            <p>When you visit our platform, we may automatically collect certain information, including:</p>
            <ul>
                <li>Device information (such as IP address, browser type, operating system)</li>
                <li>Usage information (such as pages visited, time spent on the platform)</li>
                <li>Location information (such as general geographic location based on IP address)</li>
                <li>Cookies and similar tracking technologies</li>
            </ul>

            <h2>How We Use Your Information</h2>
            <p>We may use the information we collect for various purposes, including:</p>
            <ul>
                <li>Providing, maintaining, and improving our platform</li>
                <li>Processing transactions and managing your account</li>
                <li>Connecting clients with appropriate artisans</li>
                <li>Communicating with you about services, updates, and promotions</li>
                <li>Personalizing your experience on our platform</li>
                <li>Analyzing platform usage and trends</li>
                <li>Protecting the security and integrity of our platform</li>
                <li>Complying with legal obligations</li>
            </ul>

            <h2>Data Sharing and Disclosure</h2>
            <p>We may share your information in the following circumstances:</p>
            <ul>
                <li>With service providers who perform services on our behalf</li>
                <li>Between clients and artisans to facilitate service bookings</li>
                <li>For legal purposes, such as complying with laws or responding to legal requests</li>
                <li>In connection with a business transaction, such as a merger or acquisition</li>
                <li>With your consent or at your direction</li>
            </ul>

            <h2>Data Security</h2>
            <p>
                We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. However, no method of transmission over the Internet or electronic storage is 100% secure.
            </p>

            <h2>Your Rights and Choices</h2>
            <p>Depending on your location, you may have certain rights regarding your personal information, including:</p>
            <ul>
                <li>Accessing, correcting, or deleting your personal information</li>
                <li>Objecting to or restricting certain processing activities</li>
                <li>Data portability</li>
                <li>Withdrawing consent (where processing is based on consent)</li>
            </ul>
            <p>
                To exercise these rights, please contact us using the information provided in the "Contact Us" section below.
            </p>

            <h2>Cookies and Tracking Technologies</h2>
            <p>
                We use cookies and similar tracking technologies to collect information about your browsing activities and to distinguish you from other users of our platform. This helps us provide you with a good experience when you browse our platform and also allows us to improve our services.
            </p>
            <p>
                You can set your browser to refuse all or some browser cookies, or to alert you when cookies are being sent. If you disable or refuse cookies, please note that some parts of the platform may be inaccessible or not function properly.
            </p>

            <h2>International Data Transfers</h2>
            <p>
                Your information may be transferred to, and processed in, countries other than the country in which you reside. These countries may have different data protection laws than your country of residence. We will take appropriate measures to ensure that your personal information remains protected in accordance with this Privacy Policy.
            </p>

            <h2>Children's Privacy</h2>
            <p>
                Our platform is not intended for children under the age of 16, and we do not knowingly collect personal information from children under 16. If you are a parent or guardian and believe that your child has provided us with personal information, please contact us.
            </p>

            <h2>Changes to This Privacy Policy</h2>
            <p>
                We may update this Privacy Policy from time to time. The updated version will be indicated by an updated "Last Updated" date and the updated version will be effective as soon as it is accessible. We encourage you to review this Privacy Policy frequently to be informed of how we are protecting your information.
            </p>

            <h2>Contact Us</h2>
            <p>
                If you have questions or concerns about this Privacy Policy or our data practices, please contact us at:
            </p>
            <div class="bg-amber-50 p-4 rounded-lg">
                <p class="mb-1"><strong>MyArtisan Morocco</strong></p>
                <p class="mb-1">Email: privacy@myartisan.ma</p>
                <p class="mb-1">Address: 123 Place de l'Artisanat, Marrakech, Morocco</p>
                <p>Phone: +212 5XX-XXXXXX</p>
            </div>
        </div>
    </div>
@endsection
