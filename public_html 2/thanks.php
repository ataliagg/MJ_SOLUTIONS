<?php
// Página de confirmación luego de enviar el formulario.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thank You | MJ Cleaning Solutions</title>
  <meta name="robots" content="noindex, nofollow" />
  <style>
    :root {
      --bg: #07111a;
      --bg-2: #0f172a;
      --card: rgba(255, 255, 255, 0.96);
      --line: rgba(15, 23, 42, 0.1);
      --text: #102133;
      --muted: #5b6b7d;
      --brand: #0f766e;
      --brand-dark: #115e59;
      --accent: #38bdf8;
      --shadow: 0 30px 80px rgba(2, 8, 23, 0.3);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      font-family: Arial, Helvetica, sans-serif;
      color: var(--text);
      background:
        radial-gradient(circle at top left, rgba(56, 189, 248, 0.28), transparent 28%),
        radial-gradient(circle at bottom right, rgba(15, 118, 110, 0.26), transparent 30%),
        linear-gradient(135deg, var(--bg) 0%, var(--bg-2) 58%, #071827 100%);
      display: grid;
      place-items: center;
      padding: 24px;
    }

    .wrap {
      width: 100%;
      max-width: 760px;
    }

    .card {
      position: relative;
      overflow: hidden;
      background: var(--card);
      border: 1px solid rgba(255, 255, 255, 0.35);
      border-radius: 28px;
      padding: 44px;
      box-shadow: var(--shadow);
      backdrop-filter: blur(14px);
    }

    .card::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(56, 189, 248, 0.08), transparent 35%, rgba(15, 118, 110, 0.08));
      pointer-events: none;
    }

    .topline {
      position: relative;
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 26px;
      color: var(--brand-dark);
      font-weight: 700;
      letter-spacing: 0.04em;
      text-transform: uppercase;
      font-size: 12px;
    }

    .badge {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--brand), var(--accent));
      color: white;
      display: grid;
      place-items: center;
      font-size: 24px;
      box-shadow: 0 12px 30px rgba(15, 118, 110, 0.28);
      flex: 0 0 auto;
    }

    .hero {
      position: relative;
      display: grid;
      gap: 22px;
    }

    h1 {
      font-size: clamp(34px, 6vw, 58px);
      line-height: 0.98;
      letter-spacing: -0.04em;
      color: #0b1f2c;
      max-width: 12ch;
    }

    .lead {
      font-size: 18px;
      line-height: 1.7;
      color: var(--muted);
      max-width: 58ch;
    }

    .status {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 12px 16px;
      width: fit-content;
      border-radius: 999px;
      background: rgba(15, 118, 110, 0.08);
      color: var(--brand-dark);
      font-weight: 700;
    }

    .status-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: var(--brand);
      box-shadow: 0 0 0 6px rgba(15, 118, 110, 0.14);
    }

    .grid {
      position: relative;
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 16px;
      margin-top: 30px;
    }

    .info {
      border: 1px solid var(--line);
      background: rgba(255, 255, 255, 0.9);
      border-radius: 18px;
      padding: 18px;
    }

    .label {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #789;
      margin-bottom: 8px;
      font-weight: 700;
    }

    .value {
      font-size: 15px;
      line-height: 1.5;
      color: var(--text);
      font-weight: 700;
      word-break: break-word;
    }

    .actions {
      position: relative;
      margin-top: 30px;
      display: flex;
      gap: 14px;
      flex-wrap: wrap;
    }

    .btn {
      text-decoration: none;
      padding: 14px 22px;
      border-radius: 999px;
      font-weight: 700;
      transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-height: 48px;
    }

    .btn:hover {
      transform: translateY(-2px);
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--brand), var(--brand-dark));
      color: #fff;
      box-shadow: 0 14px 30px rgba(15, 118, 110, 0.24);
    }

    .btn-secondary {
      background: #eef4f7;
      color: #12334a;
      border: 1px solid rgba(18, 51, 74, 0.08);
    }

    .foot {
      position: relative;
      margin-top: 18px;
      color: rgba(255, 255, 255, 0.72);
      text-align: center;
      font-size: 13px;
    }

    @media (max-width: 720px) {
      .card {
        padding: 30px 22px;
      }

      .grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <main class="wrap">
    <section class="card">
      <div class="topline">
        <div class="badge">✓</div>
        <span>Request received</span>
      </div>

      <div class="hero">
        <div class="status">
          <span class="status-dot" aria-hidden="true"></span>
          Message sent successfully
        </div>
        <h1>Thanks for reaching out.</h1>
        <p class="lead">
          Your request is now in our inbox. A member of MJ Cleaning Solutions will review the details and follow up soon with the next steps and a quote.
        </p>
      </div>

      <div class="grid" aria-label="Contact summary">
        <div class="info">
          <div class="label">Email</div>
          <div class="value"><a href="mailto:MJG@mjcleaningsolution.com">MJG@mjcleaningsolution.com</a></div>
        </div>
        <div class="info">
          <div class="label">Phone</div>
          <div class="value">(571) 572-4720</div>
        </div>
        <div class="info">
          <div class="label">Hours</div>
          <div class="value">Monday to Friday, 8:00 AM to 6:00 PM</div>
        </div>
      </div>

      <div class="actions">
        <a class="btn btn-primary" href="/">Back to Home</a>
        <a class="btn btn-secondary" href="/contact.html">Send Another Message</a>
        <a class="btn btn-secondary" href="mailto:MJG@mjcleaningsolution.com">Email Us Directly</a>
      </div>
    </section>

    <p class="foot">MJ Cleaning Solutions</p>
  </main>
</body>
</html>
