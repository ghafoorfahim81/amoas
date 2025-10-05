@extends('layouts.app', ['title' => __('app.welcome_page_title')])

@section('content')

    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.privacy_title') }}</h1>
            <p class="promo-desc text-center">
                {{ __('app.privacy_subtitle') }}
            </p>
        </div>
    </div>

    <div class="container">
        <div class="content">
            <div class="row">

                @php
                    $locale = app()->getLocale();
                @endphp

                @if ($locale == 'en')
                    <div class="col-md-12">
                    <p>
                        <strong>Data Privacy Notice for</strong>
                        <strong>
                            (AMOAS) Afghanistan Missions Online Appointment System.
                        </strong>
                    </p>
                    <p>
                        <strong>Effective Date: 26.08.2024</strong>
                    </p>
                    <p>
                        The General Consulates and Embassies of Afghanistan that implements this
                        system (AMOAS) are committed to protecting your personal information and
                        ensuring your privacy is respected. This Data Privacy Notice explains how we
                        collect, use, store, and protect your personal data when you use our online
                        appointment system.
                    </p>
                    <p>
                        <strong>1. Information We Collect</strong>
                    </p>
                    <p>
                        To facilitate your appointment with the General Consulates and Embassies of Afghanistan, we may collect the following personal information:
                    </p>
                    <ul type="disc">
                        <li>
                            <strong>Name:</strong> To identify and address you correctly.
                        </li>
                        <li>
                            <strong>Email Address:</strong> To communicate with you regarding your
                            appointment and other consular services.
                        </li>
                        <li>
                            <strong>Phone Number:</strong> To contact you in case of any urgent
                            changes or additional information related to your appointment.
                        </li>
                        <li>
                            <strong>Address:</strong> To verify your residency and for consular
                            record-keeping purposes.
                        </li>
                        <li>
                            <strong>ID Card Number:</strong> This data is collected to identify you
                            using an official document. It can be any valid identification number
                            from Afghanistan or your host country.
                        </li>
                    </ul>
                    <p>
                        <strong>2. Purpose of Data Collection</strong>
                    </p>
                    <p>
                        The personal information you provide will be used solely for the following
                        purposes:
                    </p>
                    <ul type="disc">
                        <li>
                            <strong>Appointment Scheduling:</strong> To reserve your preferred
                            appointment date and time at the Consulate.
                        </li>
                        <li>
                            <strong>Communication:</strong> To send you confirmation, reminders, and
                            any necessary updates or changes regarding your appointment.
                        </li>
                        <li>
                            <strong>Consular Services:</strong> To facilitate the provision of
                            consular services that you may require.
                        </li>
                        <li>
                            <strong>Internal Record-Keeping:</strong> To maintain accurate records
                            for administrative and legal purposes.
                        </li>
                    </ul>
                    <p>
                        <strong>3. Data Sharing and Disclosure</strong>
                    </p>
                    <p>
                        The information you provide is strictly confidential and will only be
                        accessed by authorized personnel within the General Consulates and Embassies of Afghanistan. We will not share your personal data with 
                        third parties, except as required by law or to fulfill a specific 
                        consular service you have requested.
                    </p>
                    <p>
                        <strong>4. Data Security</strong>
                    </p>
                    <p>
                        We take appropriate technical and organizational measures to protect your
                        personal data against unauthorized access, alteration, disclosure, or
                        destruction. Our online appointment system and other consular systems are
                        secured to ensure your data is handled with the utmost care and
                        confidentiality.
                    </p>
                    <p>
                        <strong>5. Data Retention</strong>
                    </p>
                    <p>
                        Your data will be securely stored in our databases and may also be utilized by the government of Afghanistan for statistical purposes. This means that, in addition to the primary uses outlined in this notice, your information might be aggregated and analyzed to support statistical research, policy development, and other governmental functions. Rest assured that any use of your data for these purposes will be handled with strict confidentiality and in accordance with applicable data protection regulations.
                    </p>
                    <p>
                        <strong>6. Your Rights</strong>
                    </p>
                    <p>
                        You have the following rights regarding your personal data:
                    </p>
                    <ul type="disc">
                        <li>
                            <strong>Access:</strong> You can request access to the personal data we
                            hold about you by signing in to your account.
                        </li>
                        <li>
                            <strong>Correction:</strong> You can request correction of any
                            inaccurate or incomplete data by signing in to your account.
                        </li>
                    </ul>
                    <p>
                        To exercise any of these rights, please contact us to applied Afghanistan diplomatic mission.
                    </p>
                    <p>
                        <strong>7. Changes to This Notice</strong>
                    </p>
                    <p>
                        We may update this Data Privacy Notice from time to time to reflect changes
                        in our practices or legal obligations. We encourage you to review this
                        notice periodically.
                    </p>
                    <p>
                        By using our online appointment system, you acknowledge that you have read,
                        understood, and agree to the terms of this Data Privacy Notice.
                    </p>
                </div>
                @else


                <div class="col-md-12">
                    <div>
                        <div>
                        <strong>Datenschutzmitteilung f&uuml;r (AMOAS) Afghanistan Missions Online-Terminvereinbarungssystem</strong ><p><strong>G&uuml;ltig ab: 26.08.2024</strong></p>
                        <p>Die Generalkonsulate und Botschaften Afghanistans, die dieses System (AMOAS) betreiben, verpflichten sich, Ihre pers&ouml;nlichen Informationen zu sch&uuml;tzen und Ihre Privatsph&auml;re zu respektieren. Diese Datenschutzmitteilung erkl&auml;rt, wie wir Ihre pers&ouml;nlichen Daten erheben, verwenden, speichern und sch&uuml;tzen, wenn Sie unser Online-Terminvereinbarungssystem nutzen.</p>
                        <ol>
                        <li>
                        <p><strong>Informationen, die wir sammeln</strong><br />Um Ihren Termin bei den Generalkonsulaten und Botschaften Afghanistans zu erleichtern, k&ouml;nnen wir die folgenden pers&ouml;nlichen Informationen sammeln:<br />&bull; <strong>Name:</strong> Um Sie korrekt zu identifizieren und anzusprechen.<br />&bull; <strong>E-Mail-Adresse:</strong> Um mit Ihnen bez&uuml;glich Ihres Termins und anderer konsularischer Dienstleistungen zu kommunizieren.<br />&bull; <strong>Telefonnummer:</strong> Um Sie im Falle dringender &Auml;nderungen oder zus&auml;tzlicher Informationen zu Ihrem Termin zu kontaktieren.<br />&bull; <strong>Adresse:</strong> Um Ihren Wohnsitz zu &uuml;berpr&uuml;fen und f&uuml;r konsularische Aufzeichnungen.<br />&bull; <strong>Personalausweisnummer:</strong> Diese Daten werden gesammelt, um Sie anhand eines offiziellen Dokuments zu identifizieren. Es kann sich um jede g&uuml;ltige Identifikationsnummer aus Afghanistan oder Ihrem Gastland handeln.</p>
                        </li>
                        <li>
                        <p><strong>Zweck der Datenerhebung</strong><br />Die von Ihnen bereitgestellten pers&ouml;nlichen Informationen werden ausschlie&szlig;lich f&uuml;r folgende Zwecke verwendet:<br />&bull; <strong>Terminplanung:</strong> Um das gew&uuml;nschte Datum und die Uhrzeit Ihres Termins im Konsulat zu reservieren.<br />&bull; <strong>Kommunikation:</strong> Um Ihnen Best&auml;tigungen, Erinnerungen und notwendige Updates oder &Auml;nderungen zu Ihrem Termin zu senden.<br />&bull; <strong>Konsularische Dienstleistungen:</strong> Um die Bereitstellung der von Ihnen ben&ouml;tigten konsularischen Dienstleistungen zu erleichtern.<br />&bull; <strong>Interne Aufzeichnungen:</strong> Um genaue Aufzeichnungen f&uuml;r administrative und rechtliche Zwecke zu f&uuml;hren.</p>
                        </li>
                        <li>
                        <p><strong>Datenweitergabe und Offenlegung</strong><br />Die von Ihnen bereitgestellten Informationen sind streng vertraulich und werden nur von autorisiertem Personal innerhalb der Generalkonsulate und Botschaften Afghanistans eingesehen. Wir geben Ihre pers&ouml;nlichen Daten nicht an Dritte weiter, es sei denn, dies ist gesetzlich vorgeschrieben oder zur Erf&uuml;llung einer spezifischen konsularischen Dienstleistung erforderlich, die Sie angefordert haben.</p>
                        </li>
                        <li>
                        <p><strong>Datensicherheit</strong><br />Wir treffen geeignete technische und organisatorische Ma&szlig;nahmen, um Ihre pers&ouml;nlichen Daten vor unbefugtem Zugriff, &Auml;nderung, Offenlegung oder Zerst&ouml;rung zu sch&uuml;tzen. Unser Online-Terminvereinbarungssystem und andere konsularische Systeme sind gesichert, um sicherzustellen, dass Ihre Daten mit gr&ouml;&szlig;ter Sorgfalt und Vertraulichkeit behandelt werden.</p>
                        </li>
                        <li>
                        <p><strong>Datenaufbewahrung</strong><br />Ihre Daten werden sicher in unseren Datenbanken gespeichert und k&ouml;nnen auch von der Regierung Afghanistans f&uuml;r statistische Zwecke verwendet werden. Das bedeutet, dass Ihre Informationen zus&auml;tzlich zu den in dieser Mitteilung aufgef&uuml;hrten Hauptverwendungen aggregiert und analysiert werden k&ouml;nnten, um statistische Forschungen, Politikentwicklung und andere Regierungsfunktionen zu unterst&uuml;tzen. Seien Sie versichert, dass jede Nutzung Ihrer Daten f&uuml;r diese Zwecke mit strikter Vertraulichkeit und gem&auml;&szlig; den geltenden Datenschutzvorschriften erfolgt.</p>
                        </li>
                        <li>
                        <p><strong>Ihre Rechte</strong><br />Sie haben folgende Rechte in Bezug auf Ihre pers&ouml;nlichen Daten:<br />&bull; <strong>Zugriff:</strong> Sie k&ouml;nnen den Zugriff auf die pers&ouml;nlichen Daten, die wir &uuml;ber Sie haben, beantragen, indem Sie sich in Ihr Konto einloggen.<br />&bull; <strong>Korrektur:</strong> Sie k&ouml;nnen die Korrektur ungenauer oder unvollst&auml;ndiger Daten beantragen, indem Sie sich in Ihr Konto einloggen.<br />Um eines dieser Rechte auszu&uuml;ben, kontaktieren Sie bitte die zust&auml;ndige afghanische diplomatische Vertretung.</p>
                        </li>
                        <li>
                        <p><strong>&Auml;nderungen dieser Mitteilung</strong><br />Wir k&ouml;nnen diese Datenschutzmitteilung von Zeit zu Zeit aktualisieren, um &Auml;nderungen in unseren Praktiken oder gesetzlichen Verpflichtungen widerzuspiegeln. Wir empfehlen Ihnen, diese Mitteilung regelm&auml;&szlig;ig zu &uuml;berpr&uuml;fen.</p>
                        </li>
                        </ol>
                        <p>Durch die Nutzung unseres Online-Terminvereinbarungssystems erkennen Sie an, dass Sie diese Datenschutzmitteilung gelesen, verstanden und den Bedingungen zugestimmt haben.</p>
                        </div>
                        </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
