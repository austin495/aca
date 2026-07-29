<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    function prepareFormData($postData, $keys) {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = htmlspecialchars(trim($postData[$key] ?? ''));
        }
        return $data;
    }

    // $trackDriveData = [
    //     'lead_token' => $_POST['lead_token'],
    //     'traffic_source_id' => $_POST['traffic_source_id'],
    //     'caller_id' => $_POST['caller_id'],
    //     'first_name' => $_POST['first_name'],
    //     'last_name' => $_POST['last_name'],
    //     'email' => $_POST['email'],
    //     'dob' => $_POST['dob'],
    //     'state' => $_POST['state'],
    //     'city' => $_POST['city'],
    //     'zip' => $_POST['zip'],
    //     'source_url' => $_POST['source_url'],
    //     'ip_address' => $_POST['ip_address'],
    //     'original_lead_submit_date' => $_POST['original_lead_submit_date'],
    //     'trusted_form_cert_url' => $_POST['trusted_form_cert_url'],
    //     'jornaya_leadid' => $_POST['jornaya_leadid'],
    // ];

    // $trackDriveUrl = "https://evolvetech-innovations.trackdrive.com/api/v1/leads";
    // $ch = curl_init($trackDriveUrl);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POST, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($trackDriveData));
    // curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //     'Content-Type: application/x-www-form-urlencoded',
    // ]);

    // $trackDriveResponse = curl_exec($ch);
    // $trackDriveHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // $curlError = curl_error($ch);
    // curl_close($ch);

    // if ($curlError) {
    //     error_log("TrackDrive cURL Error: $curlError");
    //     echo json_encode(['status' => 'error', 'message' => "TrackDrive cURL Error: $curlError"]);
    //     exit;
    // }

    // if ($trackDriveHttpCode === 200) {
    //     $responseMessage = 'Existing Lead Modified';
    //     echo json_encode(['status' => 'success', 'message' => $responseMessage]);
    // } elseif ($trackDriveHttpCode === 201) {
    //     $responseMessage = 'New Lead Submitted';
    //     echo json_encode(['status' => 'success', 'message' => $responseMessage]);
    // } elseif ($trackDriveHttpCode === 422) {
    //     $responseMessage = 'DNC Lead';
    //     echo json_encode(['status' => 'error', 'message' => "$responseMessage $trackDriveResponse"]);
    // } else {
    //     $responseMessage = "TrackDrive API Error: $trackDriveResponse";
    //     echo json_encode(['status' => 'error', 'message' => $responseMessage]);
    // }

    // $responseDecoded = json_decode($trackDriveResponse, true);
    // $status = $responseDecoded['status'] ?? $responseMessage;
    // $success = $responseDecoded['success'] ?? ($trackDriveHttpCode === 200 || $trackDriveHttpCode === 201 || $trackDriveHttpCode === 422);

    // $minimalResponse = ['status' => $status, 'success' => $success];

    $googleSheetKeys = ['first_name', 'last_name', 'caller_id', 'email', 'dob', 'state', 'city', 'zip', 'gender', 'house_hold_size', 'house_hold_income', 'address', 'xxTrustedFormToken', 'TrustedFormPingUrl', 'jornaya_leadid', 'ip_address', 'traffic_source_id', 'ip_region', 'ip_city', 'ip_country'];
    $googleSheetData = prepareFormData($_POST, $googleSheetKeys);
    // $googleSheetData['api_response'] = json_encode(['status' => $status, 'message' => $responseMessage]);

    $googleSheetUrl = 'https://script.google.com/macros/s/AKfycbxF-qYrIAEFGIPfoCfLPYU9p8_9-5CPlarkTogsd3JeWbdpdqKHsuEQYy8Y8oQkyMMD/exec';
    $postData = http_build_query($googleSheetData);
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => $postData,
        ],
    ];
    $context = stream_context_create($options);
    $googleResult = file_get_contents($googleSheetUrl, false, $context);

    if ($googleResult === FALSE) {
        error_log('Failed to submit data to Google Sheets');
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit data']);
        exit;
    } else {
        echo json_encode(['status' => 'success', 'message' => 'Data successfully submitted']);
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Easy ACA Coverage</title>
    <meta
      name="description"
      content="Responsive HTML/CSS recreation of the Easy ACA Coverage landing page."
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>Easy ACA Coverage - Get a Quote</title>
    <link rel="icon" href="https://easyacacoverage.com/wp-content/uploads/2024/10/Group-3696-150x150.png" sizes="32x32" />
    <link rel="icon" href="https://easyacacoverage.com/wp-content/uploads/2024/10/Group-3696-300x300.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://easyacacoverage.com/wp-content/uploads/2024/10/Group-3696-300x300.png" />
    <style>
      :root {
        --green: #003d25;
        --deep: #00331f;
        --lime: #a8dc75;
        --pale: #f2f7ec;
        --muted: #6d8278;
      }
      * {
        box-sizing: border-box;
      }
      html,
      body {
        margin: 0;
        background: #fff;
        color: #073e2a;
        font-family: "IBM Plex Sans", Arial, sans-serif;
      }
      body {
        display: block;
        width: 100%;
        overflow-x: hidden;
      }
      .page {
        width: 100%;
        max-width: none;
        background: #fff;
        overflow: hidden;
        box-shadow: none;
      }
      a {
        color: inherit;
        text-decoration: none;
      }
      .notice {
        height: 48.13px;
        background: #a8dc75;
        text-align: center;
        font-size: 18px;
        font-weight: 600;
        line-height: 48.13px;
        color: #032f1a;
      }
      .hero {
        height: 929.45px;
        position: relative;
        color: #fff;
        background-image: url("https://easyacacoverage.com/wp-content/uploads/2026/07/Frame-3594.webp");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        overflow: hidden;
      }
      .top-card {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 21.06px;
        width: 1140px;
        height: 111.29px;
        border-radius: 21.06px;
        background: linear-gradient(90deg, #ffffff19, #ffffff10);
        border: 3.01px solid #ffffff10;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 39.1px;
        z-index: 3;
        backdrop-filter: blur(50px);
      }
      .logo-crop {
        width: 150px;
        object-fit: contain;
      }
      .phone {
        display: flex;
        align-items: center;
        gap: 18.05px;
        text-align: left;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.15;
      }
      .phone .icon {
        width: 51.13px;
        height: 51.13px;
        border-radius: 50%;
        background: #74d20d;
        color: #123f26;
        display: grid;
        place-items: center;
        font-size: 30.08px;
        font-family: "IBM Plex Sans", Arial, sans-serif;
      }
      .phone b {
        font-size: 27.07px;
        display: block;
      }
      .hero-copy {
        position: absolute;
        left: calc(50% - 547.44px);
        top: 198.52px;
        width: 1118.94px;
        z-index: 4;
      }
      .hero-title {
        font-size: 93.25px;
        line-height: 1.03;
        font-weight: 600;
        letter-spacing: -3.31px;
        margin: 0;
        width: 1112.93px;
      }
      .hero-title .lime {
        color: #9bd269;
      }
      .hero-title em {
        font-style: italic;
        font-weight: 700;
      }
      .avatars {
        width: 252.66px;
        height: 87.23px;
        object-fit: cover;
        border-radius: 60.16px;
      }
      .explore {
        position: absolute;
        right: 3.01px;
        top: 126.33px;
        width: 297.78px;
        font-size: 22px;
        font-style: italic;
        color: #dce9df;
        line-height: 1.2;
        font-weight: 400;
      }
      .hero-body {
        position: absolute;
        left: calc(50% - 556.46px);
        top: 595.57px;
        width: 300.79px;
        font-size: 22px;
        line-height: 1.45;
        color: #fff9;
        font-weight: 400;
        z-index: 4;
      }
      .hero-family {
        position: absolute;
        left: calc(50% - 312.82px);
        bottom: 0;
        width: 592.56px;
        height: 502.32px;
        object-fit: cover;
        z-index: 2;
        mix-blend-mode: normal;
      }
      .trust {
        position: absolute;
        left: calc(50% + 261.69px);
        top: 577.52px;
        width: 297.78px;
        height: 228.6px;
        padding: 30.08px 27.07px;
        background: linear-gradient(145deg, #82b761b8, #004126e8);
        border-radius: 12.03px;
        z-index: 4;
        box-shadow: 0 24.06px 54.14px #00180e4a;
      }
      .trust b {
        display: block;
        font-size: 33.09px;
        line-height: 0.9;
        color: #fff;
      }
      .trust p {
        font-size: 15px;
        font-weight: 400;
        line-height: 1.35;
        color: #fff9;
        margin: 21.06px 0 0;
      }
      .trust .arrow {
        position: absolute;
        right: 24.06px;
        top: 21.06px;
        font: 54.14px Arial;
      }
      .intro {
        text-align: center;
        padding: 60px 0;
      }
      .intro h2 {
        font-size: 60.16px;
        margin: 0 0 6.02px;
        letter-spacing: -0.5px;
        color: #032f1a;
      }
      .intro h3 {
        font-size: 30.08px;
        margin: 0;
        color: #176038;
        font-style: italic;
        font-weight: 500;
      }
      .intro p {
        font-size: 21.06px;
        line-height: 1.4;
        color: #698077;
        width: 1127.97px;
        max-width: 80%;
        margin: 30.08px auto 24.06px;
      }
      .action-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 27.07px;
      }
      .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 54.14px;
        padding: 0 36.09px;
        background: #9fd36e;
        color: #073c27;
        border-radius: 9.02px;
        font-size: 21.06px;
        font-weight: 700;
        border: 0;
        cursor: pointer;
      }
      .btn:hover {
        background: #073c27;
        color: #fff;
      }
      .line-arrow {
        width: 141.37px;
        height: 3.01px;
        background: #174a32;
        position: relative;
      }
      .line-arrow:before {
        content: "";
        position: absolute;
        left: 0;
        top: -9.02px;
        width: 18.05px;
        height: 18.05px;
        border-left: 3.01px solid #174a32;
        border-bottom: 3.01px solid #174a32;
        transform: rotate(45deg);
      }
      .works {
        background: #f2f4f3;
        padding: 80px 0;
      }
      .works-head {
        width: 1112.93px;
        margin: auto;
        display: grid;
        grid-template-columns: 415.09px 1fr;
        gap: 36.09px;
        align-items: start;
      }
      .works h2 {
        font-size: 55px;
        margin: 12.03px 0 0;
        letter-spacing: -0.21px;
      }
      .works h2 span {
        color: #9bd166;
      }
      .works-head p {
        font-size: 22px;
        font-weight: 400;
        line-height: 1.45;
        color: #71877d;
        margin: 0;
      }
      .cards {
        width: 1112.93px;
        margin: 60.16px auto 0;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 27.07px;
      }
      .card {
        height: 409.08px;
        background: #dbe2de;
        border-radius: 21.06px;
        overflow: hidden;
        position: relative;
      }
      .card img {
        width: 100%;
        height: 264.7px;
        object-fit: cover;
        display: block;
      }
      .card .mini-icon {
        position: absolute;
        right: 24.06px;
        top: 237.63px;
        width: 51.13px;
        height: 51.13px;
        background: #07532f;
        color: #9bdc68;
        border-radius: 12.03px;
        display: grid;
        place-items: center;
        font-size: 24.06px;
      }
      .card .mini-icon img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
      .card h4 {
        font-size: 22px;
        font-weight: 600;
        letter-spacing: -0.5px;
        margin: 40px 24.06px 6.02px;
        color: #0c3929;
      }
      .card p {
        font-size: 16.54px;
        line-height: 1.35;
        color: #64776f;
        margin: 0 24.06px;
      }
      .guidance {
        background: #fff;
        display: flex;
        align-items: center;
        padding: 80px 0;
      }
      .guidance-inner {
        width: 1064.8px;
        margin: auto;
        display: grid;
        grid-template-columns: 499.31px 1fr;
        gap: 54.14px;
        align-items: center;
      }
      .guidance img {
        width: 499.31px;
        height: 505.33px;
        object-fit: cover;
        border-radius: 51.13px;
        border: 12.03px solid #e0f1cc;
      }
      .guidance h2 {
        font-size: 55px;
        font-weight: 600;
        color: #032f1a;
        line-height: 0.95;
        margin: 0 0 36.09px;
        font-style: italic;
        letter-spacing: -0.24.06px;
      }
      .guidance h3 {
        font-size: 30.08px;
        font-weight: 500;
        line-height: 1.05;
        margin: 0 0 39.1px;
        color: #0c6840;
        font-style: italic;
      }
      .guidance p {
        font-size: 21.06px;
        font-weight: 400;
        line-height: 1.5;
        color: #718279;
        margin: 0 0 42.11px;
      }
      .guidance .action-row {
        justify-content: flex-start;
      }
      .testimonials {
        background: #032f19;
        color: #fff;
        padding: 80px 0;
      }
      .test-head {
        width: 1112.93px;
        margin: auto;
        display: grid;
        grid-template-columns: 631.66px 1fr;
        gap: 48.13px;
      }
      .test-head h2 {
        font-size: 55px;
        margin: 33.09px 0 0;
        letter-spacing: -0.5px;
      }
      .test-head h2 span {
        color: #9bd267;
      }
      .test-head p {
        font-size: 21.06px;
        font-weight: 400;
        line-height: 1.45;
        color: #c0d1c7;
        margin: 0;
      }
      .review-grid {
        width: 1112.93px;
        margin: 51.13px auto 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 39.1px;
      }
      .review {
        height: 303.8px;
        background: #fff;
        color: #102c23;
        border-radius: 12.03px;
        padding: 30.08px 33.09px 21.06px;
      }
      .review h4 {
        font-size: 21.06px;
        color: #13814a;
        font-style: italic;
        margin: 0 0 21.06px;
      }
      .review blockquote {
        font: 22px "IBM Plex Sans", Arial, sans-serif;
        font-weight: 500;
        margin: 0;
        height: 147.39px;
      }
      .person {
        display: flex;
        gap: 18.05px;
        align-items: center;
        font-size: 13.54px;
        color: #263d34;
      }
      .person img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10%;
      }
      .person b {
        font-size: 18.05px;
        display: block;
      }
      .faq {
        background: #fff;
        padding: 50px 0;
      }
      .faq-inner {
        width: 1112.93px;
        margin: auto;
        display: grid;
        grid-template-columns: 505.33px 1fr;
        gap: 72.19px;
      }
      .faq-left {
        position: relative;
        padding-left: 171.45px;
      }
      .question-mark {
        position: absolute;
        left: -20px;
        top: 0;
        font:
          445.17px/1 "Roboto Condensed",
          sans-serif;
        color: #a8dc75;
        font-weight: 200;
        transform-origin: left top;
      }
      .faq h2 {
        font-size: 60.16px;
        line-height: 0.95;
        margin: 9.02px 0 42.11px;
        letter-spacing: -0.18.05px;
      }
      .faq-left p {
        font-size: 21.06px;
        line-height: 1.45;
        color: #72857c;
        margin: 0;
      }
      .accordion {
        padding-top: 9.02px;
      }
      .acc-item {
        border-bottom: 3.01px solid #d7dcda;
      }
      .acc-btn {
        width: 100%;
        height: 54.14px;
        border: 0;
        background: none;
        padding: 0;
        text-align: left;
        font: 600 19.55px "IBM Plex Sans", Arial, sans-serif;
        color: #152d24;
        cursor: pointer;
        position: relative;
      }
      .acc-btn:after {
        content: "+";
        position: absolute;
        right: 3.01px;
        font: 30.08px Arial;
        top: 12.03px;
      }
      .acc-item.open .acc-btn:after {
        content: "−";
      }
      .acc-panel {
        display: none;
        font-size: 16.54px;
        font-weight: 400;
        line-height: 1.35;
        color: #77867f;
        padding: 3.01px 6.02px 15.04px;
      }
      .acc-item.open .acc-panel {
        display: block;
      }
      .quote-section {
        height: 1100.9px;
        position: relative;
        background-image: none;
        background-size: cover;
        background-position: center;
      }
      .quote-panel {
        position: absolute;
        left: 442.16px;
        top: 48.13px;
        width: 1025.7px;
        height: 983.59px;
        border-radius: 36.09px;
        background: linear-gradient(
          115deg,
          rgba(10, 27, 22, 0.91),
          rgba(42, 29, 23, 0.89)
        );
        border: 3.01px solid #dde7d8aa;
        box-shadow: 0 30.08px 90.24px #0005;
        color: #fff;
        padding: 51.13px 33.09px 30.08px;
      }
      .brand {
        text-align: center;
        color: #96e548;
        font-size: 42.11px;
        font-weight: 700;
        line-height: 0.8;
        margin-bottom: 33.09px;
      }
      .brand small {
        display: block;
        color: #fff;
        font-size: 18.05px;
        font-weight: 400;
      }
      .quote-panel h2 {
        font-size: 36.09px;
        text-align: center;
        margin: 0;
        line-height: 1.1;
      }
      .quote-panel .sub {
        font-size: 24.06px;
        text-align: center;
        margin: 6.02px 0 36.09px;
        color: #eee;
      }
      .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 27.07px 39.1px;
      }
      .field label {
        display: block;
        font:
          16.54px "IBM Plex Sans", Arial,
          sans-serif;
        margin-bottom: 9.02px;
        color: #fff;
      }
      .field label span {
        color: #ff7676;
      }
      .field input,
      .field select {
        width: 100%;
        height: 54.14px;
        background: #ffffff08;
        border: 3.01px solid #ffffff7a;
        border-radius: 6.02px;
        color: #fff;
        padding: 0 18.05px;
        font:
          18.05px "IBM Plex Sans", Arial,
          sans-serif;
        outline: none;
      }
      .field input::placeholder {
        color: #fff;
      }
      .field.full {
        grid-column: 1/-1;
      }
      .three {
        grid-column: 1/-1;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 27.07px;
      }
      .disclaimer {
        font:
          12.03px/1.3 "IBM Plex Sans", Arial,
          sans-serif;
        color: #ddd;
        margin: 30.08px 0 21.06px;
      }
      .submit {
        width: 100%;
        height: 57.15px;
        border: 0;
        border-radius: 6.02px;
        background: #74df09;
        color: #0a3520;
        font: 700 21.06px "IBM Plex Sans", Arial, sans-serif;
        cursor: pointer;
      }
      .cta {
        height: 436.15px;
        position: relative;
        padding-top: 69.18px;
        margin-bottom: -150px;
        z-index: 1;
      }
      .cta-card {
        width: 1133.98px;
        margin: auto;
        border-radius: 45.12px;
        border: 9.02px solid #edf6df;
        background: #fff;
        box-shadow: 0 30.08px 60.16px #1d4c2624;
        display: grid;
        grid-template-columns: 288.76px 1fr;
        gap: 51.13px;
        align-items: center;
        padding: 36.09px 42.11px;
      }
      .cta-card img {
        width: 288.76px;
        height: 264.7px;
        object-fit: cover;
        border-radius: 45.12px;
        border: 9.02px solid #deeed2;
      }
      .cta-card h2 {
        font-size: 55px;
        font-weight: 600;
        color: #032f1a;
        margin: 0 0 21.06px;
        letter-spacing: -0.5px;
      }
      .cta-card p {
        font-size: 21.06px;
        font-weight: 400;
        line-height: 1.45;
        color: #708177;
        margin: 0 0 24.06px;
      }
      .cta-card .btn {
        background: #00452b;
        color: #fff;
      }
      .footer {
        background: #f4faef;
        position: relative;
        padding: 200px 0 50px 0;
        color: #0a3d29;
        overflow: hidden;
      }
      .footer:before {
        content: "";
        position: absolute;
        width: 382.01px;
        height: 382.01px;
        border: 75.2px solid #a9dc75;
        border-radius: 50%;
        right: -165.44px;
        top: 96.25px;
      }
      .footer:after {
        content: "";
        position: absolute;
        width: 156.41px;
        height: 156.41px;
        border: 51.13px solid #003f28;
        border-radius: 50%;
        left: -117.31px;
        bottom: 21.06px;
      }
      .footer-brand {
        font-size: 45.12px;
        font-weight: 700;
        text-align: center;
        line-height: 0.75;
        position: relative;
        z-index: 2;
      }
      .footer-brand small {
        display: block;
        font-size: 18.05px;
        font-weight: 400;
      }
      .footer-columns {
        width: 779.05px;
        margin: 93.25px auto 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 129.34px;
        position: relative;
        z-index: 2;
      }
      .footer h4 {
        font-size: 21.06px;
        text-transform: uppercase;
        margin: 0 0 21.06px;
      }
      .footer ul {
        list-style: none;
        margin: 0;
        padding: 0;
        font-size: 16.54px;
        line-height: 2;
        color: #6f8178;
      }
      .social {
        text-align: center;
        font-size: 21.06px;
        letter-spacing: 27.07px;
        margin-top: 30.08px;
        position: relative;
        z-index: 2;
      }
      .copyright-line {
        text-align: center;
        font-size: 15.04px;
        margin-top: 27.07px;
        position: relative;
        z-index: 2;
      }
      .legal {
        width: 1112.93px;
        text-align: center;
        font:
          13.54px/1.4 Arial,
          sans-serif;
        color: #4f665b;
        margin: 39.1px auto 0;
        position: relative;
        z-index: 2;
      }
      .bottom {
        height: 45.12px;
        background: #003e28;
        color: #afc8bb;
        text-align: center;
        font: 15.04px "IBM Plex Sans", Arial, sans-serif;
        line-height: 45.12px;
      }

      @media (max-width: 1199px) {
        html {
          background: #fff;
        }
        body {
          width: 1140px;
          min-width: 1140px;
          overflow-x: hidden;
        }
        .page {
          width: 1140px;
          max-width: 1140px;
        }
      }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        .main {
            width: 100%;
            background-image: url('https://easyacacoverage.com/wp-content/uploads/2024/10/image-3-1.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .inner-wraper {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 50px 0;
            height: auto;
        }

        .inner-wraper .inner-2 {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            border-radius: 30px;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid #e0e0e0;
            backdrop-filter: blur(50px);
        }

        .quote-section form {
            margin-top: 30px;
            width: 100%;
			border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .quote-section label, .quote-section legend {
            display: block;
            padding: 2px 8px;
            margin-bottom: 8px;
            color: #000;
			font-family: 'Montserrat';
			font-size: 16px;
			font-weight: 500;
            margin-left: 15px;
            margin-bottom: -10px;
            background: rgb(255, 255, 255);
            border-radius: 5px;
            z-index: 1;
        }

        .GENDER, .HOUSEHOLDSIZE, .ADDRESS, .HOUSEHOLDINCOME {
            width: 48%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .quote-section input, .quote-section select {
            display: block;
            width: 100%;
            padding: 18px 12px 12px 12px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #fff;
            border-radius: 5px;
            background: transparent;
			color: #fff;
			font-family: 'Montserrat';
			font-size: 14px;
        }
		
        .quote-section option {
            color: #000;
        }

        .quote-section button {
            background-color: #7ED218;
            color: #202020;
            padding: 15px 70px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            width: 100%;
            font-size: 20px;
            font-weight: 600;
            margin-top: 15px;
			transition: .3s;
            box-shadow: 0px 4px 25px 0px rgba(126.00000000000021, 209.99999999999994, 24.000000000000046, 0.4);
        }

        .quote-section button:hover {
            background-color: #fff;
			color: #202020;
			transition: .3s;
        }

        .signature {
            text-align: center;
            color: #555;
            font-size: 10px;
        }
        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .top1 {
            font-family: 'Montserrat';
            font-size: 70px;
            font-weight: 300;
            text-align: center;
            color: #fff;
        }
        .top2 {
            font-family: 'Montserrat';
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            color: #fff;
        }
        .top3 {
            font-family: 'Montserrat';
            font-size: 20px;
            font-weight: 400;
            text-align: center;
            color: #fff;
        }
        .form-content {
            width: 100%;
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
			justify-content: space-between;
			gap: 0px;
        }
		.form-content .FNAME, .form-content .LNAME, .form-content .PHONE, .form-content .EMAIL {
			width: 48%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
		}
		.form-content .DOB {
			width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
		}
		.form-content .STATE, .form-content .CITY, .form-content .ZIP {
			width: 31.5%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
		}
        .quote-section h1 {
            font-family: 'Montserrat';
            font-size: 20px;
            font-weight: 500;
            text-align: left;
            color: #c0c0c0;
            margin: 0;
        }
        .tcp p {
            font-family: 'Montserrat';
            font-size: 12px;
            font-weight: 400;
            color: #c0c0c0;
            line-height: 1.5em;
        }

        .tcp p a {
            color: #7ED218;
        }
		
		@media only screen and (max-width: 600px) {
            .main {
                width: 100%;
            }
            .inner-wraper {
                flex-direction: column;
                height: auto;
            }
            .inner-wraper .inner-1 {
                width: 100%;
            }
            .inner-wraper .inner-2 {
                width: 85%;
            }
            .inner-wraper .inner-1 {
                height: 40vh;
            }
            .inner-wraper .inner-2 {
                padding: 20px;
                border-radius: 10px;
            }
            .inner-wraper .inner-2 .logo picture {
                width: 40% !important;
            }
            .quote-section form {
                gap: 20px;
            }
			.quote-section h1 {
				font-size: 16px;
			}
			.top2 {
				font-size: 24px;
				line-height: 1.2em;
			}
			.form-content .FNAME, .form-content .LNAME, .form-content .PHONE, .form-content .EMAIL {
				width: 100%;
			}
			.form-content .STATE, .form-content .CITY, .form-content .ZIP {
				width: 100%;
			}
            .quote-section label {
                font-size: 14px;
            }
			.quote-section input {
				padding: 12px;
				margin-bottom: 15px;
			}

			.tcp p {
				margin: 0 0 10px 0;
			}
			.quote-section .button {
				margin-top: 0px;
			}
		}
    </style>
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MRQQ73S5');</script>
<!-- End Google Tag Manager -->
  </head>
  <body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MRQQ73S5"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <main class="page">
      <div class="notice">Find the perfect ACA health plan in just minutes</div>
      <section class="hero">
        <div class="top-card">
          <img
            class="logo-crop"
            src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-3655.webp"
            alt="Easy ACA Coverage"
          />
          <div class="phone">
            <span class="icon">☎</span
            ><span>Speak with License Agent Now!<b>+1 844-457-3715</b></span>
          </div>
        </div>
        <div class="hero-copy">
          <h1 class="hero-title">
            Find <span class="lime">Affordable</span>
            <img
              class="avatars"
              src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-2-26.webp"
              alt="Happy customers"
            />
            ACA<br />Health Plans <em>Today!</em>
          </h1>
          <div class="explore">
            Explore a range of<br />Affordable ACA health plans
          </div>
        </div>
        <p class="hero-body">
          Find the right coverage effortlessly with our expert guidance and
          comparison tools, Customized for you and your family.
        </p>
        <img
          class="hero-family"
          src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-4.webp"
          alt="Father and daughter"
        />
        <aside class="trust">
          <span class="arrow">↗</span><b>TRUSTED<br />GUIDANCE</b>
          <p>
            Join thousands who trust us for expert support, ensuring simple,
            reliable ACA coverage for their families.
          </p>
        </aside>
      </section>
      <section class="intro" id="coverage">
        <h2>Get ACA Coverage in Minutes Today</h2>
        <h3>
          Affordable plans customized for you. Simple, quick, and stress-free.
        </h3>
        <p>
          Complete our easy form to compare ACA plans, explore your options, and
          secure affordable health coverage in just minutes. Our experts are
          here to guide you every step.
        </p>
        <div class="action-row">
          <a class="btn" href="#quote">Get Covered Now</a
          ><span class="line-arrow"></span>
        </div>
      </section>
      <section class="works">
        <div class="works-head">
          <h2>How It <span>Works...</span></h2>
          <p>
            Explore plans, compare options, and enroll in affordable ACA
            coverage with our simple, guided process, designed to make health
            insurance stress-free.
          </p>
        </div>
        <div class="cards">
          <article class="card">
            <img
              src="https://easyacacoverage.com/wp-content/uploads/2026/07/Rectangle-9.webp"
              alt="Entering a ZIP code"
            /><span class="mini-icon">
                <img
                    src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-14.webp"
                    alt="Entering a ZIP code"
                />
            </span>
            <h4>What’s Your Zip Code?</h4>
            <p>
              Pop in your zip code to check out health plans available in your
              area.
            </p>
          </article>
          <article class="card">
            <img
              src="https://easyacacoverage.com/wp-content/uploads/2026/07/Rectangle-9-1.webp"
              alt="Discussing plan details"
            /><span class="mini-icon">
                <img
                    src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-14-1.webp"
                    alt="Entering a ZIP code"
                />
            </span>
            <h4>A Little About You</h4>
            <p>
              Tell us a bit about yourself so we can find plans that fit your
              needs perfectly.
            </p>
          </article>
          <article class="card">
            <img
              src="https://easyacacoverage.com/wp-content/uploads/2026/07/Rectangle-9-2.webp"
              alt="Comparing plan options"
            /><span class="mini-icon">
                <img
                    src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-14-2.webp"
                    alt="Entering a ZIP code"
                />
            </span>
            <h4>Compare with Confidence</h4>
            <p>
              Options from top brokers to discover the best coverage for your
              budget.
            </p>
          </article>
        </div>
      </section>
      <section class="guidance">
        <div class="guidance-inner">
          <img
            src="https://easyacacoverage.com/wp-content/uploads/2026/07/image-2-1.webp"
            alt="Happy family"
          />
          <div>
            <h2>Expert Guidance Every Step Forward</h2>
            <h3>
              Your trusted partner for stress-free<br />health coverage
              solutions.
            </h3>
            <p>
              Our licensed agents are here to support you at every stage. From
              exploring ACA plans to finding specialized options, we’ll help you
              secure the perfect coverage for your family.
            </p>
            <div class="action-row">
              <a class="btn" href="#quote">Get Covered Now</a
              ><span class="line-arrow"></span>
            </div>
          </div>
        </div>
      </section>
      <section class="testimonials">
        <div class="test-head">
          <h2>Preferred by <span>Our Clients</span></h2>
          <p>
            We’ve helped hundreds find the ideal health plan, with many
            benefiting from substantial savings and great value in their
            selected plans.
          </p>
        </div>
        <div class="review-grid">
          <article class="review">
            <h4>Highly Recommend for ACA Plans</h4>
            <blockquote>
              easyacacoverage.com made it easy to compare ACA plans in minutes.
              I found a Gold plan that lowered my out-of-pocket costs, and the
              customer support was excellent!
            </blockquote>
            <div class="person">
              <img
                src="https://easyacacoverage.com/wp-content/uploads/2024/10/Rectangle-4093-2.png"
                alt="Parker"
              /><span><b>Parker</b>United States, New York City</span>
            </div>
          </article>
          <article class="review">
            <h4>Perfect Plan for My Family</h4>
            <blockquote>
              The process was quick and easy. I found an affordable health plan
              for my family with great coverage. The licensed agent answered all
              my questions and made the decision simple.
            </blockquote>
            <div class="person">
              <img
                src="https://easyacacoverage.com/wp-content/uploads/2024/10/Rectangle-4093-1.png"
                alt="Willow"
              /><span><b>Willow</b>United States, New York City</span>
            </div>
          </article>
        </div>
      </section>
      <section class="faq">
        <div class="faq-inner">
          <div class="faq-left">
            <div class="question-mark">
                <img
                src="https://easyacacoverage.com/wp-content/uploads/2026/07/Frame-4212.webp"
                alt="Willow"
              />
            </div>
            <h2>Frequently<br />Asked<br />Question...</h2>
            <p>
              Explore our FAQs for answers to common queries about ACA
              subsidies, eligibility, and our process.
            </p>
          </div>
          <div class="accordion">
            <div class="acc-item open">
              <button class="acc-btn">
                1. What is ACA insurance, and who qualifies?
              </button>
              <div class="acc-panel">
                ACA insurance, or Affordable Care Act coverage, offers
                affordable health plans with essential benefits. It’s available
                to individuals, families, and small businesses, regardless of
                pre-existing conditions.
              </div>
            </div>
            <div class="acc-item">
              <button class="acc-btn">
                2. How do I know if I’m eligible for subsidies?
              </button>
              <div class="acc-panel">
                Subsidies are based on household income and size.
              </div>
            </div>
            <div class="acc-item">
              <button class="acc-btn">
                3. Can I enroll in ACA coverage anytime?
              </button>
              <div class="acc-panel">
                Enrollment is generally during open enrollment, with special
                enrollment for qualifying life changes.
              </div>
            </div>
            <div class="acc-item">
              <button class="acc-btn">
                4. What if I already have health insurance?
              </button>
              <div class="acc-panel">
                You can still compare ACA options to evaluate value and
                coverage.
              </div>
            </div>
            <div class="acc-item">
              <button class="acc-btn">
                5. How long does it take to enroll?
              </button>
              <div class="acc-panel">
                The guided process can take only a few minutes.
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="quote-section" id="quote">
        <div class="main">
            <div class="wraper">
                <div class="inner-wraper">
                    <div class="inner-2">
                        <div class="logo">
                            <picture 
                            style="display: flex;
                            flex-direction: column;
                            flex-wrap: nowrap;
                            margin: 0px 0px 20px 0px;
                            width: 25%;" >
                                <source type="image/webp" srcset="https://easyacacoverage.com/wp-content/uploads/2024/10/Group-3655-1.png">
                                <img src="https://easyacacoverage.com/wp-content/uploads/2024/10/Group-3655-1.png" alt="Logo" style="width: 100%"/>
                            </picture>
                        </div>
                        <span class="top2">ACA Benefits Plans</span>
                        <h1>Get Consultation Now!</h1>
                        <form id="leadForm" action='' method='post'>
                            <div class="form-content">
                                <input type='hidden' value='f1d229d9726b45cd8c46b2b09a1d8f45' name='lead_token'>
                                <input type='hidden' value='1161' name='traffic_source_id'>
                                <input type='hidden' value='' name='source_url'>
                                <input type='hidden' id="ip-address" value='' name='ip_address'>
                                <input type='hidden' id="ip-region" value='' name='ip_region'>
                                <input type='hidden' id="ip-city" value='' name='ip_city'>
                                <input type='hidden' id="ip-country" value='' name='ip_country'>
                                <input type='hidden' id='timestamp' name='original_lead_submit_date' value=''>
                                <input type="hidden" id="trackdriveResponse" name="trackdrive_response" value="">

                                <div class="FNAME">
                                    <label for="firstName">First Name: <span style="color: red;">*</span></label>
                                    <input type="text" id="firstName" name="first_name" required>
                                </div>

                                <div class="LNAME">
                                    <label for="lastName">Last Name: <span style="color: red;">*</span></label>
                                    <input type="text" id="lastName" name="last_name" required>
                                </div>
                                
                                <div class="PHONE">
                                    <label for="phoneNumber">Phone Number: <span style="color: red;">*</span></label>
                                    <input type="tel" id="phoneNumber" name="caller_id" required>
                                </div>
                                
                                <div class="EMAIL">
                                    <label for="email">Email Address: <span style="color: red;">*</span></label>
                                    <input type="email" id="email" name="email" required>
                                </div>
                                
                                <div class="DOB">
                                    <label for="dob">Date of Birth (MM-DD-YYYY): <span style="color: red;">*</span></label>
                                    <input type="text" id="dob" name="dob" required>
                                </div>

                                <div class="GENDER">
                                    <label>Gender: <span style="color: red;">*</span></label>
                                    <select name="gender" id="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="HOUSEHOLDSIZE">
                                    <label for="house_hold_size">Household Size: <span style="color: red;">*</span></label>
                                    <input type="text" id="house_hold_size" name="house_hold_size" required>
                                </div>

                                <div class="HOUSEHOLDINCOME">
                                    <label for="house_hold_income">Household Income: <span style="color: red;">*</span></label>
                                    <input type="text" id="house_hold_income" name="house_hold_income" required>
                                </div>

                                <div class="ADDRESS">
                                    <label for="address">Address: <span style="color: red;">*</span></label>
                                    <input type="text" id="address" name="address" required>
                                </div>

                                <div class="STATE">
                                    <label for="state">State: <span style="color: red;">*</span></label>
                                    <input type="text" id="state" name="state" required>
                                </div>
                                
                                <div class="CITY">
                                    <label for="city">City: <span style="color: red;">*</span></label>
                                    <input type="text" id="city" name="city" required>
                                </div>
                                
                                <div class="ZIP">
                                    <label for="zip">Zip Code: <span style="color: red;">*</span></label>
                                    <input type="text" id="zip" name="zip" required>
                                </div>
                                
                                
                                <input id="trusted_form_cert_url" name="trusted_form_cert_url" type="hidden" value=""/>
                                <input id="leadid_token" name="jornaya_leadid" type="hidden" value=""/>

                                <div class="tcp">
                                    <p>By clicking "Submit" below, I am providing my ESIGN signature and express written consent agreement to permit Easy ACA Coverage, and partners calling on their behalf, to contact me at the number provided above for marketing purposes in order to provide brokerage services to connect me with a advocate. I understand that these calls and/or SMS/MMS messages include those using automated technology, AI generative voice, and prerecorded and/or artificial voice messages. I confirm that the phone number above is accurate, and I am the regular user of that phone. I also agree to Easy ACA Coverage's SMS <a href="https://easyacacoverage.com/terms-of-use/" traget="_black">Terms & Conditions</a>. and <a href="https://easyacacoverage.com/privacy-policy/" traget="_black">Privacy Policy</a>. For SMS messages campaigns, text “STOP” to stop and “HELP” for help. Msg & data rates may apply. I acknowledge that my consent is not required to obtain any good or service, and to contact Easy ACA Coverage without providing consent I can call on +1 844-457-3715.</p>
                                </div>
                                
                                <button type="button" id="submitButton" class="assist" onclick="submitForm()">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </section>
      <section class="cta">
        <div class="cta-card">
          <img
            src="https://easyacacoverage.com/wp-content/uploads/2026/07/image.webp"
            alt="Man comparing health plans"
          />
          <div>
            <h2>Get Your Free Quote Today!</h2>
            <p>
              Start comparing health insurance plans customized to your needs
              and budget. Our quick, easy process helps you find the best
              coverage in minutes.
            </p>
            <a class="btn" href="#quote">Get Covered Now</a>
          </div>
        </div>
      </section>
      <footer class="footer">
        <div class="footer-brand">
            <img src="https://easyacacoverage.com/wp-content/uploads/2026/07/Group-3655-1.webp" alt="">
        </div>
        <div class="footer-columns">
          <div>
            <h4>Quick Links:</h4>
            <ul>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Terms of Use</a></li>
              <li><a href="#quote">Contact Us</a></li>
            </ul>
          </div>
          <div>
            <h4>Contact</h4>
            <ul>
              <li>☎ +1 844-457-3715</li>
              <li>✉ support@easyacacoverage.com</li>
              <li>◷ 24/7 Support</li>
            </ul>
          </div>
        </div>
        <div class="copyright-line">
          © 2024, Easy ACA Coverage, All Rights Reserved.
        </div>
        <p class="legal">
          EasyACACoverage is an independent marketplace and is not affiliated
          with any federal or state Marketplace websites, nor does it directly
          sell insurance, provide quotes, or act as a licensed agent or broker.
          Please do not send personal data or applications via mail or email, as
          these will not be considered confidential. It is not endorsed by the
          U.S. government or Medicare.
        </p>
      </footer>
      <div class="bottom">© Copyright 2026 All Rights Reserved</div>
    </main>
    <script>
      function fitDesktopCanvas() {
        const desktopWidth = 1140;
        const scale = Math.min(1, window.innerWidth / desktopWidth);
        document.body.style.zoom = String(scale);
      }
      fitDesktopCanvas();
      window.addEventListener("resize", fitDesktopCanvas);
      document.querySelectorAll(".acc-btn").forEach((btn) =>
        btn.addEventListener("click", () => {
          const item = btn.parentElement;
          document.querySelectorAll(".acc-item").forEach((x) => {
            if (x !== item) x.classList.remove("open");
          });
          item.classList.toggle("open");
        }),
      );
    </script>
    <script id="LeadiDscript" type="text/javascript">
        (function() {
        var s = document.createElement('script');
        s.id = 'LeadiDscript_campaign';
        s.type = 'text/javascript';
        s.async = true;
        s.src = '//create.lidstatic.com/campaign/11209397-31bc-376b-ac50-52df4acc79c5.js?snippet_version=2&f=reset';
        var LeadiDscript = document.getElementById('LeadiDscript');
        LeadiDscript.parentNode.insertBefore(s, LeadiDscript);
        })();
        </script>
        <noscript><img src='//create.leadid.com/noscript.gif?lac=CF4996BF-EAEF-6727-187B-F7D19ACD91A7&lck=11209397-31bc-376b-ac50-52df4acc79c5&snippet_version=2' /></noscript>
        <!-- For Jornaya -->
        
        <!-- TrustedForm -->
        <script type="text/javascript">
        (function() {
        var tf = document.createElement('script');
        tf.type = 'text/javascript'; tf.async = true;
        tf.src = ("https:" == document.location.protocol ? 'https' : 'http') + "://api.trustedform.com/trustedform.js?field=trusted_form_cert_url&ping_field=TrustedFormPingUrl&l=" + new Date().getTime() + Math.random();
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(tf, s);
        })();
        </script>
        <noscript>
        <img src="https://api.trustedform.com/ns.gif" />
        </noscript>

    
    <!----------SCRIPT FOR DOB FORMAT-------->
<script>
    $(document).ready(function() {
		$.get("https://ipinfo.io?token=2bd961e828ebfa", function(response) {
			$("#ip-address").val(response.ip);
			$("#ip-region").val(response.region);
			$("#ip-city").val(response.city);
			$("#ip-country").val(response.country);
		});
		
		$("input[name='source_url']").val(window.location.href);
		
		const now = new Date();
		const formattedTimestamp = now.getFullYear() + '-' +
			('0' + (now.getMonth() + 1)).slice(-2) + '-' +
			('0' + now.getDate()).slice(-2) + ' ' +
			('0' + now.getHours()).slice(-2) + ':' +
			('0' + now.getMinutes()).slice(-2) + ':' +
			('0' + now.getSeconds()).slice(-2);
		$("#timestamp").val(formattedTimestamp);
		
        $("#dob").on("input", function() {
            var dobValue = $(this).val();
            var formattedDob = dobValue.replace(/\D/g, '').replace(/(\d{2})(\d{2})?(\d{0,4})?/, '$1-$2-$3').replace(/--/, '-');
            $(this).val(formattedDob);
        });

        $("#submitButton").on("click", function(e) {
            e.preventDefault();

            var dobValue = $("#dob").val();
            var dobParts = dobValue.split("-");
            if (dobParts.length === 3) {
                var yyyy = dobParts[2];
                var mm = dobParts[0];
                var dd = dobParts[1];
                var formattedDob = yyyy + "-" + mm + "-" + dd;
                $("#dob").val(formattedDob);
            }
            
            let valid = true;
            
            // Validate only visible and non-hidden fields
            $('#leadForm input').filter(":visible").each(function () {
                if ($(this).val().trim() === '') {
                    valid = false;
                    return false; // Exit each loop if a field is invalid
                }
            });

            if (!valid) {
                alert('Please fill out all required fields.');
                return;
            }

            let formData = $("#leadForm").serialize();

            $.ajax({
                url: '', // PHP file handling the POST request
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON response from server
                success: function (response) {
                    // Handle the response
                    if (response.status === "success") {
                        alert(response.message);
                        window.location.reload();
                    } else {
                        alert("Error: " + response.message); // Show error alert
                        window.location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    // Handle AJAX errors
                    alert("AJAX Error: " + error);
                }
            });
        });
    });
</script>

<!-------Trim_Space---------------->
<script>
// Add event listeners to trim spaces from input fields
document.getElementById("firstName").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("lastName").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("dob").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("state").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("city").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("zip").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("house_hold_size").addEventListener("input", function () {
    this.value = this.value.trim();
});

document.getElementById("house_hold_income").addEventListener("input", function () {
    this.value = this.value.trim();
});
</script>

  </body>
</html>