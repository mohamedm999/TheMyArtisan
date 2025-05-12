@extends('layouts.app')

@section('title', 'Terms of Service - MyArtisan')
@section('description', 'MyArtisan\'s terms and conditions for using our platform, including artisan and customer guidelines, payment terms, and user responsibilities.')

@section('content')
    <div class="bg-amber-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-amber-800">Terms of Service</h1>
            <p class="mt-4 text-gray-600">Last Updated: {{ date('F d, Y', strtotime('-1 month')) }}</p>
        </div>
    </div>

    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto prose prose-amber lg:prose-lg">
            <h2>1. Acceptance of Terms</h2>
            <p>
                Welcome to MyArtisan. By accessing or using our platform, website, and services, you agree to be bound by these Terms of Service. These Terms constitute a legally binding agreement between you and MyArtisan regarding your use of the platform.
            </p>
            <p>
                If you do not agree to these terms, please do not use our platform or services.
            </p>

            <h2>2. Platform Description</h2>
            <p>
                MyArtisan is a platform that connects skilled Moroccan artisans with customers seeking authentic craftsmanship. We provide a marketplace for artisans to showcase their work, manage bookings, and interact with customers.
            </p>

            <h2>3. User Accounts</h2>
            <h3>3.1 Registration</h3>
            <p>
                To use certain features of the platform, you must register for an account. When you register, you agree to provide accurate, current, and complete information about yourself.
            </p>

            <h3>3.2 Account Responsibilities</h3>
            <p>
                You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. You agree to notify us immediately of any unauthorized use of your account.
            </p>

            <h3>3.3 Account Types</h3>
            <p>
                Our platform supports two primary types of accounts: Artisan accounts and Client accounts. Different terms may apply depending on the type of account you register for.
            </p>

            <h2>4. Artisan Terms</h2>
            <p>
                If you register as an artisan, you additionally agree to:
            </p>
            <ul>
                <li>Provide accurate information about your craft, skills, and credentials</li>
                <li>Upload only authentic content that represents your own work</li>
                <li>Honor bookings and commitments made through our platform</li>
                <li>Comply with all applicable laws and regulations regarding your craft and business operations</li>
                <li>Pay applicable platform fees as described in our fee schedule</li>
            </ul>

            <h2>5. Client Terms</h2>
            <p>
                If you register as a client, you additionally agree to:
            </p>
            <ul>
                <li>Provide accurate information when creating bookings or contacting artisans</li>
                <li>Honor bookings and appointments made through our platform</li>
                <li>Pay for services as agreed upon booking</li>
                <li>Treat artisans with respect and professionalism</li>
            </ul>

            <h2>6. Booking and Payment Terms</h2>
            <h3>6.1 Booking Process</h3>
            <p>
                Our platform facilitates bookings between clients and artisans. Once a booking is confirmed, both parties are expected to honor the commitment.
            </p>

            <h3>6.2 Payment Processing</h3>
            <p>
                All payments are processed through our secure payment system. We may use third-party payment processors, and their terms of service will apply to payment transactions.
            </p>

            <h3>6.3 Cancellation Policy</h3>
            <p>
                Cancellation policies vary depending on the artisan's terms. Please refer to the specific booking details for applicable cancellation policies.
            </p>

            <h2>7. Content and Intellectual Property</h2>
            <h3>7.1 User Content</h3>
            <p>
                By uploading or sharing content on our platform, you grant MyArtisan a non-exclusive, worldwide, royalty-free license to use, reproduce, modify, and display your content for the purpose of operating and improving the platform.
            </p>

            <h3>7.2 Intellectual Property Rights</h3>
            <p>
                All intellectual property rights in the platform and its content (excluding user content) are owned by MyArtisan or its licensors. Nothing in these Terms grants you a right or license to use any trademark, design right, or copyright owned or controlled by MyArtisan.
            </p>

            <h2>8. Prohibited Activities</h2>
            <p>
                You agree not to engage in any of the following activities:
            </p>
            <ul>
                <li>Using the platform for any illegal purpose</li>
                <li>Violating any local, state, national, or international law</li>
                <li>Impersonating any person or entity</li>
                <li>Harassment, abuse, or harm of another user</li>
                <li>Uploading false, misleading, or infringing content</li>
                <li>Attempting to access restricted areas of the platform</li>
                <li>Interfering with or disrupting the platform's functionality</li>
            </ul>

            <h2>9. Limitation of Liability</h2>
            <p>
                To the maximum extent permitted by law, MyArtisan shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly.
            </p>
            <p>
                MyArtisan serves as a platform connecting clients and artisans, but we do not guarantee the quality, safety, or legality of artisan services, nor the accuracy of listings.
            </p>

            <h2>10. Dispute Resolution</h2>
            <p>
                In the event of any dispute between users, we encourage you to first attempt to resolve the issue directly. If that is not possible, please contact our support team who will try to help mediate the dispute.
            </p>

            <h2>11. Termination</h2>
            <p>
                We may terminate or suspend your account at any time, with or without cause, without prior notice or liability. Upon termination, your right to use the platform will immediately cease.
            </p>

            <h2>12. Changes to Terms</h2>
            <p>
                We reserve the right to modify these Terms at any time. We will provide notice of significant changes by posting the updated Terms on our website and updating the "Last Updated" date. Your continued use of the platform after such changes constitutes your acceptance of the new Terms.
            </p>

            <h2>13. Governing Law</h2>
            <p>
                These Terms shall be governed by and construed in accordance with the laws of Morocco, without regard to its conflict of law provisions.
            </p>

            <h2>14. Contact Us</h2>
            <p>
                If you have any questions about these Terms, please contact us at:
            </p>
            <div class="bg-amber-50 p-4 rounded-lg">
                <p class="mb-1">Email: terms@myartisan.ma</p>
                <p class="mb-1">Address: 123 Place de l'Artisanat, Marrakech, Morocco</p>
                <p>Phone: +212 5XX-XXXXXX</p>
            </div>
        </div>
    </div>
@endsection
